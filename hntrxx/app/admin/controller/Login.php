<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Session;

class Login extends Controller
{
    private $captcha;

    public function index()
    {
        return $this->fetch('login');
    }

    public function checkLoginInfo(Request $request)
    {
        $loginData = $request->param();
        if (!isset($loginData) && empty($loginData)) {
            return respond(1400, '非法登录', '');
        } else {
            $account = $loginData['account'];
            $password = $loginData['password'];
            $code = $loginData['code'];
            if (!$this->_checkCode($code)) {
                return respond(1201, '验证码错误!', '');
            }
            $res = f_QueryBySql("SELECT f_admin_id,f_admin_name FROM t_admin WHERE f_admin_account='$account' AND f_admin_pwd='$password'");
            if ($res) {
                $adminInfo = [
                    'admin_id' => $res[0]['f_admin_id']
                    , 'admin_name' => $res[0]['f_admin_name']
                ];
                Session::set('adminInfo', $adminInfo, 'admin');
                return respond(1200, '登录成功!', '');
            } else {
                return respond(1201, '用户名或密码错误!', '');
            }
        }
    }

    public function exitLogin(Request $request)
    {
        if ($request->param('request') === "exit") {
            Session::delete('adminInfo', 'admin');
            return respond(1200, "退出成功!");
        } else {
            return respond(1201, "退出失败!");
        }
    }

    private function _checkCode($code)
    {
        $this->captcha = new \think\captcha\Captcha();
        return $this->captcha->check($code);
    }
    public function _empty()
    {
        return $this->fetch('./404');
    }
}
