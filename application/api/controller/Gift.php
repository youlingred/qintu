<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: tangtnglove <dai_hang_love@126.com> <http://www.ixiaoquan.com>
// +----------------------------------------------------------------------

namespace app\api\controller;

use think\Db;
use think\Request;
use think\controller\Rest;

/**
 * 网站首页控制器
 * @author  tangtnglove <dai_hang_love@126.com>
 */
class Gift extends Base
{
	/**
	 * 礼品列表
	 * @author 矢志bu渝
	 */
    public function giftList_get_json()
    {    	
        // 当前页码
        $page       = input('page',1);
        // 分页数量
        $num        = input('num',10);
        // 礼品列表
        $giftList = Db::name('Gift')->where(['status'=>1])->page($page,$num)->select();
        foreach ($giftList as $key => $value) {
        	$giftList[$key]['cover_path'] = str_replace('/uploads', 'http://'.$_SERVER['HTTP_HOST'].__ROOT__.'/uploads', $value['cover_path']);
        }
        if(!empty($giftList)) {
            return $this->restSuccess('获取成功！',$giftList);
        } else {
            return $this->restError('没有数据了！');
        }
    }

    
    
}
