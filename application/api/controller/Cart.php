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
use think\controller\Rest;

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
	public function index_post_json()
	{
		$carlists 	 = json_decode(input('carlists'));
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

		}

		$where['a.uid'] 	= UID;
		$where['a.status'] 	= 1;
		$where['b.status']  = 1;
        $lists = Db::name('Cart')->alias('a')->join('goods b','b.id=a.goods_id','LEFT')
        ->where($where)
		->order('id desc')
        ->field('a.num as cart_num,b.*')
        ->select();

        foreach ($lists as $key => $value) {
            $lists[$key]['cover_path'] = str_replace('/uploads', 'http://'.$_SERVER['HTTP_HOST'].__ROOT__.'/uploads', $value['cover_path']);
			$lists[$key]['selectGoods'] = 0;
			if($selectGoods) {
				foreach ($selectGoods as $selectKey => $selectValue) {
					if($selectValue == $lists[$key]['id']) {
						$lists[$key]['selectGoods'] = 1;
					}
				}
			}
        }

		// 输出选中的商品id
        if(!empty($lists)) {
			$data['cartMoney'] 		= $cartMoney;
			$data['lists'] 			= $lists;
            return $this->restSuccess('获取成功！',$data);
        } else {
            return $this->restError('没有数据了！');
        }
	}

	/**
	* 选择收货地址
	* @author tangtanglove
	*/
	public function selectAddress_get_json()
	{
		// 获取配送区域
		$ordersAddressLists = Db::name('OrdersAddress')->where(['uid'=>UID,'status'=>1])->select();
        if(!empty($ordersAddressLists)) {
            return $this->restSuccess('获取成功！',$ordersAddressLists);
        } else {
            return $this->restError('没有数据了！');
        }

	}

	/**
	* 检查订单信息
	* @author tangtanglove
	*/
	public function checkOrder_post_json()
	{
		$addressid 	= input('address_id');
		$cart 		= json_decode(input('cart'));
		if (!$cart) {
			return $this->restError('请选择数据！');
		}
		$cartMoney   = 0;
		foreach ($cart as $key => $value) {
			$goodsInfo = Db::name('Goods')->where(['id'=>$value['0'],'status'=>1])->find();
			if(empty($goodsInfo)) {
				return $this->restError('此商品已下架！');
			}
			$goodsInfo['cart_num'] = $value['1'];
			$lists[$key] = $goodsInfo;
		}
		if (empty($lists)) {
			return $this->restError('请选择数据！');
		}
		// 获取配送区域
		$ordersAddressInfo = Db::name('OrdersAddress')->where(['uid'=>UID,'id'=>$addressid])->find();

        foreach ($lists as $key => $value) {
            $lists[$key]['cover_path'] = str_replace('/uploads', 'http://'.$_SERVER['HTTP_HOST'].__ROOT__.'/uploads', $value['cover_path']);
        }

        if(!empty($lists)) {
			$data['ordersAddressInfo'] 	= $ordersAddressInfo;
			$data['lists'] 				= $lists;
            return $this->restSuccess('获取成功！',$data);
        } else {
            return $this->restError('没有数据了！');
        }
	}

	/**
	* 提交订单
	* @author tangtanglove
	*/
	public function postOrder_post_json()
	{
		$cart 	= json_decode(input('cart'));
		$paytype 	= input('paytype');
		$addressid 	= input('address_id');

		if (!$cart) {
			return $this->restError('请选择数据！');
		}

		// 计算总金额
		$cartMoney   = 0;
		foreach ($cart as $key => $value) {
			$goodsInfo = Db::name('Goods')->where(['id'=>$value['0'],'status'=>1])->find();
			if(empty($goodsInfo)) {
				return $this->restError('此商品已下架！');
			}
			// 判断数量是合法
			$num = intval($value['1']);
			if($num<=0 || !is_int($num)) {
				return $this->restError('请输入正确的数量！');
			}
			// 保存数据
			$lists[$key]['info'] = $goodsInfo;
			$lists[$key]['num']  = $num;
			// 计算购物车合计
			$cartMoney = $cartMoney+$num*$goodsInfo['price'];
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
			return $this->restError('此订单号已经存在！');
		}
		
		$ordersResult = Db::name('Orders')->insert($data);
		if (false != $ordersResult) {
			$orders_id = Db::getLastInsID();
		} else {
			return $this->restError('错误！');
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
			$orderResult['paytype']  = 'wxpay';
			$orderResult['order_no'] = $order_no;
            return $this->restSuccess('提交成功！',$orderResult);
		} elseif($paytype == 'alipay') {
			$orderResult['paytype']  = 'alipay';
			$orderResult['order_no'] = $order_no;
            return $this->restSuccess('提交成功！',$orderResult);
		} else {
			return $this->restError('支付方式错误！');
		}
	}

	/**
	* 添加收货地址
	* @author tangtanglove
	*/
	public function addAddress_post_json()
	{
		$consignee_name = input('consignee_name');
		$province 		= input('province');
		$city 			= input('city');
		$county 		= input('county');
		$address 		= input('address');
		$mobile 		= input('mobile');

		if (empty($consignee_name) || empty($province) || empty($city) || empty($address) || empty($mobile)) {
			return $this->restError('参数错误！');
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
			return $this->restSuccess('添加成功',['address_id'=>$id]);
		} else {
			return $this->restError('添加失败！');
		}

	}

	/**
     * 删除单个购物信息
     * @author tangtanglove
	 */
	public function delete_post_json()
	{
		$goodsid = input('post.id');
		if(empty($goodsid)) {
			return $this->restError('请选择数据！');
		}
		$result = Db::name('Cart')->where('goods_id',$goodsid)->where(['uid'=>UID,'status'=>1])->delete();
		if(false !=$result) {
			return $this->restSuccess('删除成功！');
		} else {
			return $this->restError('删除失败！');
		}
	}

	/**
     * 删除多个购物信息
     * @author tangtanglove
	 */
	public function deleteAll_post_json()
	{
		$goodsids = input('post.ids');
		if(empty($goodsids)) {
			return $this->restError('请选择数据！');
		}
		$result = Db::name('Cart')->where('goods_id','in',$goodsids)->where(['uid'=>UID,'status'=>1])->delete();
		if(false !=$result) {
			return $this->restSuccess('删除成功！');
		} else {
			return $this->restError('删除失败！');
		}
	}

	/**
	* 订单收藏
	* @author tangtanglove
	*/
	public function collection_post_json()
	{
		$goods_ids 	 = json_decode(input('goods_ids'));
		if (!$goods_ids) {
			return $this->restError('请选择数据！');
		}
		foreach ($goods_ids as $key => $value) {
			$data['uid'] 		= UID;
			$data['goods_id'] 	= $value;
			$data['createtime'] = time();
			$hasGoodsCollection = Db::name('GoodsCollection')->where(['uid'=>UID,'goods_id'=>$value])->find();
			if(empty($hasGoodsCollection)) {
				Db::name('GoodsCollection')->insert($data);
			}
		}

		return $this->restSuccess('收藏成功！');
	}

}