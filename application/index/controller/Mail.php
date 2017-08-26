<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 完美°ぜ界丶 
// +----------------------------------------------------------------------
namespace app\index\Controller;

use think\Controller;
use think\Request;
use think\Db;
use think\Loader;

class Mail extends Base 
{
	public function index()
	{
		 if(Request::instance()->isPost()) {
            $email        = input('post.email');
            $username     = input('post.username');
            $title        = '您好，您正在进行邮箱验证';
            $hasUser = Db::name('Users')
            ->where(['username'=>$username,'email'=>$email])
            ->find();
            if($hasUser) {
                $uid        = $hasUser['id'];
                $username   = $hasUser['username'];
                $data['passtime']   = time();
                //生成token
                $token = md5($hasUser['salt'].$username.$data['passtime']);
                $data['token'] = $token;
                //保存记录
                $session['salt'] = $hasUser['salt'];
                $session['username'] = $username;
                session('EmailUser',$session);               
                $time        = date('Y-m-d H:i');
                $url         = config('enter_url').'/index/base/emailCheck?email='.$email."&token=".$token;
                $result      = SendMail($title,$username,$time,$email,$url);
                if ($result==1) {
                	$hasEmail = Db::name('EmailCheck')->where(['email'=>$email,'username'=>$username])->find();                 
                	if($hasEmail) {
                		Db::name('EmailCheck')->where(['email'=>$email,'username'=>$username])->update($data);               		
                	} else {
                        $data['email']    = $email;
                        $data['username'] = $username;
                		Db::name('EmailCheck')->insert($data);
                	}

                	return $this->success('系统已向您的邮箱发送了一封邮件<br/>请登录到您的邮箱及时重置您的密码!');
                	
                } else {
                	return $this->error('发送失败');
                }
            } else {
                return $this->error('用户不存在');
            }
        } else {
		    return $this->themeFetch('get_password');
	    }
		

	}

	

}