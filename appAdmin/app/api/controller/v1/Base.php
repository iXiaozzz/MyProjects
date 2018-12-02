<?php

namespace app\api\controller\v1;

use think\Controller;
use think\Request;
use think\Db;
use app\api\model\User as UserModel;
class Base extends Controller
{
    protected $checkTokenRes;
    protected $tokenStatus;
    protected $userInfo;
    public function __construct(Request $request)
    {
        parent::__construct();
        $token = $request->param('token');
        if (isset($token)&& trim($token)) {
//            $this->checkTokenRes = check_token($token);
            $userModel = new UserModel();
            $res = $userModel->queryUserInfoByToken($token);
            if($res){
                $this->userInfo = $res;
                $this->tokenStatus = check_token_v2($token);
            } else {
                $this->tokenStatus = -1;
            }
        } else {
            exit('非法请求~');
        }
    }

}
