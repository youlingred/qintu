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
* 支付宝支付
* @author tangtanglove
*/
class Alipay extends Base
{
	/**
	* 支付宝支付
	* @author tangtanglove
	*/
	public function pay()
	{
		$uid = session('wap_user_auth.uid');
		if (empty($uid)) {
			$this->error('未登录！');
		}
		/**************************请求参数**************************/
		$order_no = input('get.order_no');
		$ordersInfo = Db::name('Orders')->where(['order_no'=>$order_no,'uid'=>$uid])->find();
		if(empty($ordersInfo)){
			$this->error('参数错误');
		}

		// 商户订单号，商户网站订单系统中唯一订单号，必填
		$out_trade_no = $order_no;
		
		// 订单名称，必填
		$subject = '订单号：'.$order_no;
		
		// 付款金额，必填
		$total_fee = $ordersInfo['amount'];
		
		/************************************************************/
		import('org.util.pay.Alipay.AlipayCore');
		import('org.util.pay.Alipay.AlipayMd5');
		import('org.util.pay.Alipay.AlipayNotify');
		import('org.util.pay.Alipay.AlipaySubmit');
		import('org.util.pay.Alipay.AlipayConfig');
		$ac = new \AlipayCongfig();
		$alipay_config =$ac->getcongfig();
		//收银台页面上，商品展示的超链接，必填
		$show_url = url('order/orderDetail',['order_no'=>$order_no]);
		// 构造要请求的参数数组，无需改动
		$parameter = array(
				"service"       	=> "alipay.wap.create.direct.pay.by.user",
				"partner"       	=> $alipay_config['partner'],
				"seller_id"  		=> $alipay_config['seller_id'],
				"payment_type"		=> $alipay_config['payment_type'],
				"notify_url"		=> $alipay_config['notify_wap_url'],
				"return_url"		=> $alipay_config['return_wap_url'],
				"anti_phishing_key"	=> $alipay_config['anti_phishing_key'],
				"exter_invoke_ip"	=> $alipay_config['exter_invoke_ip'],
				"out_trade_no"		=> $out_trade_no,
				"subject"			=> $subject,
				"total_fee"			=> $total_fee,
				"show_url"			=> $show_url,
				"app_pay"			=> "Y",//启用此参数能唤起钱包APP支付宝
				"body"				=> '商品订单号'+$order_no,
				"_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
		);

		// 建立请求
		$alipaySubmit = new \AlipaySubmit($alipay_config);
		$html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
		echo $html_text;
	}
	
	/**
	* 支付宝同步通知
	* @author tangtanglove
	*/
	public function return_url() {

		$uid = session('wap_user_auth.uid');
		if (empty($uid)) {
			$this->error('未登录！');
		}
		import('org.util.pay.Alipay.AlipayCore');
		import('org.util.pay.Alipay.AlipayMd5');
		import('org.util.pay.Alipay.AlipayNotify');
		import('org.util.pay.Alipay.AlipaySubmit');
		import('org.util.pay.Alipay.AlipayConfig');
		$ac = new \AlipayCongfig();
		$alipay_config =$ac->getcongfig() ;
		
		$alipayNotify  = new \AlipayNotify($alipay_config);
		$verify_result = $alipayNotify->verifyReturn();

		$out_trade_no = input('get.out_trade_no');
		$content 	  = '';
		if ($verify_result) {
			// 支付宝交易号
			$trade_no 		= input('get.trade_no');
			// 交易状态
			$trade_status 	= input('get.trade_status');
			
			// ——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
			// 获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表
			$ordersInfo = Db::name('Orders')->where(['order_no'=>$out_trade_no,'uid'=>$uid])->find();
			
			if (empty($ordersInfo)) {
				$this->error('订单异常！');
			} else {
				
				if ($trade_status == 'TRADE_FINISHED' || $trade_status == 'TRADE_SUCCESS' && $ordersInfo['status'] != 'paid') {

					// 开启事务
					Db::startTrans();

					// 更新订单状态
					$orderdata['status'] = 'paid';
					$orderdata['is_pay'] = 1;
					$ordersrResult = Db::name('Orders')->where(['order_no'=>$out_trade_no,'uid'=>$uid])->update($orderdata);
					
					// 插入订单状态
					$data['order_id'] 		= $ordersInfo['id'];
					$data['status']   		= 'paid';
					$data['createtime'] 	= time();
					$data['trade_no'] 		= $trade_no;
					$data['trade_status'] 	= $trade_status;
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
					
					if ($ordersrResult && $ordersStatusResult) {
						// 更改购物车状态
						$goodsList = Db::name('OrdersGoods')->where('order_id',$ordersInfo['id'])->select();
						foreach ($goodsList as $key => $value) {
							Db::name('Cart')->where('goods_id',$value['goods_id'])->where(['uid'=>$uid,'status'=>1])->update(['status'=>2]);
						}
						Db::commit();
						//开启小票打印机且接口数据填好时，执行打印操作
						if(config('web_allow_ticket')){
							$res = actionprint(config('web_site_title'),$out_trade_no,'移动端支付宝支付',$goodsList);
						}	
					} else {
						Db::rollback();
					}
							
					$content = "您已成功支付".$ordersInfo['amount']."元，订单号：".$out_trade_no;
				} else {
					$content = "订单号:".$out_trade_no."，支付失败（错误码：'".$trade_status."'）";
				}
			}
		} else {
			$this->error('支付失败，请重试！');
		}

		if (empty($content)) {
			$content = '支付失败，请重新购买！';
		}

		$this->assign('content',$content);
		$this->assign('ordersInfo',$ordersInfo);
		return $this->themeFetch('return_url');
	}
	
