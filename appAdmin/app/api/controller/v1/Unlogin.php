<?php

namespace app\api\controller\v1;

use app\api\model\User as UserModel;
use think\Controller;
use think\Db;
use think\Request;

class Unlogin extends Controller
{
    private $newToken;

    //空方法
    public function _empty()
    {
        return api_respond(0, '非法请求~');
    }

    public function login(Request $request)
    {
        $token = $request->post('token');
        $checkTokenRes = check_token($token);
        if ($checkTokenRes['token_status'] == 0 || $checkTokenRes['token_status'] == false) {
            $uname = $request->post('uname');
            $upwd = $request->post('upwd');
            if (!empty($uname) && !empty($upwd)) {
                $userInfo = UserModel::userLogin($uname, $upwd);
                if ($userInfo) {
                    $token = create_token($userInfo['f_id']);
                    $this->updateLoginTime(intval(explode('_', $token)[0]));
                    return api_respond(1, '登录成功~', ["token" => $token]);
                } else {
                    return api_respond(0, '用户名或密码错误~');
                }
            } else {
                $this->updateLoginTime(intval(explode('_', $checkTokenRes['token'])[0]));
                return api_respond(0, '非法请求~');
            }
        } else {
            $this->updateLoginTime(intval(explode('_', $token)[0]));
            return api_respond(1, '登录成功~', ["token" => $checkTokenRes['token']]);
        }
    }

    public function loginFromDb(Request $request){
        $uname = $request->post('uname');
        $upwd = $request->post('upwd');
        if (!empty($uname) && !empty($upwd)) {
            //验证账号密码
            $userInfo = UserModel::userLogin($uname, $upwd);
            if ($userInfo) {
                $token = $request->post('token');
                if(trim($token) && trim($token) === $userInfo['f_token']){
                    //验证登录时间
                    $checkRes = check_token_v2($token);
                    switch($checkRes){
                        case -1:
                            $this->updateTokenAndLoginTime($userInfo['f_id']);
                            break;
                        case 0:
                            $this->updateTokenAndLoginTime($userInfo['f_id']);
                            break;
                        case 1:
                            $this->updateLoginTime($userInfo['f_id']);//更新登陆时间
                            break;
                        default:
                            break;
                    }
                }else{
                    $this->updateTokenAndLoginTime($userInfo['f_id']);
                }
                $token = $this->newToken?$this->newToken:$token;
                return api_respond(1, '登录成功~', ["token" => $token]);
            } else {
                return api_respond(0, '用户名或密码错误~');
            }
        } else {

            return api_respond(0, '非法请求~');
        }

    }

    private function updateLoginTime($uid)
    {
        Db::name('user')->where('f_id', $uid)->update(['f_last_time' =>  date('Y-m-d H:i:s', time())]);
    }

    private function updateTokenAndLoginTime($uid){
        $this->newToken = create_token_v2($uid);
        $curTime = date('Y-m-d H:i:s',time());
        Db::name('user')->where('f_id',$uid)->update(['f_token'=>$this->newToken,'f_last_time'=>$curTime]);
    }

    public function register(Request $request)
    {
        $data = $request->post();
        $db_data = [
            "f_account" => $data['runame'],
            "f_password" => $data['rupwd'],
//            "f_last_time" => "",
        ];
        $user = new UserModel();
        if ($user->userCheck($data['runame'], $data['rupwd'])) {
            return api_respond(0, "注册失败~,用户已存在~");
        } else {
            $res = $user->userRegister($db_data);
            if ($res != false) {
                return api_respond(1, "注册成功~");
            } else {
                return api_respond(0, "注册失败~");
            }
        }
    }

    //home's api
    public function home(Request $request){
        $page = $request->post('page');
        $len = $request->post('pageSize');
        $offset = ($page-1)*$len;
        $bannerList = [
            ["img" => "http://www.youdingsoft.com/fileUploadsmall/20180119172411843341.jpg",'type'=>1],
            ["img" => "http://www.youdingsoft.com/fileUploadsmall/20180119172434968049.jpg",'type'=>1],
            ["img" => "http://www.youdingsoft.com/fileUploadsmall/20180119172503906167.jpg",'type'=>1],
            ["img" => "http://www.youdingsoft.com/fileUploadsmall/20180119172518390352.jpg",'type'=>1],
            ["img" => "http://www.youdingsoft.com/fileUploadsmall/20180119172552359735.jpg",'type'=>1],
        ];
        $goodsList = Db::query("SELECT g.f_good_id,g.f_good_name,g.f_good_intro,g.f_good_price_now,g.f_good_price_past,g.f_good_price_future,g.f_good_stock,g.f_good_sale,gi.f_good_img_path
                    FROM t_goods as g
                    LEFT JOIN t_goods_img gi ON g.f_good_id=gi.f_good_id
                    LIMIT $offset,$len");
        return api_respond(1,'获取数据成功~',['bannerList'=>$bannerList,'goodsList'=>$goodsList]);

    }

    public function homeList(Request $request){
        $page = $request->post('page');
        $len = $request->post('pageSize');
        $offset = ($page-1)*$len;
        $goodsList = Db::query("SELECT g.f_good_id,g.f_good_name,g.f_good_intro,g.f_good_price_now,g.f_good_price_past,g.f_good_price_future,g.f_good_stock,g.f_good_sale,gi.f_good_img_path
                    FROM t_goods as g
                    LEFT JOIN t_goods_img gi ON g.f_good_id=gi.f_good_id
                    LIMIT $offset,$len");
        return api_respond(1,'获取数据成功~',['goodsList'=>$goodsList]);
    }

    public function test(){
        $res = Db::query("SELECT g.f_good_id,g.f_good_name,g.f_good_intro,g.f_good_price_now,g.f_good_price_past,g.f_good_price_future,g.f_good_stock,g.f_good.sale,gi.f_good_img_path
                    FROM t_goods as g
                    LEFT JOIN t_goods_img gi ON g.f_good_id=gi.f_good_id
                    LIMIT 0,2");
        halt($res);
    }
}
