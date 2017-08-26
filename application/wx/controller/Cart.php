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

/**
 * 购物车控制器
 * @author tangtanglove
 */
class Cart extends Base
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
        return $this->themeFetch('cart_index');
	}

	/**
	* 选择收货地址
	* @author tangtanglove
	*/
	public function selectAddress()
	{
		$cart = input('cart/a');
		if (!$cart) {
			return $this->error('请选择数据！',url('index'));
		}

		// 考虑页面传参太复杂，用session传购物车参数
		session('cartInfo',$cart);
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

		$this->assign('lists',$lists);
		$this->assign('ordersAddressLists',$ordersAddressLists);
		$this->assign('cartMoney',$cartMoney);

		// 如果为空，则添加新地址
		if(empty($ordersAddressLists)) {
			return $this->themeFetch('cart_add_address');
		} else {
        	return $this->themeFetch('cart_select_address');
		}

	}

	/**
	* 检查订单信息
	* @author tangtanglove
	*/
	public function checkOrder()
	{
		$addressid 	= input('address_id');
		$cart = session('cartInfo');
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
		$ordersAddressInfo = Db::name('OrdersAddress')->where(['uid'=>UID,'id'=>$addressid])->find();

		// 判断是否在微信中
		if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
			$agent = 'wxpay';
		} else {
			$agent = 'alipay';
		}

		$this->assign('ordersAddressInfo',$ordersAddressInfo);
		$this->assign('cartMoney',$cartMoney);
		$this->assign('agent',$agent);
		$this->assign('lists',$lists);
        return $this->themeFetch('cart_check_info');
	}

	/**
	* 提交订单
	* @author tangtanglove
	*/
	public function postOrder()
	{
		$cart 		= session('cartInfo');
		$paytype 	= input('paytype');
		$addressid 	= input('address_id');
		$formToken 	= input('formToken');
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
			if (trim($arrvalue['0']) == 'yes') {
				$goodsInfo = Db::name('Goods')->where(['id'=>$arrvalue['1'],'status'=>1])->find();
				if(empty($goodsInfo)) {
					return $this->error('此商品已下架！');
				}
				// 判断数量是合法
				$arrvalue['3'] = intval($arrvalue['3']);
				if($arrvalue['3']<=0 || !is_int($arrvalue['3'])) {
					return $this->error('请输入正确的数量！',url('index'));
				}
				// 保存数据
				$lists[$key]['info'] = $goodsInfo;
				$lists[$key]['num']  = $arrvalue['3'];
				// 计算购物车合计
				$cartMoney = $cartMoney+$arrvalue['3']*$goodsInfo['price'];
			}
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
			return $this->error('此订单号已经存在！',url('index'));
		}
		
		$ordersResult = Db::name('Orders')->insert($data);
		if (false != $ordersResult) {
			$orders_id = Db::getLastInsID();
		} else {
			return $this->error('错误！',url('index'));
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
		// 清空购物车信息
		session('cartInfo',null);

		if ($paytype == 'wxpay') {
			$this->redirect(url('wx/wxpay/pay',['order_no'=>$order_no]));
		} elseif($paytype == 'alipay') {
			$this->redirect(url('wx/alipay/pay',['order_no'=>$order_no]));
		} else {
			return $this->error('支付方式错误！',url('index'));
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
			return $this->error('参数错误！',url('index'));
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
			return $this->success('添加成功',url('checkOrder',['address_id'=>$id]));
		} else {
			return $this->error('添加失败！',url('index'));
		}

	}

	/**
     * 删除单个购物信息
     * @author tangtanglove
	 */
	public function delete()
	{
		$goodsid = input('post.id');
		if(empty($goodsid)) {
			return $this->error('请选择数据！');
		}
		$result = Db::name('Cart')->where('goods_id',$goodsid)->where(['uid'=>UID,'status'=>1])->delete();
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
			return $this->error('请选择数据！',url('index'));
		}
		$result = Db::name('Cart')->where('goods_id','in',$goodsids)->where(['uid'=>UID,'status'=>1])->delete();
		if(false !=$result) {
			return $this->success('删除成功！');
		} else {
			return $this->error('删除失败！');
		}
	}

	/**
	* 订单收藏
	* @author tangtanglove
	*/
	public function collection()
	{
		$cart = input('cart/a');
		if (!$cart) {
			return $this->error('请选择数据！',url('index'));
		}
		$hasSelect = 0;
		foreach ($cart as $key => $value) {
			$arrvalue = explode(',',$value);
			if (trim($arrvalue['0']) == 'yes') {
				$data['uid'] 		= UID;
				$data['goods_id'] 	= $arrvalue['1'];
				$data['createtime'] = time();
				$hasGoodsCollection = Db::name('GoodsCollection')->where(['uid'=>UID,'goods_id'=>$arrvalue['1']])->find();
				if(empty($hasGoodsCollection)) {
					Db::name('GoodsCollection')->insert($data);
				}
				$hasSelect = 1;
			}
		}

		if($hasSelect) {
			return $this->success('收藏成功！');
		} else {
			return $this->error('请选择数据！');
		}
	}

}