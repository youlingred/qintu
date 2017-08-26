<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: tangtanglove <dai_hang_love@126.com> <http://www.ixiaoquan.com>
// +----------------------------------------------------------------------

namespace app\admin\model;

use think\Model;

/**
 * 用户模型
 * @author  tangtanglove <dai_hang_love@126.com>
 */
class Links extends Model
{

	// 设置当前模型对应的完整数据表名称
    protected $table = 'mini_links';

	// 开启自动写入时间戳字段
	protected $autoWriteTimestamp = true;

	//设置时间戳格式
	protected $type = [
        
        'createtime'  =>  'timestamp:Y/m/d',
    ];

    // 定义时间戳字段名
    protected $createTime = 'createtime';

}