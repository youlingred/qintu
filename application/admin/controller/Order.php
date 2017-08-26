<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: tangtanglove <dai_hang_love@126.com> <http://www.ixiaoquan.com>
// +----------------------------------------------------------------------

namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\Request;

/**
 * 系统用户控制器
 * @author  ILSunshine
 */
class Order extends Common
{
    /**
     * 订单列表
     * @author 
     */
    public function index()
    {
        // 搜索词
        $q = input('q');
        if (!empty($q)) {
            $map['order_no'] = ['like','%'.mb_convert_encoding($q, "UTF-8", "auto").'%'];
        }
        // 筛选订单状态
        $status = input('status');
        if (!empty($status)) {
            $map['status'] = $status;
        }
        
        // 条件为空则赋值
        if (empty($map)) {
            $map['status'] = 'nopaid';
        }
        // 订单列表
        $ordersList = Db::name('Orders')
                    ->where($map)
                    ->order('createtime desc')
                    ->paginate(8);
         // 把分页数据赋值给模板变量ordersList      
        $this->assign('ordersList', $ordersList);
        return $this->fetch();
    }

    /**
     * 查看订单详情
     * @author 
     */
    public function detail()
    {
        $order_id            = input('id');
        if (empty($order_id)) {
            return $this->error('请选择数据！');
        }        
        // 订单信息              
        $ordersInfo    = Db::name('Orders')->where('order_no',$order_id)->find();
        // 订单状态信息
        $goodInfo = Db::name('OrdersGoods')->where(['order_id'=>$ordersInfo['id']])->select();

        // $getStatusList = Db::name('Orders_status')->where('order_id',$order_id)->select();
        // if (!empty($getStatusList)) {
        // foreach ($getStatusList as $key => $value) {
        //     $data[$value['status']]     = $value['createtime'];
        //     }
        //     $this->assign('data',$data);
        // } 
        
        $this->assign('ordersInfo', $ordersInfo);   
        $this->assign('goodInfo', $goodInfo);              
        return $this->fetch();                                   
    }

     /**
     * 编辑订单发货
     * @author 
     */
    public function delivery()
    {
        if(Request::instance()  ->isPost()) {
            // 接收post数据
            $order_id            = input('post.order_no');
            $address             = input('post.address');
            $mobile              = input('post.mobile');
            $consignee_name      = input('post.consignee_name');
            
            // 查询发货状态是否存在
            $map['order_id']     =$order_id;
            $map['status']       ='shipped';
            if(Db::name('Orders_status')->where($map)->find())
            {
                return $this->error('此订单已经发货');
                return false;
                   
            }
            // 开启事务
            Db::startTrans();
            // 更新订单发货状态
            $data['order_id']       = $order_id;            
            $data['status']         = 'shipped';
            $data['createtime']     = time();             
            $result                 = Db::name('Orders_status')->insert($data);
            // 更新订单表信息
            $where['address']        = $address;
            $where['consignee_name'] = $consignee_name;
            $where['mobile']         = $mobile;
            $where['status']         = 'shipped';
            $getStatus               = Db::name('Orders')
                                     ->where('order_no',$order_id)->update($where);

            if ($result !== false && $getStatus !== false) { 
               // 事务提交
                Db::commit();             
                return $this->success('发货成功!');
            }
            else{
                Db::rollback();
                return $this->error('发货失败！');
                }   
            
        } else {
            // 更新数据
            $order_id            = input('id');
            if (empty($order_id)) {
                return $this->error('请选择数据！');
            }
            // 订单信息              
            $ordersInfo = Db::name('Orders')->where('order_no',$order_id)->find();            
            $this->assign('ordersInfo',$ordersInfo);
            return $this->fetch();
        }
    }

    

    /**
     * 收货地址管理
     * @author  
     */
    public function address ()
    {
        if (Request::instance()->isPost()) {
            $addess            = input('post.address');
            $uuid              = input('post.uuid');

            $data['uuid']      = $uuid;
            $data['value']     = $address;
            $data['name']      = 'address';            
            $data['collection']= 'orders.address';            
            $getStatus         = Db::name('KeyValue')->insert($data);
            if ($getStatus    !== false) {
                return $this->success('添加成功',url('order/index'));
            } else {
                return $this->error('添加失败');
            }
        } else {
            
            return $this->fetch();
        }
    }

