<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: tangtanglove <dai_hang_love@126.com> <http://www.ixiaoquan.com>
// +----------------------------------------------------------------------

// [ 应用入口文件 ]
// 开启调试模式
define('APP_DEBUG', true);
// 定义项目路径
define('APP_PATH', __DIR__ . '/application/');
// 引入系统初始化文件
require __DIR__ . '/initialize.php';
// 加载框架基础文件
require __DIR__ . '/core/base.php';
// 绑定当前入口文件到admin模块
\think\Route::bind('admin');
// 关闭admin模块的路由
\think\App::route(false);
// 执行应用
\think\App::run()->send();