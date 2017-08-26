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

/**
 * 购物车控制器
 * @author tangtanglove
 */
class Cart extends Common
{
	/**
	* 购物车首页
	* @author tangtanglove
	*/
	public function index()
	{
		$carlists 	 = json_decode(cookie('mini_car'));
		$selectGoods = '';
		$cartMoney   = 0;
		if ($carlists) {
			foreach ($carlists as $key => $value) {
				$hasCart = Db::name('Cart')->where(['goods_id'=>$value[0],'uid'=>UID,'status'=>1])->find();
				if($hasCart) {
					$data['goods_id'] 	= $value[0];
					$data['uid'] 		= UID;
					$data['num'] = $hasCart['num']+$value[3];
					$data['createtime'] = $hasCart['createtime'];
					Db::name('Cart')->where(['goods_id'=>$value[0],'uid'=>UID,'status'=>1])->update($data);
				} else {
					$data['goods_id'] 	= $value[0];
					$data['uid'] 		= UID;
					$data['num'] 		= $value[3];
					$data['createtime'] = time();
					Db::name('Cart')->insert($data);
				}
				// 定义被选中的goods_id
				$selectGoods[$key] = $value[0];
				// 计算购物车合计
				$cartMoney = $cartMoney+$data['num']*$value[2];
			}

			// 删除cookie
			cookie('mini_car', null);
		}

		$where['a.uid'] 	= UID;
		$where['a.status'] 	= 1;
		$where['b.status']  = 1;
        $lists = Db::name('Cart')->alias('a')->join('goods b','b.id=a.goods_id','LEFT')
        ->where($where)
		->order('id desc')
        ->field('a.num as cart_num,b.*')
        ->select();
		// 输出选中的商品id
		$this->assign('cartMoney',$cartMoney);
		$this->assign('selectGoods',$selectGoods);
		$this->assign('lists',$lists);
        return $this->themeFetch('cart_step1');
	}

	/**
	* 检查订单信息
	* @author tangtanglove
	*/
	public function checkOrder()
	{
		$cart = input('cart/a');
		if (!$cart) {
			return $this->error('请选择数据！',url('index'));
		}
		$cartMoney   = 0;
		foreach ($cart as $key => $value) {
			$arrvalue = explode(',',$value);
			if (trim($arrvalue['0']) == 'yes') {
				$goodsInfo = Db::name('Goods')->where(['id'=>$arrvalue['1'],'status'=>1])->find();
				if(empty($goodsInfo)) {
					return $this->error('此商品已下架！',url('index'));
				}
				$lists[$key]['info'] = $goodsInfo;
				$lists[$key]['num']  = $arrvalue['3'];
				// 计算购物车合计
				$cartMoney = $cartMoney+$arrvalue['3']*$goodsInfo['price'];
			}
		}
		if (empty($lists)) {
			return $this->error('请选择数据！',url('index'));
		}
		// 获取配送区域
		$ordersAddressLists = Db::name('OrdersAddress')->where(['uid'=>UID,'status'=>1])->select();
		$formToken = md5(time());
		session('formToken',$formToken);
		$this->assign('formToken',$formToken);
		$this->assign('lists',$lists);
		$this->assign('ordersAddressLists',$ordersAddressLists);
		$this->assign('cartMoney',$cartMoney);
        return $this->themeFetch('cart_step2');
	}

