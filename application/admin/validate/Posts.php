<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: tangtanglove <dai_hang_love@126.com> <http://www.ixiaoquan.com>
// +----------------------------------------------------------------------

namespace app\admin\validate;

use think\Validate;

class Posts extends Validate
{
    // 验证规则
    protected $rule =   [
        'content'  => 'require',
        'title'    => 'require',
    ];

    // 错误提示消息
    protected $message  =   [
        'content.require'  => '内容不能为空！',
        'title.require'    => '标题不能为空！',
    ];
}