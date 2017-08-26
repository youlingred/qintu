<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: tangtanglove <dai_hang_love@126.com> <http://www.ixiaoquan.com>
// +----------------------------------------------------------------------

// 开启调试模式
define('APP_DEBUG', true);
// 定义应用目录
define('APP_PATH', __DIR__ . '/application/');
// 引入系统初始化文件
require __DIR__ . '/initialize.php';
// 加载框架引导文件
require __DIR__ . '/core/start.php';
// 检测程序安装
if(!is_file(ROOT_PATH . 'data/install.lock')){
	header('Location: ./install.php');
}