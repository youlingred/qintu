<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: tangtanglove <dai_hang_love@126.com> <http://www.ixiaoquan.com>
// +----------------------------------------------------------------------

/**
 * 安装程序配置文件
 */
define('INSTALL_APP_PATH', realpath('') . '/');
return [
    'original_table_prefix' => 'mini_', //默认表前缀
    // 模板设置
    'view_replace_str'=>[
        'STATIC_PATH'=> __ROOT__.'/static', // 模板变量替换
    ],
];