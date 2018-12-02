<?php

namespace app\wechat\controller;

use think\Config;
use think\Controller;
use think\Request;

define("TOKEN", "weixin");//定义你公众号自己设置的token
header('content-type:text/html;charset=utf-8');

class WeChat extends Controller
{
    private $proAdrr1 = "http://139.199.62.95:8091";
    private $proAdrr2 = "http://139.199.62.95";

    private $appID = "wx23c8525078df7637";
    private $appSecret = "da3fba3d513e6a7e6f3e81bca9f1455d";

    //测试的信息
//    private $appID = "wx9e080fbf0aee06cf";
//    private $appSecret = "46deebf30c5a883bfbdec824ab9a4564";

    public function __construct()
    {
//        $this->appID = 'wx23c8525078df7637';
//        $this->appSecret = 'da3fba3d513e6a7e6f3e81bca9f1455d';
    }

    public function index(Request $request)
    {
        $echoStr = $request->get("echostr");
        if (isset($echoStr) && !empty($echoStr)) {
            if ($this->_checkSignature()) {
                echo $echoStr;
                exit;
            }
        } else {
            f_TxtLog('wx', '=================================');
            $this->selfDefineItem();
            $this->responseMsg();
        }
    }

    public function responseMsg()
    {
//        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        $postStr = file_get_contents('php://input');
        if (!empty($postStr)) {
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $RX_TYPE = trim($postObj->MsgType);
            switch ($RX_TYPE) {
                case 'event':
                    $result = $this->_receiverEvent($postObj);
                    break;
                case 'text':
                    $keyword = trim($postObj->Content);
                    $result = $this->_receiverText($postObj, $keyword);
                    break;
                default:
                    $result = '';
                    break;
            }
            echo $result;
        } else {
            echo '';
            exit;
        }
    }

    public function selfDefineItem()
    {
        $accessToken = $this->_checkAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=" . $accessToken;
        $postArr = [
            'button' => [
                [
                    'name' => urlencode('待续'),
                    'type' => 'click',
                    'key' => 'wait'
                ],
                [
                    'name' => urlencode('个人项目'),
                    'type' => 'view',
                    'sub_button' => [
                        [
                            'name' => urlencode('官网'),
                            'type' => 'view',
                            'url' => $this->proAdrr1
                        ],//第一个二级菜单
                        [
                            'name' => urlencode('商城demo'),
                            'type' => 'view',
                            'url' => $this->proAdrr2
                        ],//第二个二级菜单
                    ]
                ],//第三个一级菜单
            ]
        ];
        $postJson = urldecode(json_encode($postArr));
        f_TxtLog('wx', '$postJson:' . $postJson);
        $res = http_curl($url, 'post', 'json', $postJson);
        return $res;
    }

    private function _checkAccessToken()
    {
        $accessTokenFile = Config::get('wx_token_path');
        f_TxtLog('wx', '$accessTokenFile:' . $accessTokenFile);
        if (file_exists($accessTokenFile)) {
            $tempPath = fopen($accessTokenFile, "r") or die("Unable to open wx token file!");
            f_TxtLog('wx', '$tempPath:' . $tempPath);
            $accessTokenStr = fgets($tempPath);
            f_TxtLog('wx', '$accessTokenStr:' . $accessTokenStr);
            $accessTokenArr = explode('_tm_', $accessTokenStr);
            $accessToken = $accessTokenArr[0];
            if ($accessTokenArr[2] + $accessTokenArr[1] < time()) {//计算token是否过期
                $objRes = $this->_getAccessToken();
                $accessToken = $this->_writeTokenToFile($objRes);//返回token
            }
            return $accessToken; //返回token
        } else {
            $arrRes = $this->_getAccessToken();
            return $this->_writeTokenToFile($arrRes);//返回token
        }
    }

    private function _writeTokenToFile($arrRes)
    {
        $token_path = Config::get('wx_token_path');
        $content = $arrRes['access_token'] . '_tm_' . $arrRes['expires_in'] . '_tm_' . time();
//        $content = implode('_', $res);
        $tokenFile = fopen($token_path, "w") or die("Unable to open file!");
        fwrite($tokenFile, $content);
        fclose($tokenFile);
        return $arrRes['access_token'];
    }

    private function _getAccessToken()
    {
        $getAccessTokenUrl = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $this->appID . "&secret=" . $this->appSecret;
        $curlRes = http_curl($getAccessTokenUrl);
        return json_decode($curlRes, true);
    }

    private function _receiverEvent($object)
    {
        switch ($object->Event) {
            case "subscribe":
                $content = '欢迎关注我们的微信公众账号' . $object->FromUserName . '-' . $object->ToUserName;
                break;
            case "unsubscribe":
                $content = "期待您的下次关注！";
                break;
            default:
                $content = "";
                break;
        }
        $result = $this->_transmitText($object, $content);
        return $result;
    }

    private function _receiverText($object, $keyword)
    {
        switch ($keyword) {
            case "1":
                $content = '商城网址：' . $this->proAdrr1;
                break;
            case "2":
                $content = '官网地址：' . $this->proAdrr2;
                break;
            default:
                $content = '稍后回复您...';
                break;
        }
        $result = $this->_transmitText($object, $content);
        return $result;
    }

    private function _transmitText($object, $content)
    {
        $template = "<xml>
                        <ToUserName><![CDATA[%s]]></ToUserName>
                        <FromUserName><![CDATA[%s]]></FromUserName>
                        <CreateTime>%s</CreateTime>
                        <MsgType><![CDATA[%s]]></MsgType>
                        <Content><![CDATA[%s]]></Content>
                    </xml>";
        $msgType = "text";
        if (!is_utf8($content)) {
            $content = iconv('gb2312', 'UTF-8//IGNORE', $content);
        }
        $info = sprintf($template, $object->FromUserName, $object->ToUserName, time(), $msgType, $content);
        return $info;
    }

    private function _checkSignature()
    {
        //signature 是微信传过来的 类似于签名的东西
        $signature = $_GET["signature"];
        //微信发过来的东西
        $timestamp = $_GET["timestamp"];
        //微信传过来的值  什么用我不知道...
        $nonce = $_GET["nonce"];
        //定义你在微信公众号开发者模式里面定义的token
        $token = TOKEN;
        //三个变量 按照字典排序 形成一个数组
        $tmpArr = array(
            $token,
            $timestamp,
            $nonce
        );
        // use SORT_STRING rule
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        //哈希加密  在laravel里面是Hash::
        $tmpStr = sha1($tmpStr);
        //按照微信的套路 给你一个signature没用是不可能的 这里就用得上了
        if ($tmpStr == $signature) {
            return true;
        } else {
            return false;
        }
    }
}