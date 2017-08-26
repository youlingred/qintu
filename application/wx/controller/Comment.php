<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: wangjingjing<1064868847@qq.com> <http://www.ixiaoquan.com>
// +----------------------------------------------------------------------

namespace app\wx\controller;

use think\Db;
use think\Log;
use think\Loader;
use think\Request;

/**
 *  评论管理
 * @author  ILsunshine
 */
class Comment extends Base
{
/**
     * 订单评论
     * @author  ILsunsine
     */
    public function orderComment()
    {
        if (Request::instance()->isPost()) {
            $goods_id          = input('post.goods_id');
            $score             = input('post.score');
            $order_id          = input('post.order_id');
            $content           = input('post.content');
            $where['uid']      = UID;
            $where['goods_id'] = $goods_id;
            $where['order_id'] = $order_id;
            if(Db::name('GoodsComment')->where($where)->find()){
                return $this->error('同一件商品只能评论一次');
            }
            // 实例化验证器
            $validate = Loader::validate('User'); 

            // 验证数据
            $data['goods_id']  = $goods_id;
            $data['content']   = $content;
            $data['order_id']  = $order_id;
            $data['score']     = $score;
            if (!$validate->scene('comment')->check($data)) {
                return $this->error($validate->getError());
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
            if ($getStatus&& $scorestatus&&$result) {
                // 事务提交
                Db::commit();
                return $this->success('评论成功',url('comment/CommentList'));
            } else {
                Db::rollback();
                return $this->error('评论失败');     
            }
        } else { 
            $where['order_id']   = input('get.order_id');
            $where['goods_id']   = input('get.goods_id');
            $postInfo    = Db::name('ordersGoods')->where($where)->find();      
            $this->assign('postInfo',$postInfo);
            return $this->themeFetch('user_comment');
        }
    } 

    /**
     * 我的评价列表
     * @author ILsunshine
     */
    public function CommentList()
    {   
        $orders = Db::name('GoodsComment')
                ->alias('a')
                ->join('orders_goods b','b.goods_id= a.goods_id AND b.order_id= a.order_id','LEFT')
                ->where(array('a.uid'=>UID,'a.status'=>1))
                ->field('a.*,b.name,b.price,b.standard,b.cover_path')
                ->order('a.createtime desc')->paginate(6);  
        // 获取分页显示
        $page = $orders->render();         
        $this->assign('page',$page);
        $this->assign('lists',$orders);
        return $this->themeFetch('user_comment_list');
    } 

     /**
     * 删除我的评价
     * @author  ILsunshine
     */
    public function del(){
        $id     = input('post.id');
        $map['goods_id'] = $id;
        $map['uid']      = UID;
        $result = Db::name('GoodsComment')->where($map)->setField('status',-1);
        if($result) {
            return $this->success('删除成功！',url('comment/CommentList'));
        } else {
            return $this->error('删除失败！');
        } 
    }
    /**
     * 批量删除我的评价
     * @author  ILsunshine
     */
    public function delComment(){
        $ids     = input('post.ids/a');
        $map['goods_id'] = array('in',implode(',',$ids));
        $map['uid']      = UID;
        $result = Db::name('GoodsComment')->where($map)->setField('status',-1);
        if($result) {
            return $this->success('删除成功！',url('comment/CommentList'));
        } else {
            return $this->error('删除失败！');
        } 
    }    
    /**
     * 待评价商品列表
     * @author ILsunshine
     */
    public function ordersNocomment()
    {   
        $map['a.uid']        = UID;
        $map['a.status']     = "completed";
        $map['b.is_comment'] = -1;
        $orders = Db::name('Orders')
                ->alias('a')
                ->join('orders_goods b','b.order_id= a.id','LEFT')
                ->where($map)
                ->field('b.price*b.num as total_money,a.*,b.goods_id,b.num,b.is_comment,b.name,b.price,b.standard,b.order_id,b.cover_path')
                ->order('a.createtime desc')->paginate(10);  
        
        // 获取分页显示
        $page = $orders->render();         
        $this->assign('page',$page);
        $this->assign('lists',$orders);
        return $this->themeFetch('orders_nocomment');
    } 
    /**
     * 评价详情
     * @author ILsunshine
     */
    public function commentDetail()
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
        
        $this->assign('commentInfo',$commentInfo);
        return $this->themeFetch('user_comment_detail');
    } 

}