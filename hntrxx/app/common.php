<?php
// 应用公共文件

use think\Config;
use think\Db;

/**公共方法*/
function f_QueryBySqlDebug($SqlTxt)
{
    try {
        return Db::query($SqlTxt);
    } catch (\Exception $e) {
        f_Txtlog('SQL', '[查询语句]' . $SqlTxt);
        f_Txtlog('SQL', '[错误代码]' . $e->getMessage());
        exit('查询语句出错！');
    }
}

//根据SQL打开数据集
function f_QueryBySql($SqlTxt)
{
    try {
        return Db::query($SqlTxt);
    } catch (\Exception $e) {
        f_Txtlog('SQL', '[查询语句]' . $SqlTxt . '[错误代码]' . $e->getMessage());
        exit('查询语句出错！');
    }
}

function is_utf8($str)
{
    return preg_match('//u', $str);
}

//执行SQL语句
function f_ExecSql($SqlTxt)
{
    try {
        return Db::execute($SqlTxt);
    } catch (\Exception $e) {
        f_Txtlog('SQL', '[执行语句]' . $SqlTxt);
        f_Txtlog('SQL', '[错误代码]' . $e->getMessage());
        exit('执行语句出错！');
    }
}

//取得数据表记录的某字段值
function f_GetFieldValue($SqlTxt, $FieldName)
{
    try {
        $dQuery = Db::query($SqlTxt);
        if (count($dQuery) == 1) {
            return $dQuery[0][$FieldName];
        } else if (count($dQuery) > 1) {
            f_Txtlog('System', '返回数据集大于1,取第一条返回字段值');
            return $dQuery[0][$FieldName];
        } else {
            return false;
        }
    } catch (\Exception $e) {
        f_Txtlog('SQL', '[执行语句]' . $SqlTxt);
        f_Txtlog('SQL', '[错误代码]' . $e->getMessage());
        exit('执行语句出错！');
    }
}

//将字符串转为数字类型:接受,/$/￥
function f_StrToFloat($InStr, $DefValue = 0)
{
    if (empty($InStr)) {
        return $DefValue;
    } else {
        $temStr = $InStr;
        if (strpos($temStr, ',') >= 0) {
            $temStr = str_replace(',', '', $temStr);//去掉千分位
        };
        if (strpos($temStr, '$') >= 0) {
            $temStr = str_replace('$', '', $temStr);//去掉美元符号
        };
        if (strpos($temStr, '￥') >= 0) {
            $temStr = str_replace('￥', '', $temStr);//去掉人民币符号
        }
        f_Txtlog('System', $temStr);
        try {
            $DefValue = floatval($temStr);
            if ($DefValue == 0) {
                f_Txtlog('System', '字符' . $InStr . '转数字,判断返回值:' . $DefValue . ',可能意外');
            }
            return $DefValue;
        } catch (\Exception $e) {
            f_Txtlog('System', '字符' . $InStr . '转数字,遇到意外' . $e->getMessage() . '回传默认值:' . $DefValue);
            return $DefValue;
        }
    }
}

//将日志存储为Txt文档
function f_TxtLog($LogType, $LogMsg)
{
    $filePath = Config::get('app_log_path') . $LogType . date("Y-m-d", time()) . '.txt';
    $TxtFile = fopen($filePath, "a+") or die("Unable to open file!");
    fwrite($TxtFile, PHP_EOL . date("Y-m-d H:i:s.u", time()) . '  ' . $LogMsg);
    fclose($TxtFile);
}

//密码加密
function get_md5_password($f_psssword)
{
    return md5($f_psssword . config('MD5_PRO'));
}

/**
 * @param $data
 * @param $message
 * @param array $data
 */
function respond($code, $msg, $data = array())
{
    $result = array(
        'code' => $code
    , 'msg' => $msg
    , 'data' => $data);
    return json($result);
}

//读取缓存
function getCacheData($name)
{
    return cache($name);
}

//创建文件
function createDir($path)
{
    if (!file_exists($path)) {
        mkdir($path);
    }
}

//删除文件
function deleteFile($path)
{
    return is_file($path) && unlink($path);
}

function changeImgType($type)
{
    switch ($type) {
        case 'jpeg':
            return 'jpg';
        default:
            return $type;
    }
}

/**
 * 删除目录及目录下所有文件或删除指定文件
 * @param str $path 待删除目录路径
 * @param int $delDir 是否删除目录，1或true删除目录，0或false则只删除文件保留目录（包含子目录）
 * @return bool 返回删除状态
 */
function delDirAndFile($path, $delDir = FALSE)
{
    if (file_exists($path)) {
        $handle = opendir($path);
    } else {
        return false;
    }
    if ($handle) {
        while (false !== ($item = readdir($handle))) {
            if ($item != "." && $item != "..")
                is_dir("$path/$item") ? delDirAndFile("$path/$item", $delDir) : unlink("$path/$item");
        }
        closedir($handle);
        if ($delDir)
            return rmdir($path);
    } else {
        if (file_exists($path)) {
            return FALSE;
        }
    }
}

