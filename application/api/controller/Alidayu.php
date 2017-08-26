<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 完美°ぜ界丶 
// +----------------------------------------------------------------------
namespace app\api\controller;

use think\Controller;
use think\Request;
use think\Db;
use think\Loader;

class Alidayu extends Base {

    public function index()
    {   
        // 短信配置信息
        $appkey           = config('sms_appkey');//你的App key
        $secret           = config('sms_appsecret');//你的App Secret:
        $sms_templatecode = config('sms_template_code');
        $sms_signname     = config('sms_signname');

        $ab               = $this->randstring();//获取随机数字        
        $mobile           = input('post.mobile');//接收手机号码
        $captcha          = input('post.captcha');//接收的验证码
        // 验证
        // 实例化验证器
        $validate = Loader::validate('Login');
        // 验证数据
        $data = ['mobile'=>$mobile,'captcha'=>$captcha];
        // 加载语言包
        $validate->loadLang();
        // 验证
        if(!$validate->scene('sms_login')->check($data)) {
            return $this->restError($validate->getError());
        }
        $data['yzm_time'] = time(); 
        $data['code']     = $ab;
        $data['num']      = 0;
        $data['mobile']   = $mobile;
        $data['captcha']  = $captcha;
        $res              = Db::name('Code')->where('mobile',$mobile)->find();
        if($res) {
            $interval_time    = $data['yzm_time']-$res['yzm_time'];
            if($interval_time<config('sms_interval')) {
                $data['message']='发送太频繁请稍后重试';

                return $this->restError($data['message']);
            } else {
                $data['num'] = 0;
                Db::name('Code')->where('mobile',$mobile)->update($data);
            }
        } else {
            Db::name('Code')->where('mobile',$mobile)->insert($data);
        }

        import('org.util.taobao.top.TopClient');
        import('org.util.taobao.top.ResultSet');
        import('org.util.taobao.top.RequestCheckUtil');
        import('org.util.taobao.top.TopLogger');
        import('org.util.taobao.top.request.AlibabaAliqinFcSmsNumSendRequest');
        // 将需要的类引入，并且将文件名改为原文件名.php的形式
        $c = new \TopClient;
        $c->appkey = $appkey;
        $c->secretKey = $secret;
        $req = new \AlibabaAliqinFcSmsNumSendRequest;
        $req->setExtend("123456");//确定发给的是哪个用户，参数为用户id
        $req->setSmsType("normal");
    
        $req->setSmsFreeSignName($sms_signname);
        $req->setSmsParam("{'code':'".$ab."','product':'小微企业'}");       
        $req->setRecNum("".$mobile."");//参数为用户的手机号码
        $req->setSmsTemplateCode($sms_templatecode);
        $resp = $c->execute($req);

        if($resp->result->success ){
            $data['message']="发送成功";
            return $this->restSuccess($data['message']);
        }else{
            $data['message']="发送失败";
            return $this->restError($data['message']);
        }
        
    }

    /**
    * 获取随机位数数字
    * @param  integer $len 长度
    * @return string       
    */
    protected static function randString($len = 6)
    {
        $chars = str_repeat('0123456789', $len);
        $chars = str_shuffle($chars);
        $str   = substr($chars, 0, $len);
        return $str;
    }

   
}