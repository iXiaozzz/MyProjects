<?php

namespace app\api\controller\v1;

use think\Controller;
class Error extends Controller
{
    public function index()
    {
        return '请求错误~';
    }

    public function _empty()
    {
        return '请求错误~';
//        return $this->fetch('./404');
    }
}