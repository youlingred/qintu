<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: tangtnglove <dai_hang_love@126.com> <http://www.ixiaoquan.com>
// +----------------------------------------------------------------------

/**
 * 系统配文件
 * 所有系统级别的配置
 */
return [
    // URL设置
    'url_common_param'      =>  true,
    // 验证码设置
    'captcha'               =>  [
        'fontSize'    =>    30,    // 验证码字体大小
        'length'      =>    3,     // 验证码位数
        'useNoise'    =>    false, // 关闭验证码杂点
    ],
    'token_valid'           =>  3600, //token有效期，默认为秒
    'root_path'		=>__ROOT__
];
