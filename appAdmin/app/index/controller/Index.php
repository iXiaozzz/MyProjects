<?php

namespace app\index\controller;

use think\Controller;

class Index extends Controller
{
    public function index()
    {
        return 'hello world';
//        return json([
//            'name'=>'xiao',
//            'age'=>24
//        ]);
    }


    public function love()
    {
        return $this->fetch();
    }


    public function loveHeart(){
        return $this->fetch('loveHeart');
    }

}