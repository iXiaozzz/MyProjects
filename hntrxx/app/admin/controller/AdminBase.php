<?php

namespace app\admin\controller;

use think\Controller;
use think\Session;

class AdminBase extends Controller
{
    public $adminInfo;

    public function __construct()
    {
        parent::__construct();
        // $adminInfo = [
        //     'admin_id' => 1
        //     , 'admin_name' => '王二'
        // ];
        // Session::set('adminInfo', $adminInfo, 'admin');
        if (Session::has('adminInfo', 'admin')) {
            $this->adminInfo = Session::get('adminInfo', 'admin');
        } else {
            $this->error('您未登录，请先登录！', '/adminLogin.html');
        }

    }
    public function _empty()
    {
        return $this->fetch('./404');
    }

}
