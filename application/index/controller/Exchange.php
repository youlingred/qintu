<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: vaey
// +----------------------------------------------------------------------

namespace app\index\controller;

use think\Db;
use think\Log;
use think\Loader;
use think\Request;

/**
 *	礼品兑换
 * @author  vaey
 */
class Exchange extends Common
{
	/**
     * 兑换记录
     */
    public function lists()
    {   
        
        $lists = Db::name('GiftOrders')
        ->alias('a')
        ->join('gift b','b.id= a.gift_id','LEFT')
        ->where(array('a.uid'=>UID))
        ->field('a.*,b.name as giftname,b.cover_path,b.score,b.standard')
        ->order('a.id desc')->paginate(10);  

        $this->assign('lists',$lists);
        $this->assign('page',$lists->render());
        return $this->themeFetch('exchange_list');
    }
	   


    

}