	/**
	* 提交订单
	* @author tangtanglove
	*/
	public function postOrder()
	{
		$cart 		= input('cart/a');
		$paytype 	= input('paytype');
		$addressid 	= input('address_id');
		$formToken 	= input('formToken');

		if ($formToken != session('formToken')) {
			return $this->error('请勿重复提交！');
		}

		// if (empty(session('formToken'))) {
		// 	return $this->error('非法提交！');
		// }

		session('formToken', null);

		if (!$cart) {
			return $this->error('请选择数据！',url('index'));
		}
		if (!$addressid) {
			return $this->error('请选择收货地址！',url('index'));
		}

		// 计算总金额
		$cartMoney   = 0;
		foreach ($cart as $key => $value) {
			$arrvalue = explode(',',$value);
				$goodsInfo = Db::name('Goods')->where(['id'=>$arrvalue['0'],'status'=>1])->find();
				if(empty($goodsInfo)) {
					return $this->error('此商品已下架！');
				}
				// 判断数量是合法
				$arrvalue['2'] = intval($arrvalue['2']);
				if($arrvalue['2']<=0 || !is_int($arrvalue['2'])) {
					return $this->error('请输入正确的数量！');
				}
				// 保存数据
				$lists[$key]['info'] = $goodsInfo;
				$lists[$key]['num']  = $arrvalue['2'];
				// 计算购物车合计
				$cartMoney = $cartMoney+$arrvalue['2']*$goodsInfo['price'];
		}

		// 收货地址
		$ordersAddressInfo = Db::name('OrdersAddress')->where(['uid'=>UID,'id'=>$addressid])->find();

		// 订单号
		$order_no 	= date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
		$amount 	= $cartMoney;

		$data['uuid'] 		= create_uuid();
		$data['uid']  		= UID;
		$data['order_no']  	= $order_no;
		$data['pay_type']  	= $paytype;
		$data['amount']  	= $amount;
		$data['consignee_name'] = $ordersAddressInfo['consignee_name'];
		if (!empty($ordersAddressInfo['county'])) {
			$data['address'] = $ordersAddressInfo['province'].$ordersAddressInfo['city'].$ordersAddressInfo['county'].$ordersAddressInfo['address'];
		} else {
			$data['address'] = $ordersAddressInfo['province'].$ordersAddressInfo['city'].$ordersAddressInfo['address'];
		}
		$data['mobile'] 	= $ordersAddressInfo['mobile'];
		$data['createtime'] = time();
		$data['status'] 	= 'nopaid';

		$hasOrder = Db::name('Orders')->where(['order_no'=>$order_no])->find();
		if ($hasOrder) {
			return $this->error('此订单号已经存在！');
		}
		
		$ordersResult = Db::name('Orders')->insert($data);
		if (false != $ordersResult) {
			$orders_id = Db::getLastInsID();
		} else {
			return $this->error('错误！');
		}

		foreach ($lists as $key => $value) {
			$ordersGoodsData['order_id'] 	= $orders_id;
			$ordersGoodsData['goods_id'] 	= $value['info']['id'];
			$ordersGoodsData['name'] 		= $value['info']['name'];
			$ordersGoodsData['num'] 		= $value['num'];
			$ordersGoodsData['price'] 		= $value['info']['price'];
			$ordersGoodsData['description'] = $value['info']['description'];
			$ordersGoodsData['standard'] 	= $value['info']['standard'];
			$ordersGoodsData['cover_path'] 	= $value['info']['cover_path'];
			$ordersGoodsResult = Db::name('OrdersGoods')->insert($ordersGoodsData);
		}

		if ($paytype == 'wxpay') {
			$this->redirect(url('index/wxpay/index',['order_no'=>$order_no]));
		} elseif($paytype == 'alipay') {
			$this->redirect(url('index/alipay/index',['order_no'=>$order_no]));
		} else {
			return $this->error('支付方式错误！');
		}
	}

	/**
	* 添加收货地址
	* @author tangtanglove
	*/
	public function addAddress()
	{
		$consignee_name = input('consignee_name');
		$province 		= input('province');
		$city 			= input('city');
		$county 		= input('county');
		$address 		= input('address');
		$mobile 		= input('mobile');

		if (empty($consignee_name) || empty($province) || empty($city) || empty($address) || empty($mobile)) {
			return $this->error('参数错误！');
		}

		$data['consignee_name'] = $consignee_name;
		$data['uid'] 			= UID;
		$data['province'] 		= $province;
		$data['city'] 			= $city;
		$data['county'] 		= $county;
		$data['address'] 		= $address;
		$data['mobile'] 		= $mobile;
		$data['default'] 		= 1;

		$result = Db::name('OrdersAddress')->insert($data);
		if (false != $result) {
			$id = Db::getLastInsID();
			return $this->success($id);
		} else {
			return $this->error('添加失败！');
		}

	}

