<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: wangjingjing<1064868847@qq.com> <http://www.ixiaoquan.com>
// +----------------------------------------------------------------------

namespace app\wap\controller;

use think\Db;
use think\Log;
//use think\Loader;
use think\Request;

/**
 *  商品收藏管理
 *   
 */
class Collection extends Common
{
    /**
     * 我的收藏
     * @author ILsunshine
     */
    public function Collection()
    {   
        $goods = Db::name('GoodsCollection')
                ->alias('a')
                ->join('goods b','b.id= a.goods_id','LEFT')
                ->where(array('a.uid'=>UID))
                ->field('a.*,b.name,b.price,b.standard,b.cover_path,b.sell_num')
                ->order('a.createtime desc')->paginate(10);  
        // 获取分页显示
        $page = $goods->render();         
        $this->assign('page',$page);
        $this->assign('lists',$goods);
        return $this->themeFetch('user_collection');
    }
     /**
     * 删除收藏商品
     * @author  ILsunshine
     */
    public function delGoodsCollection(){
        $ids        = input('post.ids/a');
        $map['id']  = array('in',implode(',',$ids));
        $map['uid'] = UID;
        $result = Db::name('GoodsCollection')->where($map)->delete();
        if($result) {
            return $this->success('删除成功！',url('collection/Collection'));
        } else {
            return $this->error('删除失败！');
        } 
    } 
        
}
