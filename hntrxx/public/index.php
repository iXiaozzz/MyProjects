<?php
// [ 应用入口文件 ]
//允许跨域
header('Access-Control-Allow-Origin:' . '*');
// 定义应用目录
define('APP_PATH', __DIR__ . '/../app/');
//定义配置文件
define('CONF_PATH', __DIR__ . '/../conf/');
// 加载框架引导文件
require __DIR__ . '/../thinkphp/start.php';
