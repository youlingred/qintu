<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: tangtanglove <dai_hang_love@126.com> <http://www.ixiaoquan.com>
// +----------------------------------------------------------------------

namespace app\wap\validate;

use think\Validate;
use think\Lang;
use think\Db;

class Login extends Validate
{
    protected $rule =   [
        'username'  => 'require',
        'password'  => 'require', 
        'mobile'    =>  ['regex'=>'/^13[0-9]{1}[0-9]{8}$|15[0-9]{1}[0-9]{8}$|18[0-9]{1}[0-9]{8}$|17[0-9]{9}$/'],
        'captcha'   => 'require|checkCaptcha:captcha',
       

    ];

    protected $message  =   [];

    // 加载语言包
    public function loadLang(){
        $login_not_null = Lang::get('用户名或密码不能为空');
        $mobile_format_error = Lang::get('手机号格式错误');
        $captcha_not_null    = Lang::get('图形验证码不能为空');

        $this->message = [
            'username.require' => $login_not_null,
            'password.require' => $login_not_null,
            'mobile.regex'     => $mobile_format_error,
            'captcha.require'  => $captcha_not_null
        ];
    }

    protected $scene = [

        'login'         =>  ['username','password',],
        'sms_login'     =>  ['mobile','captcha'],
        'mobile_login'  =>  ['mobile','password'],
        
    ]; 

    // 验证码合法性
    protected function checkCaptcha($value)
    {
        $captcha = new \org\Captcha();
        if($captcha->check($value)) {
            return true;
        } else {
            return '图形验证码错误！';
        }
    }  
    

}