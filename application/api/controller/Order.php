<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: wangjingjing<1064868847@qq.com> <http://www.ixiaoquan.com>
// +----------------------------------------------------------------------

namespace app\api\controller;

use think\Db;
use think\Log;
use think\controller\Rest;

/**
 *	订单
 * @author  wangjingjing
 */
class Order extends Common
{
	/**
     * 个人订单
     * @author ILsunshien
     */
    public function orderLists_get_json()
    {   
        // 当前页码
        $page       = input('page',1);
        // 分页数量
        $num        = input('num',10);
        // 筛选订单状态
        $status = input('status');
        if (!empty($status)) {
            $map['status'] = $status;
        }else{
            $map['status'] = array('not in',['cancel','delete']);
        }
        $map['uid'] = UID;
        $orders_ids = Db::name('Orders')->where($map)->order('createtime desc')->column('id');
        if($orders_ids) {
            $where['order_id'] = ['in',$orders_ids];
            $lists = Db::name('OrdersGoods')
            ->where($where)
            ->page($page,$num)
            ->order('id desc')
            ->select();

            foreach ($lists as $key => $value) {
                $lists[$key]['status'] = Db::name('Orders')->where(['id'=>$value['order_id']])->order('createtime desc')->value('status');
                $lists[$key]['cover_path'] = str_replace('/uploads', 'http://'.$_SERVER['HTTP_HOST'].__ROOT__.'/uploads', $value['cover_path']);
            }

            // 获取分页显示
            if(!empty($lists)) {
                return $this->restSuccess('获取成功！',$lists);
            } else {
                return $this->restError('没有数据了！');
            }
        } else {
            return $this->restError('没有数据了！');
        }
    }
	   
    /**
     * 个人订单详情页
     * @author ILsunshine
     */
    public function orderDetail_get_json()
    {
        $order_id = input('get.orderId');
        if(empty($order_id)){
            $this->restError('参数错误');
        }
        // dump(UID);
        $map['uid']      = UID;
        $map['id']       = $order_id;
        $orders = Db::name('Orders')->where($map)->find();
        if(empty($orders)){
            $this->restError('订单不存在');
        }

        // 送货日期
        $orders['delivery_time'] = get_delivery_time($orders['id']);
        // 支付订单
        $orders['trade_no']      = get_trade_no($orders['id']);
        // 订单商品列表
        $ordersGoodsLists        = Db::name('OrdersGoods')->where(['order_id'=>$orders['id']])->select();
        foreach ($ordersGoodsLists as $key => $value) {
            $ordersGoodsLists[$key]['cover_path'] = str_replace('/uploads', 'http://'.$_SERVER['HTTP_HOST'].__ROOT__.'/uploads', $value['cover_path']);
        }
        $orders['goods_lists']   = $ordersGoodsLists;
        if(!empty($orders)) {
            return $this->restSuccess('获取成功！',$orders);
        } else {
            return $this->restError('没有数据了！');
        }
    }

    /**
     * 确认收货
     * @author ILsunshine
     */
    public function confirmOrders_post_json()
    {
        $order_no = input('post.order_no');
        if(empty($order_no)){
            $this->restError('参数错误');
        }        
        $orders = Db::name('Orders')->where(array('uid'=>UID,'order_no'=>$order_no))->setField('status','completed');        
        if($orders){
            return $this->restSuccess('操作成功');
        }else{
        	return $this->restError('操作失败');
        }
    }

	/**
	 * 取消订单或删除
	 */
	public function cancel_post_json()
	{
		$id = input('post.id');
		$type = input('post.type');
		if(empty($id)){
			$this->restError('参数错误！');
		}		
        $info = Db::name('Orders')->where(['id'=>$id])->find();
        if($info){
            // 订单          
            if($info['status'] == 'nopaid' || $info['status'] == 'completed'){
                if($type==1){
                    $data['status'] = "cancel";
                }else{
                    $data['status'] = "delete";
                }
                $res = Db::name('Orders')->where(array('id'=>$id,'uid'=>UID))->update($data);
                if($res){
                    if($type==1){
                        return $this->restSuccess('订单取消成功！');
                    }else{
                        return $this->restSuccess('订单删除成功！');
                    }
                }else{
                    if($type==1){
                        $this->restError('订单取消失败，请联系客服！');
                    }else{
                        $this->restError('订单删除失败，请联系客服！');
                    }
                }
            }
            else{
                $this->restError('订单交易中，不可以取消！');
            }

        }else{
            $this->restError('订单不存在');
        }
		
		
	}

    /**
     * 支付代付款订单
     */
    public function pay_post_json()
    {
        $order_no        = input('get.order_no');
        $map['order_no'] = $order_no;
        $map['status']   = 'nopaid';
        $orders          = Db::name('Orders')->where($map)->find();
        if (empty($orders)) {
            $this->restError('订单错误');
        } else {
            if ($orders['pay_type'] == 'wxpay') {
                $orderResult['paytype']  = 'wxpay';
                $orderResult['order_no'] = $order_no;
                return $this->restSuccess('提交成功！',$orderResult);
            } elseif ($orders['pay_type'] == 'alipay') {
                $orderResult['paytype']  = 'alipay';
                $orderResult['order_no'] = $order_no;
                return $this->restSuccess('提交成功！',$orderResult);
            } else {
                return $this->restError('支付方式错误！');
            }
        }       
    }
}
