<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: wangjingjing<1064868847@qq.com> <http://www.ixiaoquan.com>
// +----------------------------------------------------------------------

namespace app\index\controller;

use think\Db;
use think\Log;

/**
* 微信支付
* @author tangtanglove
*/
class Wxpay extends Base
{

	/**
	* 微信支付首页
	* @author tangtanglove
	*/
	public function index()
	{
		$uid = session('index_user_auth.uid');
		if (empty($uid)) {
			$this->error('未登录！',url('login'));
		}
		$order_no 	= input('get.order_no');
		$ordersInfo = Db::name('Orders')->where(['order_no'=>$order_no,'uid'=>$uid])->find();
		if(empty($ordersInfo)){
			$this->error('参数错误');
		}
		$this->assign('order_no',$order_no);
		return $this->themeFetch('pay_index');
	}

	/**
	* 微信支付
	* @author tangtanglove
	*/
	public function pay()
	{
		$uid = session('index_user_auth.uid');
		if (empty($uid)) {
			$this->error('未登录！');
		}
		$order_no = input('get.order_no');
		$ordersInfo = Db::name('Orders')->where(['order_no'=>$order_no,'uid'=>$uid])->find();

		if(empty($ordersInfo)){
			$this->error('参数错误');
		}

		import('org.util.pay.Wxpay.NativePay');
		import('org.util.pay.Wxpay.Api');
		import('org.util.pay.Wxpay.WxPayConfig');
		import('org.util.pay.Wxpay.Data');
		import('org.util.pay.Wxpay.Exception');
		import('org.util.pay.Wxpay.Notify');

		//模式二
		/**
		 * 流程：
		 * 1、调用统一下单，取得code_url，生成二维码
		 * 2、用户扫描二维码，进行支付
		 * 3、支付完成之后，微信服务器会通知支付成功
		 * 4、在支付成功通知中需要查单确认是否真正支付成功（见：notify.php）
		*/
		$money 		= $ordersInfo['amount']*100;
		// 接收订单状态url
		$notifyUrl 	= config('enter_url').'/index/wxpay/notify_url.html';
		$notify 	= new \NativePay();
 		$input 		= new \WxPayUnifiedOrder();
		$input->SetBody('订单号：'.$order_no);
		$input->SetOut_trade_no($order_no);
		$input->SetTotal_fee($money);
		$input->SetTime_start(date("YmdHis",$ordersInfo['createtime']));
		$input->SetNotify_url($notifyUrl);
		$input->SetTrade_type("NATIVE");
		$input->SetProduct_id($ordersInfo['id']);

		$result = $notify->GetPayUrl($input);

		if(!$result["code_url"]){
			$this->error('您的订单已支付');
		}
		$codeUrl = $result["code_url"];
		$this->assign('codeUrl',$codeUrl);
		$this->assign('order_no',$order_no);
		return $this->themeFetch('wxpay');
	}
	
	/**
	* 微信同步通知
	* @author tangtanglove
	*/
	public function getOrderStatus() {

		$uid = session('index_user_auth.uid');
		if (empty($uid)) {
			$this->error('未登录！',url('login'));
		}
		$order_no = input('get.order_no');
		$ordersInfo = Db::name('Orders')->where(['order_no'=>$order_no,'uid'=>$uid])->find();

		if(empty($ordersInfo)){
			$this->error('参数错误');
		}

		$this->success($ordersInfo['status']);
	}

	/**
	* 微信同步通知跳转页面
	* @author tangtanglove
	*/
	public function return_url() {

		$uid = session('index_user_auth.uid');
		if (empty($uid)) {
			$this->error('未登录！',url('login'));
		}

		$order_no = input('get.order_no');
		$ordersInfo = Db::name('Orders')->where(['order_no'=>$order_no,'uid'=>$uid])->find();

		if(empty($ordersInfo)){
			$this->error('参数错误');
		}

		$content = "您已成功支付".$ordersInfo['amount']."元，订单号：".$order_no;
		$this->assign('content',$content);
		$this->assign('ordersInfo',$ordersInfo);
		return $this->themeFetch('return_url');
	}

	/**
	* 微信异步通知
	* @author tangtanglove
	*/
	public function notify_url()
	{
		// 获取返回的post数据包
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"] ;
		$out_trade_no = "";
		if (!empty($postStr)){
			libxml_disable_entity_loader(true);
			$postObj = (array)simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
			$out_trade_no = $postObj['out_trade_no'];
			// 订单状态处理
			Db::startTrans();

			// 修改订单 状态
			$ordersData['status'] = 'paid';
			$ordersData['is_pay'] = 1;
			$ordersResult = Db::name('Orders')->where(array('order_no'=>$out_trade_no))->update($ordersData);
			$ordersInfo = Db::name('Orders')->where(['order_no'=>$out_trade_no])->find();
			$data['order_id'] 		= $ordersInfo['id'];
			$data['status']   		= 'paid';
			$data['createtime'] 	= time();
			$data['trade_no'] 		= $postObj['transaction_id'];
			$data['trade_status'] 	= 'SUCCESS';
			$ordersStatusResult = Db::name('OrdersStatus')->insert($data);

			//用户购买获得积分
			$score_info = Db::name('OrdersGoods')
			->alias('a')
	        ->join('goods b','b.id= a.goods_id','LEFT')
	        ->where(['a.order_id'=>$ordersInfo['id']])
	        ->field('a.num,b.score')
	        ->find();

	        $add_score = $score_info['score']*$score_info['num'];
	        if($add_score){
	        	DB::name('Users')->where(['id'=>$ordersInfo['uid']])->update(['score' => ['exp','score+'.$add_score]]);
			}

			if($ordersResult && $ordersStatusResult){
				// 更改购物车状态
				$goodsList = Db::name('OrdersGoods')->where('order_id',$ordersInfo['id'])->select();
				foreach ($goodsList as $key => $value) {
					Db::name('Cart')->where('goods_id',$value['goods_id'])->where(['status'=>1])->update(['status'=>2]);
				}
				Db::commit();
				//开启小票打印机且接口数据填好时，执行打印操作
				if(config('web_allow_ticket')){
					$res = actionprint(config('web_site_title'),$out_trade_no,'PC端微信支付',$goodsList);
				}	
				$result = "<xml>
				<return_code><![CDATA[SUCCESS]]></return_code>
				<return_msg><![CDATA[OK]]></return_msg>
				</xml>";
			}else{
				Db::rollback();
				$result = "<xml>
				<return_code><![CDATA[FAIL]]></return_code>
				<return_msg><![CDATA[未接收到post数据]]></return_msg>
				</xml>";
			}
				
		}else {	
			$result = "<xml>
			<return_code><![CDATA[FAIL]]></return_code>
			<return_msg><![CDATA[未接收到post数据]]></return_msg>
			</xml>";
		}
		echo $result;	
	}
}