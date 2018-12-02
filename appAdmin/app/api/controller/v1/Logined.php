<?php

namespace app\api\controller\v1;

use think\config;
use think\Db;
use think\Request;
//use app\api\model\User as UserModel;

class Logined extends Base
{
    private $newToken;
    //空方法
    public function _empty()
    {
        return api_respond(0, '非法请求~');
    }

    public function addTokenTime(Request $request)
    {
        $actionMsg = $request->post('actionMsg');
        if ($actionMsg == 'addTokenTime') {
            if ($this->checkTokenRes['token_status'] != false) {
                return api_respond(1, '成功~', $this->checkTokenRes);
            } else {
                return api_respond(0, '请重新登录~');
            }
        } else {
            return api_respond(0, '非法请求~');
        }
    }

    public function checkTokenByDb(Request $request){
        $actionMsg = $request->post('actionMsg');
        if ($actionMsg == 'addTokenTime') {
            switch ($this->tokenStatus){
                case -1:
                    return api_respond(0, '请重新登录~');
                    break;
                case 0:
                    $this->updateToken($this->userInfo['f_id']);
                    return api_respond(1, '成功~', ['token_status'=>0,'token'=>$this->newToken]);
                    break;
                case 1:
                    return api_respond(1, '成功~', ['token_status'=>1,'token'=>$this->userInfo['f_token']]);
                    break;
                default:
                    break;
            }
        }else{
            return api_respond(0, '非法请求~');
        }
    }

    private function updateToken($uid){
        $this->newToken = create_token_v2($uid);
        Db::name('user')->where('f_id',$uid)->update(['f_token'=>$this->newToken]);
    }
}