//用CURL的POST方式请求数据
function https_request($url, $data = null)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    if (!empty($data)) {
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    }
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($curl);
    curl_close($curl);
    return $output;
}

//用CURL的POST方式请求数据 提交一个多维数组
function SendDataByCurl($url, $data = array())
{
    //对空格进行转义
    $url = str_replace(' ', '+', $url);
    $ch = curl_init();
    //设置选项，包括URL
    curl_setopt($ch, CURLOPT_URL, "$url");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_TIMEOUT, 3); //定义超时3秒钟
    // POST数据
    curl_setopt($ch, CURLOPT_POST, 1);
    // 把post的变量加上
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));  //所需传的数组用http_bulid_query()函数处理一下，就ok了
    //执行并获取url地址的内容
    $output = curl_exec($ch);
    $errorCode = curl_errno($ch);
    //释放curl句柄
    curl_close($ch);
    if (0 !== $errorCode) {
        return false;
    }
    return $output;
}

//订单生成函数
function get_orderno()
{
    return date('YmdHis') . substr(microtime(), 2, 6);
}

//转换时间的函数
function tranTime($time)
{
    $rtime = date("m-d H:i", $time);
    $htime = date("H:i", $time);
    $time = time() - $time;

    if ($time < 60) {
        $str = '刚刚';
    } elseif ($time < 60 * 60) {
        $min = floor($time / 60);
        $str = $min . '分钟前';
    } elseif ($time < 60 * 60 * 24) {
        $h = floor($time / (60 * 60));
        $str = $h . '小时前 ' . $htime;
    } elseif ($time < 60 * 60 * 24 * 3) {
        $d = ceil($time / (60 * 60 * 24));
        if ($d == 1)
            $str = '昨天 ' . $rtime;
        else
            $str = '前天 ' . $rtime;
    } else {
        $str = $rtime;
    }
    return $str;
}

//转TP5模型的数据
function tp5ModelTransfer($array)
{
    if (empty($array) || !count($array)) {
        return false;
    }
    foreach ($array as $value) {
        $datarray[] = $value->toArray();
    }
    return $datarray;
}

//过滤HTML字符串转化成纯文本
function clear_all($area_str)
{
    if ($area_str != '') {
        $area_str = trim($area_str); //清除字符串两边的空格
        $area_str = strip_tags($area_str, ""); //利用php自带的函数清除html格式
        $area_str = str_replace("&nbsp;", "", $area_str);
        $area_str = preg_replace("/   /", "", $area_str); //使用正则表达式替换内容，如：空格，换行，并将替换为空。
        $area_str = preg_replace("/
/", "", $area_str);
        $area_str = preg_replace("/
/", "", $area_str);
        $area_str = preg_replace("/
/", "", $area_str);
        $area_str = preg_replace("/ /", "", $area_str);
        $area_str = preg_replace("/  /", "", $area_str);  //匹配html中的空格
        $area_str = trim($area_str); //返回字符串
    }
    return $area_str;
}

//提取HTML字符串中img的src
function html2imgs($html)
{
    $imgs = array();
    if (empty($html)) return $imgs;

    preg_match_all("/<img[^>]+>/i", $html, $img);

    if (empty($img)) return $imgs;
    $img = $img[0];

    foreach ($img as $g) {
        $g = preg_replace("/^<img|>$/i", '', $g);//移除二头字符
        preg_match("/\ssrc\s*\=\s*\"([^\"]+)|\ssrc\s*\=\s*'([^']+)|\ssrc\s*\=\s*([^\"'\s]+)/i", $g, $src);//空格 src 可能空格 = 可能空格 "非"" 或 '非'' 或 非空白 这几种可能,下同
        $src = empty($src) ? '' : $src[count($src) - 1];//匹配到,总会放在最后

        if (empty($src)) {//空的src? 没用,跳过
            continue;
        }
        preg_match("/\salt\s*\=\s*\"([^\"]+)|\salt\s*\=\s*'([^']+)|\salt\s*\=\s*(\S+)/i", $g, $alt);
        $alt = empty($alt) ? $src : $alt[count($alt) - 1];//alt没值?用src
        preg_match("/\stitle\s*\=\s*\"([^\"]+)|\stitle\s*\=\s*'([^']+)|\stitle\s*\=\s*(\S+)/i", $g, $title);
        $title = empty($title) ? $src : $title[count($title) - 1];//title没值?用src
        $imgs[] = array('title' => $title, 'alt' => $alt, 'src' => $src);
    }

    return $imgs;
}

//wx
/**$url  接口url string
 * $type 请求类型string
 * $res  返回类型string
 * $arr= 请求参数string
 **/
function http_curl($url, $type = 'get', $dataType = 'json', $arr = [])
{
    //1.初始化curl
    $ch = curl_init();
    //2.设置curl的参数
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    if ($type == 'post') {
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $arr);
    }
    //3.采集
    $output = curl_exec($ch);
    f_TxtLog('wx', '进入了http_curl 8' . $output);
    //4.关闭
    curl_close($ch);
    return $output;
}


