<?php
// +----------------------------------------------------------------------
// | BlocksCloud [ Building app as simple as building blocks ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.blockscloud.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: vaey
// +----------------------------------------------------------------------

// [ 安装入口 ]
// 开启调试模式
define('APP_DEBUG', true);
// 定义项目路径
define('APP_PATH', __DIR__ . '/application/');
// 引入系统初始化文件
require __DIR__ . '/initialize.php';
// 加载框架基础文件
require __DIR__ . '/core/base.php';
// 绑定当前入口文件到install模块
\think\Route::bind('install');
// 关闭admin模块的路由
\think\App::route(false);
// 执行应用
\think\App::run()->send();