	/**
	* 支付宝异步通知
	* @author tangtanglove
	*/
	public function notify_url()
	{
		import('org.util.pay.Alipay.AlipayCore');
		import('org.util.pay.Alipay.AlipayMd5');
		import('org.util.pay.Alipay.AlipayNotify');
		import('org.util.pay.Alipay.AlipaySubmit');
		import('org.util.pay.Alipay.AlipayConfig');
		$ac = new \AlipayCongfig();
		$alipay_config =$ac->getcongfig() ;
		//计算得出通知验证结果
		$alipayNotify = new \AlipayNotify($alipay_config);
		$verify_result = $alipayNotify->verifyNotify();
		if($verify_result) {
			//商户订单号
			$out_trade_no 	= input('get.out_trade_no');
			
			//支付宝交易号
			$trade_no 		= input('get.trade_no');
			
			//交易状态
			$trade_status 	= input('get.trade_status');
			
			//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
			//获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表
			$ordersInfo = Db::name('Orders')->where(['order_no'=>$out_trade_no])->find();
			
			if (!empty($ordersInfo)) {
				if ($trade_status == 'TRADE_FINISHED') {
					//判断该笔订单是否在商户网站中已经做过处理
					//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
					//请务必判断请求时的total_fee、seller_id与通知时获取的total_fee、seller_id为一致的
					//如果有做过处理，不执行商户的业务程序
			
					//注意：
					//退款日期超过可退款期限后（如三个月可退款），支付宝系统发送该交易状态通知
			
					//调试用，写文本函数记录程序运行情况是否正常
					//logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
				} elseif ($trade_status == 'TRADE_SUCCESS' && $ordersInfo['status'] != 'paid') {

					Db::startTrans();

					$ordersData['status'] = 'paid';
					$ordersData['is_pay'] = 1;
					$ordersResult = Db::name('Orders')->where(['order_no'=>$out_trade_no])->update($ordersData);
					
					// 插入订单状态
					$data['order_id'] 		= $ordersInfo['id'];
					$data['status']   		= 'paid';
					$data['createtime'] 	= time();
					$data['trade_no'] 		= $trade_no;
					$data['trade_status'] 	= $trade_status;
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

					if ($ordersResult && $ordersStatusResult) {
						// 更改购物车状态
						$goodsList = Db::name('OrdersGoods')->where('order_id',$ordersInfo['id'])->select();
						foreach ($goodsList as $key => $value) {
							Db::name('Cart')->where('goods_id',$value['goods_id'])->where(['status'=>1])->update(['status'=>2]);
						}
						Db::commit();
					} else {
						Db::rollback();
					}

				}
			
				//——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
			
				echo "success";		//请不要修改或删除
			} else {
				echo "fail";
			}

		} else {
			//验证失败
			echo "fail";
			//调试用，写文本函数记录程序运行情况是否正常
			//logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
		}
	}
	
}