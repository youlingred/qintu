<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: tangtanglove <dai_hang_love@126.com> <http://www.ixiaoquan.com>
// +----------------------------------------------------------------------

/**
 * 系统配文件
 * 所有系统级别的配置
 */
return [
    // URL设置
    'url_common_param'      =>  true,
    // Session设置
    'session'               => [
        'prefix'     => 'minishop',
        'type'       => '',
        'auto_start' => true,
    ],
    // 验证码设置
    'captcha'               =>  [
        'fontSize'    =>    30,    // 验证码字体大小
        'length'      =>    3,     // 验证码位数
        'useNoise'    =>    false, // 关闭验证码杂点
    ],
    // 多语言设置
    'lang_switch_on'        => true,   // 开启语言包功能
    'lang_list'             => ['zh-cn,zh-tw,en-us'], // 支持的语言列表
    // 模板设置
    'view_replace_str'      =>[
        'STATIC_PATH'=> __ROOT__.'/static', // 模板变量替换
    ],
    //邮箱发送配置
    'email'         =>[
        'mail_address'  => '',//邮箱地址
        'mail_port'     => '',
        'mail_smtp'     => '',//邮箱smtp服务器
        'mail_loginname'=> '',//邮箱登陆帐号
        'mail_password' => '',//邮箱密码
        'mail_charset'  => 'utf-8',
        'mail_auth'     => true,//邮箱认证
        'mail_html'     => true,
    ],
    //邮件有效期
    'email_expiry' => 60*15,
    //默认错误跳转对应的模板文件
    'dispatch_error_tmpl' => '/public/error',
    //默认成功跳转对应的模板文件
    'dispatch_success_tmpl' => '/public/success',
];
