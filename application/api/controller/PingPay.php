<?php
namespace app\api\controller;

use think\Db;
use think\Loader;
use think\Request;
use think\controller\Rest;

/**
 * 用户支付
 */
class Pingpay extends Common
{
    /**
     * 创建支付对象
     * @return json
     * @author 
     */
    public function pay_get_json()
    {
		$order_no = input('get.order_no');
		$pay_type = input('get.pay_type');
        // 保持传参风格统一
        if($pay_type == 'wxpay') {
            $pay_type ='wx';
        }
		$ordersInfo = Db::name('Orders')->where(['order_no'=>$order_no,'uid'=>UID])->find();

		if(empty($ordersInfo)){
			$this->restError('参数错误');
		}

		// 订单名称，必填
		$subject = '订单号：'.$order_no;
        $body    = '商品订单号'+$order_no;
        $amount  = $ordersInfo['amount']*100;
        // ping++支付
        $result = $this->pingPlus($pay_type,$subject,$body,$amount,$order_no);
        if ($result['status']==1) {
            //返回数据
            return $this->restSuccess('提交成功！',$result);
        } else {
            //返回数据
            return $this->restError($result);
        }
    }

    /**
     * 构建ping++订单
     * @return json
     * @author tangtanglove
     */
    public function pingPlus($channel,$subject,$body,$amount,$order_no)
    {
        // 引入ping++类库
		import('org.util.pingplus.init');
        // 设置 api_key，app_id
        $api_key = config('pingplus.api_key');
        $app_id  = config('pingplus.app_id');
        // 加载证书
        \Pingpp\Pingpp::setPrivateKeyPath('./ping++_rsa_private_key.pem');

        $extra = array();
        switch ($channel) {
            case 'alipay':
                $extra = array();
                break;
            case 'wx':
                $extra = array();
                break;
        }

        // 设置 API Key
        \Pingpp\Pingpp::setApiKey($api_key);
        try {
            $data = \Pingpp\Charge::create(
                array(
                    'subject'   => $subject,
                    'body'      => $body,
                    'amount'    => $amount,
                    'order_no'  => $order_no,
                    'currency'  => 'cny',
                    'extra'     => $extra,
                    'channel'   => $channel,
                    'client_ip' => config('pingplus.client_ip'),
                    'app'       => array('id' => $app_id)
                )
            );
            $return['status'] = 1;
            $return['data'] = json_decode($data, true);
            return $return;
        } catch (\Pingpp\Error\Base $e) {
            // 捕获报错信息
            if ($e->getHttpStatus() != NULL) {
                $return['status'] = 0;
                $return['data'] = $e->getHttpBody();
            } else {
                $return['status'] = 0;
                $return['data'] = $e->getMessage();
            }
            return $return;
        }
    }

    /**
     * 确认付款成功同步通知
     * @return json
     * @author 
     */
    public function confirmPay_post_json()
    {
        //获取当前登录用户
        $uid              = UID;
        $pingid           = input('post.pingid');
        // 引入ping++类库
		import('org.util.pingplus.init');
        // 加载证书
        \Pingpp\Pingpp::setPrivateKeyPath('./ping++_rsa_private_key.pem');
        \Pingpp\Pingpp::setApiKey(config('pingplus.api_key'));
        $charge     = \Pingpp\Charge::retrieve($pingid);
        $charge_arr = json_decode($charge);
        //接收数据
        if ($charge_arr['order_no'] && $charge_arr['paid']) {
            $ordersInfo = Db::name('Orders')->where(['order_no'=>$charge_arr['order_no']])->find();
            if (empty($ordersInfo)) {
               return $this->restError('订单异常！');
            } else {
                
                // 开启事务
                Db::startTrans();

                // 更新订单状态
                $orderdata['status'] = 'paid';
                $orderdata['is_pay'] = 1;
                $ordersrResult = Db::name('Orders')->where(['order_no'=>$charge['order_no']])->update($orderdata);
                
                // 插入订单状态
                $data['order_id'] 		= $ordersInfo['id'];
                $data['status']   		= 'paid';
                $data['createtime'] 	= time();
                $data['trade_no'] 		= $trade_no;
                $data['trade_status'] 	= $trade_status;
                $ordersStatusResult = Db::name('OrdersStatus')->insert($data);
                
                if ($ordersrResult && $ordersStatusResult) {
                    // 更改购物车状态
                    $goodsList = Db::name('OrdersGoods')->where('order_id',$ordersInfo['id'])->select();
                    foreach ($goodsList as $key => $value) {
                        Db::name('Cart')->where('goods_id',$value['goods_id'])->where(['status'=>1])->update(['status'=>2]);
                    }
                    Db::commit();
                    return $this->restSuccess("支付成功！");
                } else {
                    Db::rollback();
                    return $this->restError("支付失败，请联系客服！");
                }
            }
        }

    }

	/**
	* 支付成功
	* @author tangtanglove
	*/
	public function paySuccess_get_json()
    {
		$uid = UID;
		if (empty($uid)) {
			return $this->restError('未登录！');
		}
		$order_no = input('get.order_no');
		$ordersInfo = Db::name('Orders')->where(['order_no'=>$order_no,'uid'=>$uid])->find();
		if(empty($ordersInfo)){
			return $this->restError('参数错误');
		}
        $data['content'] = "您已成功支付".$ordersInfo['amount']."元，订单号：".$order_no;
        $data['order_id'] = $ordersInfo['id'];
        return $this->restSuccess('提交成功！',$data);
	}

}
