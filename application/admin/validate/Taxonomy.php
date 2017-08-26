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

class Taxonomy extends Validate
{
    // 验证规则
    protected $rule =   [
        'name'         => 'require',
        'pid'          => 'number',
        'page_num' 	   => 'number',
        'lists_tpl'    => 'require',
        'detail_tpl'   => 'require',
        'sort'         => 'number',
    ];

    // 错误提示消息
    protected $message  =   [
        'name.require'         => '分类目录名称必填！',
        'pid.number'           => '父节点格式不正确！',
        'page_num.number'      => '分页格式不正确！',
        'lists_tpl.require'    => '列表页模板必填！',
        'detail_tpl.require'   => '详情页模板必填！',
        'sort.number'          => '排序为数字！',
    ];
}