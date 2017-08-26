<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: tangtanglove <dai_hang_love@126.com> <http://www.ixiaoquan.com>
// +----------------------------------------------------------------------

namespace app\admin\validate;

use think\Validate;

class Login extends Validate
{
    protected $rule =   [
        'username'  => 'require',
        'password'  => 'require',
        'captcha' 	=> 'require|checkCaptcha:null',    
    ];

    protected $message  =   [];

    // 加载语言包
    public function loadLang(){
    	$login_not_null = '用户名或密码不能为空！';
        $code_not_null  = '验证码错误！';
        $this->message = [
	        'username.require' => $login_not_null,
	        'password.require' => $login_not_null,
            'captcha.require'  => $code_not_null,
        ];
    }
    
    // 验证码合法性
    protected function checkCaptcha($value)
    {
	    $captcha = new \org\Captcha();
	    if($captcha->check($value)) {
	    	return true;
	    } else {
	    	return '验证码错误！';
	    }
    }

}