<?php

namespace app\home\controller;


use think\Controller;

class Error extends Controller
{
    public function index()
    {
        return $this->fetch('./404');
    }

    public function _empty()
    {
        return $this->fetch('./404');
    }
}