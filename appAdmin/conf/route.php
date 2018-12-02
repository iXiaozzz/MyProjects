<?php


return [
    // api版本路由  顺序不能变
    'api/:version/:controller/:function' => 'api/:version.:controller/:function',// 有方法名时
    'api/:version/:controller' => 'api/:version.:controller/index',// 省略方法名时
];