<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights resulterved.
// +----------------------------------------------------------------------
// | Author: tangtanglove <dai_hang_love@126.com> <http://www.ixiaoquan.com>
// +----------------------------------------------------------------------

/**
 * 系统配文件
 * 所有系统级别的配置
 */
return [
    // application信息
    'application'               => [
        'app_name'     => 'helper',
        'app_url'      => 'http://www.xxxx.com/plugins/',
        'description'  => '此模块描述信息',
        'version'      => '1.0.0',
        'author'       => 'tangtanglove',
        'author_url'   => 'http://www.xxxx.com/',
        'license'      => 'GPL',
    ],
    // URL设置
    'url_route_on'          => true,
    // Session设置
    'session'               => [
        'prefix'     => 'minishop',
        'type'       => '',
        'auto_start' => true,
    ],
    // 模板设置
    'view_replace_str'      =>[
        'STATIC_PATH'=> __ROOT__.'/static', // 模板变量替换
        'ROOT_PATH'  => __ROOT__, // 模板变量替换
    ],
    // 助手管理密码
    'HELPER_PASSWORD' =>  'default',  // 默认助手管理密码，请一定根据自己的需求修改
];
