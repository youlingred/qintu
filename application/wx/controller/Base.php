<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: tangtanglove <dai_hang_love@126.com> <http://www.ixiaoquan.com>
// +----------------------------------------------------------------------

namespace app\wx\controller;

use think\Controller;
use think\Db;
use think\Loader;
use think\Request;
use common\library\Mini;

/**
 * 系统基础控制器：直接登录
 * @author  tangtnglove <dai_hang_love@126.com>
 */
class Base extends Mini
{
    //var $users = '';
        /**
     * 初始化方法
     * @author tangtanglove
     */
    protected function _initialize()
    {

        // 检测程序安装
        if(!is_file(ROOT_PATH . 'data/install.lock')){
            $this->redirect(url('install/index/index'));
        }
        // 储存网站配置
        config(select_key_value('config.base'));
        if (config('web_site_close')) {
            return $this->error('网站已关闭！');
        }
        // 不存在index.php，则定义
        $request = Request::instance();
        //$this->assign('userinfo',$this->users);
        if (!substr_count($request->url(),'wx.php')) {
            //设置请求信息，解决某些环境下面url()方法获取不到index.php
            $request->root('wx.php');
        }
        load_config();// 加载接口配置
        if (session('wx_user_auth')) {
            define('UID', session('wx_user_auth.uid'));
        } else {
            if(!isset($_GET['code'])){
                $this->login();
            }
        }

    }

    /**
     * 用户登录方法
     * @author  vaey
     */
    public function login()
    {
        import('org.util.pay.WxPayPubHelper.WxPayPubHelper');   
        $jsApi    = new \JsApi_pub();   
        $openid   = "";  
        // 通过code获得openid
        if (!isset($_GET['code'])) {
            // 触发微信返回code码
            $enterUrl = config('enter_url').'/Base/login.html';
            $url="https:open.weixin.qq.com/connect/oauth2/authorize?appid=".config('wechat_appid')."&redirect_uri=".$enterUrl."?response_type=code&scope=snsapi_base&state=STATE#wechat_redirect";
            Header("Location:$url");
            exit();
        } else {      
            // 获取code码，以获取openid
            $code    = $_GET['code'];       
            $jsApi->setCode($code);
            $openid  = $jsApi->getOpenId();
        }
        //获取到openid
        if($openid){
            $where['wechat_openid'] = (String)$openid;
            $userInfo = Db::name('Users')->where($where)->find();
            if($userInfo){
                $session['uid']       = $userInfo['id'];
                $session['nickname']  = $userInfo['nickname'];
                $session['last_login']= $userInfo['last_login'];
                // 记录用户登录信息
                session('wx_user_auth',$session);
                define('UID', session('wx_user_auth.uid'));
                // 更新最近登录时间
                Db::name('Users')->where($where)->setField('last_login',time());
                $this->redirect(url('index/index'));
            }else{
                $appid = config('wechat_appid');
                $appsecret = config('wechat_appsecret');
                $access_token = getAccessToken($appid,$appsecret); //获取token
                $url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$access_token.'&openid='.$openid.'&lang=zh_CN';
                $result = curl_file_get_contents($url);
                $data['nickname']       = $result['nickname'];
                $data['last_login']     = time();
                $data['wechat_openid']  = $openid;
                $id = Db::name('Users')->insertGetId($data);
                if($id){
                    $session['uid'] = $id; 
                    $session['nickname']  = $data['nickname'];
                    $session['last_login']  = $data['last_login'];
                    // 记录用户登录信息
                    session('wx_user_auth',$session);
                    define('UID', session('wx_user_auth.uid'));
                    $this->redirect(url('index/index'));
                }
            }
        }else{
            echo "错误";
        }

    }

    private function httpGet($url) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_URL, $url);
        $res = curl_exec($curl);
        curl_close($curl);

        return $res;
    }

}
