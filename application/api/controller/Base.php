<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: tangtnglove <dai_hang_love@126.com> <http://www.ixiaoquan.com>
// +----------------------------------------------------------------------

namespace app\api\controller;

use think\Db;
use think\Loader;
use think\Request;

/**
 * 系统基础控制器：不需登录
 * @author  tangtnglove <dai_hang_love@126.com>
 */
class Base extends Rest
{
    /**
     * api用户登录
     * @author  tangtnglove <dai_hang_love@126.com>
     */
    public function login_post_json()
    {
        $username = input('post.username');
        $password = input('post.password');
        // 实例化验证器
        $validate = Loader::validate('Login');
        // 验证数据
        $data = ['username'=>$username,'password'=>$password];
        // 加载语言包
        $validate->loadLang();
        // 验证
        if(!$validate->check($data)){
            $this->restError($validate->getError());
        }
        $where['username'] = $username;
        $where['status']   = 1;
        $userInfo = Db::name('Users')->where($where)->find();
        if ($userInfo && $userInfo['password'] === minishop_md5($password,$userInfo['salt'])) {
            $user['id']        = $userInfo['id'];
            $user['salt']      = $userInfo['salt'];
            // 生成token
            $result['token'] = $this->creatToken($user);
            $result['uid']   = $user['id'];
            $result['code']  = 1;
            // 返回数据
            return json($result, 200);
        } else {
            return $this->restError('登陆失败！');
        }

    }

    /**
     * api用户注册
     * @author  tangtnglove <dai_hang_love@126.com>
     */
    public function register_post_json()
    {
        // 接收post数据
        $username          = input('post.username');//用户名
        $nickname          = input('post.nickname');//昵称
        $mobile            = input('post.mobile');//手机号
        $password          = input('post.password');//密码
        $repassword        = input('post.repassword');//密码
        $code              = input('post.code');
        
        //校验验证码
        $res = $this->checkcode($code,$mobile);
        if($res==true) {
            // 实例化验证器
            $validate = Loader::validate('Member');                
            // 验证数据
            $data = [
                'username'=>$username,
                'nickname'=>$nickname,
                'mobile'  =>$mobile,
                'password'=>$password,
                'repassword'=>$repassword,
            ];
            // 验证
            if (!$validate->scene('register')->check($data)) {
                return $this->restError($validate->getError());
            }         
            $value['uuid']          = create_uuid();
            $value['username']      = $username;
            $value['nickname']      = $nickname;
            $value['mobile']        = $mobile;
            $value['salt']          = create_salt();
            $value['password']      = minishop_md5($password,$value['salt']);
            $value['regdate']       = time();
            $value['status']        = '1';
            //插入数据表
            $res = Db::name('Users')->insert($value);
            if($res) {
                return $this->restSuccess('注册成功!');
            } else {
                return $this->restError('注册失败！');
            } 
        }

    }

    /**
     * 验证码校验方法
     * @author  完美°ぜ界丶
     */
    public function checkcode($code,$mobile)
    {   
        $mobile = $mobile;
        $code   = $code;     
        $now_time =  time();//输入验证码的时间
        $yz       =  Db::name('Code')->where('mobile',$mobile)->field('yzm_time,code,num')->find();
        $time     =  $now_time-$yz['yzm_time'];
        //检验是否输入
        if(!($code)) {
            return $this->restError('请输入验证码');
        } else if($this->updateNum()== 0) {
            return $this->restError('输入次数超过限制，请重新获取');
        } else if($time>config('sms_expiry')) {
            //检验是否过期
            return $this->restError('验证码已过期');
        } else if($code!==$yz['code']) {
            return $this->restError('验证码错误');
        } else {
            Db::name('Code')->where('mobile',$mobile)->update(['code'=>$code,'yzm_time'=>$now_time]);
            return true;
        }
    }

     /**
     * 系统验证码方法
     * @author  tangtnglove <dai_hang_love@126.com>
     */
    public function captcha()
    {
        $captcha = new \org\Captcha(config('captcha'));
        $captcha->entry();
    }

     /**
     * 更新验证码输入次数
     * @author 完美°ぜ界丶
     */
     protected function updateNum()
     {
        //接收输入
        $mobile = input('post.mobile');
        $res = Db::name('Code')->where('mobile',$mobile)->find();
        $res['num'] = $res['num']+1;
        if($res['num']>config('sms_num')){ 
            return 0; 
        } else {
            Db::name('Code')->where('mobile',$mobile)->update(['num'=>$res['num']]);
            return 1;
        }

     }

    /**
     * creatToken 生成TOKEN
     * @param  array &$user  用户信息数组
     * @return string        TOKEN
     * @author tangtnglove <dai_hang_love@126.com>
     */
    protected function creatToken(&$user){
        if (is_array($user)) {
            $data['uid']     = $user['id'];
            $data['token']   = minishop_md5($user['id'].time(),$user['salt']);
            //将TOKEN缓存
            cache('api_token_'.$data['token'], $data, config('token_valid'));
            return $data['token'];
        }
        return $this->restError('生成token失败！');
    }

    /**
     * checkLogin 非继承Common的类运用此方法判断登录
     * @param string $token TOKEN
     * @author tangtnglove <dai_hang_love@126.com>
     */
    protected function checkLogin($uid,$token){
        //判断TOKEN
        if (empty($token) || empty($uid)) {
            //返回登录页
            return $this->restError('未授权');
        }
        $cache = cache('api_token_'.$token);
        // 验证是否失效
        if(empty($cache)) {
           return  $this->restError('TOKEN失效',-1);
        }
        // 验证身份
        if($cache[uid] !== $uid) {
            return $this->restError('身份不符！');
        }
    }

}
