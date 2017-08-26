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
 * 广告
 * @author  tangtanglove <dai_hang_love@126.com>
 */
class Banner extends Base
{
    /**
    * 获取广告控制器
    * @author  tangtanglove <dai_hang_love@126.com>
    */
    public function index_get_json()
    {
        $where['position']  =   input('position');
        if (empty($where['position'])) {
            return $this->restError('参数错误！');
        }
        $where['status']    =   1;
        $list = Db::name('Banner')->where($where)->order('level desc')->select();

        foreach ($list as $key => $value) {
            $list[$key]['banner_path'] = str_replace('/uploads', 'http://'.$_SERVER['HTTP_HOST'].__ROOT__.'/uploads', $value['banner_path']);
        }
        if(!empty($list)) {
            return $this->restSuccess('获取成功！',$list);
        } else {
            return $this->restError('没有数据了！');
        }
    }
}
