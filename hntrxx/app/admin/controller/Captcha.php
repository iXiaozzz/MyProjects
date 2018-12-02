<?php

namespace app\admin\controller;


use think\Controller;

class Captcha extends Controller
{
    public function index()
    {
        return $this->fetch();
    }

    public function _empty()
    {
        return $this->fetch('./404');
    }
}