    /**
     * 编辑订单
     * @author  vaey
     */
    public function edit(){
        if (Request::instance()->isPost()) {
            $ordersId                   = input('post.ordersId');
            $data['address']            = input('post.address');
            $data['mobile']             = input('post.mobile');
            $data['consignee_name']     = input('post.consignee_name');
            $data['express_type']       = input('post.express_type');
            $data['express_no']         = input('post.express_no');

            $info = Db::name('Orders')->where(['id'=>$ordersId])->update($data);
            if($info){
                return $this->success('修改成功');
            }else{
                return $this->error('没有数据被修改');
            }
        }
    }

    /**
     * 订单发货
     * @author  vaey
     */
    public function send(){
        if (Request::instance()->isPost()) {
            $ordersId                   = input('post.ordersId');
            $info = Db::name('Orders')->where(['id'=>$ordersId])->find();
            if($info['status']=='shipped'){
                return $this->error('此订单已经发货');
            }
            if($info['status'] == 'paid'){
                //开启事务
                Db::startTrans();
                $data['status']         = 'shipped';
                $flg1 = Db::name('Orders')->where(['id'=>$ordersId])->update($data);
                //订单号
                $data['order_id']       = $info['order_no'];
                //操作人 
                $data['approve_uid']    = UID;
                $data['createtime']     = time(); 
                $flg2 = Db::name('OrdersStatus')->where(['id'=>$ordersId])->insert($data);
                if($flg1 && $flg2){
                    Db::commit();  
                    return $this->success('修改成功');
                }else{
                    Db::rollback();
                    return $this->error('没有数据被修改');
                }
            }else{
                return $this->error('此订单未支付，不能发货');
            }
            
        }
    }

    /**
     * 订单完成
     * @author  vaey
     */
    public function completed(){
        if (Request::instance()->isPost()) {
            $ordersId                   = input('post.ordersId');
            $info = Db::name('Orders')->where(['id'=>$ordersId])->find();
            if($info['status']=='completed'){
                return $this->error('此订单已经发货');
            }
            if($info['status'] == 'shipped'){
                //开启事务
                Db::startTrans();
                $data['status']         = 'completed';
                $flg1 = Db::name('Orders')->where(['id'=>$ordersId])->update($data);
                //订单号
                $data['order_id']       = $info['order_no'];
                //操作人 
                $data['approve_uid']    = UID;
                $data['createtime']     = time(); 
                $flg2 = Db::name('OrdersStatus')->where(['id'=>$ordersId])->insert($data);
                if($flg1 && $flg2){
                    Db::commit();  
                    return $this->success('修改成功');
                }else{
                    Db::rollback();
                    return $this->error('没有数据被修改');
                }
            }else{
                return $this->error('此订单未发货，不能完成交易');
            }
            
        }
    }
//亲途增加
	public function person(){
		$list = Db::name('Person_need')
                    ->order('createtime desc')
                    ->paginate(8);
		$this->assign('list', $list);
        return $this->fetch();
	}
	public function business(){
		$list = Db::name('Business_need')
        ->order('createtime desc')
        ->paginate(8);
		 $this->assign('list', $list);
        return $this->fetch();
	}
	public function hunpai(){
		$list = Db::name('Hunpai_need')
        ->order('createtime desc')
        ->paginate(8);
		 $this->assign('list', $list);
        return $this->fetch();
	}
	public function lvpai(){
		$list = Db::name('Lvpai_need')
        ->order('createtime desc')
        ->paginate(8);
		 $this->assign('list', $list);
        return $this->fetch();
	}
	public function yiliao(){
		$list = Db::name('Yiliao_need')
        ->order('createtime desc')
        ->paginate(8);
		 $this->assign('list', $list);
        return $this->fetch();
	}
    
}
