<?php
namespace app\api\controller;

use think\Db;
use think\Request;
use think\controller\Rest;

/**
 * ping++ webhooks
 */
class Webhooks extends Base
{
    /**
     * webhooks
     * @return json
     * @author 
     */
    public function do_post_json()
    {
        //获取当前登录用户
        $pingid = input('post.pingid');
		import('org.util.pingplus.init');
        \Pingpp\Pingpp::setApiKey(config('pingplus.api_key'));

        $raw_data = file_get_contents('php://input');
        // 示例
        // $raw_data = '{"id":"evt_eYa58Wd44Glerl8AgfYfd1sL","created":1434368075,"livemode":true,"type":"charge.succeeded","data":{"object":{"id":"ch_bq9IHKnn6GnLzsS0swOujr4x","object":"charge","created":1434368069,"livemode":true,"paid":true,"refunded":false,"app":"app_vcPcqDeS88ixrPlu","channel":"wx","order_no":"2015d019f7cf6c0d","client_ip":"140.227.22.72","amount":100,"amount_settle":0,"currency":"cny","subject":"An Apple","body":"A Big Red Apple","extra":{},"time_paid":1434368074,"time_expire":1434455469,"time_settle":null,"transaction_no":"1014400031201506150354653857","refunds":{"object":"list","url":"/v1/charges/ch_bq9IHKnn6GnLzsS0swOujr4x/refunds","has_more":false,"data":[]},"amount_refunded":0,"failure_code":null,"failure_msg":null,"metadata":{},"credential":{},"description":null}},"object":"event","pending_webhooks":0,"request":"iar_Xc2SGjrbdmT0eeKWeCsvLhbL"}';
        $headers = \Pingpp\Util\Util::getRequestHeaders();
        // 签名在头部信息的 x-pingplusplus-signature 字段
        $signature = isset($headers['X-Pingplusplus-Signature']) ? $headers['X-Pingplusplus-Signature'] : NULL;
        // 示例
        // $signature = 'BX5sToHUzPSJvAfXqhtJicsuPjt3yvq804PguzLnMruCSvZ4C7xYS4trdg1blJPh26eeK/P2QfCCHpWKedsRS3bPKkjAvugnMKs+3Zs1k+PshAiZsET4sWPGNnf1E89Kh7/2XMa1mgbXtHt7zPNC4kamTqUL/QmEVI8LJNq7C9P3LR03kK2szJDhPzkWPgRyY2YpD2eq1aCJm0bkX9mBWTZdSYFhKt3vuM1Qjp5PWXk0tN5h9dNFqpisihK7XboB81poER2SmnZ8PIslzWu2iULM7VWxmEDA70JKBJFweqLCFBHRszA8Nt3AXF0z5qe61oH1oSUmtPwNhdQQ2G5X3g==';
        // 请从 https://dashboard.pingxx.com 获取「Ping++ 公钥」
        $pub_key_path = "./ping++_rsa_public_key.pem";
        $result = $this->verify_signature($raw_data, $signature, $pub_key_path);
        if ($result === 1) {
            // 验证通过
        } elseif ($result === 0) {
            http_response_code(400);
            echo 'verification failed';
            exit;
        } else {
            http_response_code(400);
            echo 'verification error';
            exit;
        }
        $event = json_decode($raw_data, true);
        if ($event['type'] == 'charge.succeeded') {
            $charge = $event['data']['object'];
            if ($charge['order_no'] && $charge['paid']) {

                $ordersInfo = Db::name('Orders')->where(['order_no'=>$charge['order_no']])->find();
                
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
                    $data['trade_no'] 		= $charge['transaction_no'];
                    $data['trade_status'] 	= 'SUCCESS';
                    $ordersStatusResult = Db::name('OrdersStatus')->insert($data);
                    
                    if ($ordersrResult && $ordersStatusResult) {
                        // 更改购物车状态
                        $score = 0;
                        $goodsList = Db::name('OrdersGoods')->where('order_id',$ordersInfo['id'])->select();
                        foreach ($goodsList as $key => $value) {
                            Db::name('Cart')->where('goods_id',$value['goods_id'])->where(['status'=>1])->update(['status'=>2]);
                            $GoodsInfo = Db::name('Goods')->where('id',$value['goods_id'])->find();
                            // 计算赠送积分合计
                            $score = $score+$GoodsInfo['score'];
                        }
                        Db::name('Users')->where('id',$ordersInfo['uid'])->setInc('score', $score);
                        
                        Db::commit();
                        //开启小票打印机且接口数据填好时，执行打印操作
                        if(config('web_allow_ticket')){
                            $res = actionprint(config('web_site_title'),$out_trade_no,'APP端支付',$goodsList);
                        }
                        http_response_code(200); // PHP 5.4 or greater
                        return $this->restSuccess('处理成功！');
                    } else {
                        Db::rollback();
                        return $this->restError('订单异常！');
                    }
                            
                    http_response_code(200); // PHP 5.4 or greater

                }

            }

        } elseif ($event['type'] == 'refund.succeeded') {
            //$refund = $event['data']['object'];
            // ...
            http_response_code(200); // PHP 5.4 or greater
        } else {
            /**
             * 其它类型 ...
             * - summary.daily.available
             * - summary.weekly.available
             * - summary.monthly.available
             * - transfer.succeeded
             * - red_envelope.sent
             * - red_envelope.received
             * ...
             */
            http_response_code(200);
            // 异常时返回非 2xx 的返回码
            // http_response_code(400);
        }
    }

    // 验证 webhooks 签名方法
    protected function verify_signature($raw_data, $signature, $pub_key_path) {
        $pub_key_contents = file_get_contents($pub_key_path);
        // php 5.4.8 以上，第四个参数可用常量 OPENSSL_ALGO_SHA256
        return openssl_verify($raw_data, base64_decode($signature), $pub_key_contents, 'sha256');
    }

}
