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

/**
 *	订单
 * @author  wangjingjing
 */
class Order extends Base
{
	/**
     * 个人订单
     * @author ILsunshien
     */
    public function orderLists()
    {   
        // 筛选订单状态
        $status = input('status');
        if (!empty($status)) {
            $map['status'] = $status;
        }else{
            $map['status'] = array('not in',['cancel','delete']);
        }
        $map['uid'] = UID;
        $orders_ids = Db::name('Orders')->where($map)->order('createtime desc')->column('id');
        if($orders_ids){
            $where['order_id'] = ['in',$orders_ids];
            $goods = Db::name('OrdersGoods')
            ->where($where)
            ->order('id desc')
            ->paginate(10,false,['query' => ['status'=>$status] ]); 
            // 获取分页显示
            $page = $goods->render();         
            $this->assign('page',$page);
            $this->assign('lists',$goods);
            
        }else{
            $this->assign('page',"");
            $this->assign('lists',"");
        }
        return $this->themeFetch('user_order');
    }
	   
    /**
     * 个人订单详情页
     * @author ILsunshine
     */
    public function orderDetail()
    {
        $order_id = input('get.order_id');
        if(empty($order_id)){
            $this->error('参数错误');
        }
        $map['uid']      = UID;
        $map['id']       = $order_id;        
        $orders = Db::name('Orders')->where($map)->find();        
        if(empty($orders)){
            $this->error('订单不存在');
        }
        $this->assign('ordersInfo',$orders);        
        return $this->themeFetch('order_detail');
    }

    /**
     * 确认收货
     * @author ILsunshine
     */
    public function confirmOrders()
    {
        $order_no = input('post.order_no');
        if(empty($order_no)){
            $this->error('参数错误');
        }        
        $orders = Db::name('Orders')->where(array('uid'=>UID,'order_no'=>$order_no))->setField('status','completed');        
        if($orders){
            return $this->success('操作成功',url('order/orderLists'));
        }else{
        	return $this->error('操作失败');
        }
    }

	/**
	 * 取消订单或删除
	 */
	public function cancel()
	{
		$id = input('post.id');
		$type = input('post.type');
		if(empty($id)){
			$this->error('参数错误！');
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
                        return $this->success('订单取消成功！');
                    }else{
                        return $this->success('订单删除成功！');
                    }
                }else{
                    if($type==1){
                        $this->error('订单取消失败，请联系客服！');
                    }else{
                        $this->error('订单删除失败，请联系客服！');
                    }
                }
            }
            else{
                $this->error('订单交易中，不可以取消！');
            }

        }else{
            $this->error('订单不存在');
        }
		
		
	}
    /**
     * 支付代付款订单
     */
    public function pay(){
        $order_no        = input('get.order_no');
        $map['order_no'] = $order_no;
        $map['status']   = 'nopaid';
        $orders          = Db::name('Orders')->where($map)->find();
        if(empty($orders)){
            $this->error('订单错误');
        }else{
            if ($orders['pay_type'] == 'wxpay') {
                $this->redirect(url('wx/wxpay/pay',['order_no'=>$order_no]));
            } elseif($orders['pay_type'] == 'alipay') {
                $this->redirect(url('wx/alipay/pay',['order_no'=>$order_no]));
            } else {
            return $this->error('支付方式错误！');
            }
        }       
    }
}
