<?php

namespace app\error\controller;

use think\Controller;
use think\Request;

class Error extends Controller
{
    public function _initialize()
    {

    }

    public function _empty()
    {
        return $this->fetch('./404');
    }
}
