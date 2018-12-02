<?php

use think\Route;

//Route::resource(':v1/goods', 'api/:v1.Goods');
return [
//    '__pattern__' => [
//        'name' => '\w+',
//    ],
//    '[hello]' => [
//        ':id' => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
//        ':name' => ['index/hello', ['method' => 'post']],
//    ],

    //前台页面路由
//    'home'=>['/home',['method' => 'get','ext'=>'html']],
    'article' => ['home/article/index', ['method' => 'get', 'ext' => 'html']],
    'articleFile' => ['home/article/articleFile', ['method' => 'get', 'ext' => 'html']],
    'productAndSolution' => ['home/article/productAndSolution', ['method' => 'get', 'ext' => 'html']],

    'newsAll'=> ['home/news/newsAll', ['method' => 'get', 'ext' => 'html']],
    'news' => ['home/news/index', ['method' => 'get', 'ext' => 'html']],
    'newsDetail' => ['home/news/newsDetail', ['method' => 'get', 'ext' => 'html']],
    'contact'=>['home/article/contact', ['method' => 'get', 'ext' => 'html']],
    'recruitPosition'=>['home/article/recruitPosition', ['method' => 'get', 'ext' => 'html']],

    //后台页面路由
    'adminLogin' => ['admin/login/index', ['ext' => 'html']],
    'admin' => ['admin/index/index', ['method' => 'get', 'ext' => 'html']],

    //后台管理的子页面
    'companyInfo' => ['/admin/content/companyInfo', ['method' => 'get', 'ext' => 'html']],
    'postNews' => ['/admin/content/postNews', ['method' => 'get', 'ext' => 'html']],
    'postArticle' => ['/admin/content/postArticle', ['method' => 'get', 'ext' => 'html']],

];
