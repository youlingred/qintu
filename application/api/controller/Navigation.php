<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: tangtanglove <dai_hang_love@126.com> <http://www.ixiaoquan.com>
// +----------------------------------------------------------------------

namespace app\api\controller;

use think\Db;
use think\Request;
use think\controller\Rest;

/**
 * 网站导航
 * @author  tangtanglove <dai_hang_love@126.com>
 */
class Navigation extends Base
{
    /**
    * 获取导航控制器
    * @author  tangtanglove <dai_hang_love@126.com>
    */
    public function index_get_json()
    {
        $where['pid']       =   input('pid',0);
        $where['hide']      =   0;
        $list = Db::name('Navigation')->where($where)->order('sort asc')->select();
        if(!empty($list)) {
            return $this->restSuccess('获取成功！',$list);
        } else {
            return $this->restError('没有数据了！');
        }
    }
}
