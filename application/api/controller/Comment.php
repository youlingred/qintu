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
 * 商品评论控制器
 * @author  tangtanglove <dai_hang_love@126.com>
 */
class Comment extends Common
{
    /**
     * 订单评论
     * @author  ILsunsine
     */
    public function orderComment_post_json()
    {
        $goods_id          = input('post.goods_id');
        $score             = input('post.score');
        $order_id          = input('post.order_id');
        $content           = input('post.content');
        $where['uid']      = UID;
        $where['goods_id'] = $goods_id;
        $where['order_id'] = $order_id;
        if(Db::name('GoodsComment')->where($where)->find()){
            return $this->restError('同一件商品只能评论一次');
        }

        // 验证数据
        $data['goods_id']  = $goods_id;
        $data['content']   = $content;
        $data['order_id']  = $order_id;
        $data['score']     = $score;

        if(empty($goods_id) || empty($content) || empty($order_id) || empty($score)) {
            return $this->restError('参数不能为空！');
        }

        // 开启事务
        Db::startTrans();
        
        $data['uid']       = UID;
        $data['createtime']= time(); 
        $getStatus         = Db::name('GoodsComment')->insert($data);
        
        // 计算商品平均得分，更新商品表得分
        $total_score = Db::name('GoodsComment')->where('goods_id',$goods_id)->sum('score');
        $count       = Db::name('GoodsComment')->where('goods_id',$goods_id)->count();
        $score       = round($total_score/$count);
        $score_num   = Db::name('Goods')->where('id',$goods_id)->value('score_num');
        if($score == $score_num){
            $scorestatus=true;
        }else{
            $scorestatus = Db::name('Goods')->where('id',$goods_id)->setField('score_num',$score);
        }
            
        // 更改订单评论状态
        $map['order_id']   = $order_id;
        $map['goods_id']   = $goods_id;
        $result = Db::name('OrdersGoods')->where($map)->setField('is_comment',1);
        if ($getStatus && ($scorestatus!==false) && ($result!==false)) {
            // 事务提交
            Db::commit();
            return $this->restSuccess('评论成功');
        } else {
            Db::rollback();
            return $this->restError('评论失败');     
        }
    }

    /**
     * 我的评价列表
     * @author ILsunshine
     */
    public function commentList_get_json()
    {   
        // 当前页码
        $page       = input('page',1);
        // 分页数量
        $num        = input('num',10);

        $lists = Db::name('GoodsComment')
        ->alias('a')
        ->join('orders_goods b','b.goods_id= a.goods_id AND b.order_id= a.order_id','LEFT')
        ->where(array('a.uid'=>UID,'a.status'=>1))
        ->field('a.*,b.name,b.price,b.standard,b.cover_path')
        ->order('a.createtime desc')
        ->page($page,$num)
        ->select();
        foreach ($lists as $key => $value) {
            $lists[$key]['cover_path'] = str_replace('/uploads', 'http://'.$_SERVER['HTTP_HOST'].__ROOT__.'/uploads', $value['cover_path']);
        }
        // 获取分页显示
        if(!empty($lists)) {
            return $this->restSuccess('获取成功！',$lists);
        } else {
            return $this->restError('没有数据了！');
        }
    } 

    /**
     * 删除我的评价
     * @author  ILsunshine
     */
    public function del_post_json()
    {
        $map['goods_id'] = input('post.id');
        $map['uid']      = UID;
        $result = Db::name('GoodsComment')->where($map)->setField('status',-1);
        if($result) {
            return $this->restSuccess('删除成功！');
        } else {
            return $this->restError('删除失败！');
        } 
    }

    /**
     * 批量删除我的评价
     * @author  ILsunshine
     */
    public function delComment_post_json()
    {
        $ids     = input('post.ids/a');
        $map['goods_id'] = array('in',implode(',',$ids));
        $map['uid']      = UID;
        $result = Db::name('GoodsComment')->where($map)->setField('status',-1);
        if($result) {
            return $this->restSuccess('删除成功！');
        } else {
            return $this->restError('删除失败！');
        } 
    }

    /**
     * 待评价商品列表
     * @author ILsunshine
     */
    public function ordersNocomment_get_json()
    {   
        // 当前页码
        $page       = input('page',1);
        // 分页数量
        $num        = input('num',10);
        $map['a.uid']        = UID;
        $map['a.status']     = "completed";
        $map['b.is_comment'] = -1;
        $lists = Db::name('Orders')
        ->alias('a')
        ->join('orders_goods b','b.order_id = a.id','LEFT')
        ->where($map)
        ->field('b.price*b.num as total_money,a.*,b.goods_id,b.num,b.is_comment,b.name,b.price,b.standard,b.order_id,b.cover_path')
        ->order('a.createtime desc')
        ->page($page,$num)
        ->select();
        foreach ($lists as $key => $value) {
            $lists[$key]['cover_path'] = str_replace('/uploads', 'http://'.$_SERVER['HTTP_HOST'].__ROOT__.'/uploads', $value['cover_path']);
        }
        // 获取分页显示
        if(!empty($lists)) {
            return $this->restSuccess('获取成功！',$lists);
        } else {
            return $this->restError('没有数据了！');
        }
    }

    /**
     * 评价详情
     * @author ILsunshine
     */
    public function commentDetail_get_json()
    {   
        $goods_id   = input("get.goods_id");
        $order_id   = input("get.order_id");
        $map['a.uid']      = UID;
        $map['a.goods_id'] = $goods_id;
        $map['a.order_id'] = $order_id;
        $commentInfo = Db::name('GoodsComment')
        ->alias('a')
        ->join('orders_goods b','b.goods_id= a.goods_id AND b.order_id= a.order_id','LEFT')
        ->where($map)
        ->field('a.*,b.name,b.price,b.standard,b.cover_path')
        ->find();  

        $commentInfo['cover_path'] = str_replace('/uploads', 'http://'.$_SERVER['HTTP_HOST'].__ROOT__.'/uploads', $commentInfo['cover_path']);

        if(!empty($commentInfo)) {
            return $this->restSuccess('获取成功！',$commentInfo);
        } else {
            return $this->restError('没有数据了！');
        }
    }

    /**
     * 待评论商品信息
     * @author  ILsunsine
     */
    public function orderGoodsDetail_get_json()
    {
        $goods_id          = input('get.goods_id');
        $order_id          = input('get.order_id');

        $where['goods_id'] = $goods_id;
        $where['order_id'] = $order_id;

        // 读取order信息
        $ordersGoodsInfo = Db::name('OrdersGoods')->where($where)->find();
        $ordersGoodsInfo['cover_path'] = str_replace('/uploads', 'http://'.$_SERVER['HTTP_HOST'].__ROOT__.'/uploads', $ordersGoodsInfo['cover_path']);
        if(!empty($ordersGoodsInfo)) {
            return $this->restSuccess('获取成功！',$ordersGoodsInfo);
        } else {
            return $this->restError('没有数据了！');
        }
    }

}