	/**
     * 删除单个购物信息
     * @author tangtanglove
	 */
	public function delete()
	{
		$id = input('post.id');
		if(empty($id)) {
			return $this->error('请选择数据！');
		}
		$result = Db::name('Cart')->where('id',$id)->where(['uid'=>UID,'status'=>1])->delete();
		if(false !=$result) {
			return $this->success('删除成功！');
		} else {
			return $this->error('删除失败！');
		}
	}

	/**
     * 删除多个购物信息
     * @author tangtanglove
	 */
	public function deleteAll()
	{
		$goodsids = input('post.ids');
		if(empty($goodsids)) {
			return $this->error('请选择数据！');
		}
		$result = Db::name('Cart')->where('goods_id','in',$goodsids)->where(['uid'=>UID,'status'=>1])->delete();
		if(false !=$result) {
			return $this->success('删除成功！');
		} else {
			return $this->error('删除失败！');
		}
	}
	//亲途增加
	///添加心愿单
	public function addXyd()
	{
		$data['goods_id'] 	= input('post.goods_id');
		$data['uid'] 		= UID;
		$data['num'] = 1;
		$data['createtime'] = time();
		$data['departure_time'] 	= input('post.departure_time');
		$data['man_num'] 		= input('post.man_num');
		$data['child_num'] 		= input('post.child_num');
		Db::name('Cart')->insert($data);
		$cart = Db::name('Cart')->where(['goods_id'=>$data['goods_id'],'status'=>1])->find();
		$data['cart_id']=$cart['id'];
		return $this->success('添加成功','',$data);
	}
	public function postXyd()
	{
		$cart 		= input('cart/a');
		if(empty($cart)){
			return $this->error('心愿单为空！');
		}
		//购物车合计
		$cartMoney=0;
		foreach ($cart as $key => $value) {
			$goodsInfo = Db::name('Goods')->where(['id'=>$value['goods_id'],'status'=>1])->find();
			// 计算购物车合计
			$cartMoney = $cartMoney+$goodsInfo['price'];
			
			$lists[$key]['name'] = $goodsInfo['name'];
			$lists[$key]['price'] = $goodsInfo['price'];
		}
		
		$order_no 	= date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
		
		$data['uuid'] 		= create_uuid();
		$data['uid']  		= UID;
		$data['order_no']  	= $order_no;
		$data['createtime'] = time();
		$data['amount']  	= $cartMoney;
		$data['status'] 	= 'nopaid';
		$data['mobile'] =get_userinfo(UID,'mobile');
		$data['consignee_name'] =get_userinfo(UID,'nickname');
		
		
		$hasOrder = Db::name('Orders')->where(['order_no'=>$order_no])->find();
		if ($hasOrder) {
			return $this->error('此订单号已经存在！');
		}
		$ordersResult = Db::name('Orders')->insert($data);
		if (false != $ordersResult) {
			$orders_id = Db::getLastInsID();
		} else {
			return $this->error('错误！');
		}
		foreach ($cart as $key => $value) {
			$ordersGoodsData['order_id'] 		= $orders_id;
			$ordersGoodsData['goods_id'] 		= $value['goods_id'];
			$ordersGoodsData['name']			= $lists[$key]['name'];
			$ordersGoodsData['price'] 			= $lists[$key]['price'];
			$ordersGoodsData['departure_time'] 	= $value['departure_time'];
			$ordersGoodsData['man_num'] 		= $value['man_num'];
			$ordersGoodsData['child_num'] 		= $value['child_num'];
			$ordersGoodsResult = Db::name('OrdersGoods')->insert($ordersGoodsData);
			Db::name('Cart')->where('id',$value['cart_id'])->where(['status'=>1])->update(['status'=>2]);
		}
		
		return $this->success('添加成功','',$order_no);
	}
}