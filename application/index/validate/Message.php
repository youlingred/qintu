<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: tangtnglove <dai_hang_love@126.com> <http://www.ixiaoquan.com>
// +----------------------------------------------------------------------

namespace app\index\validate;

use think\Validate;
use think\Lang;
use think\Db;
use think\Input;

class Message extends Validate
{
    protected $rule =   [      
        'nickname'       => 'require',        
        'email'          => 'require|email',            
        'mobile'         => ['regex'=>'/^13[0-9]{1}[0-9]{8}$|15[0-9]{1}[0-9]{8}$|18[0-9]{1}[0-9]{8}$|17[0-9]{9}$/'],
        'mobile'         => 'require',        
        'content'        => 'require',
        'captcha'        => 'require|checkCaptcha:captcha'
    ];

    protected $message  =   [
        'nickname.require '               => '用户昵称不能为空',        
        
        'content.require'                 => '请输入留言内容',
        'captcha.require'                 => '请输入验证码',
        'captcha.checkCaptcha'            => '验证码不正确',

        'email.require'                   => '请输入您的邮箱',
        'email'                           => '邮箱格式不正确',  

        'mobile.require'                  => '请输入手机号',
        'mobile.regex'                    => '手机号不正确',
    ];

    protected $scene = [

        'message'   =>  ['mobile','email','content','nickname']        
    ];    

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

    protected function checkHasValue($value,$rule)
    {      
        $id = input('id');
        
        switch ($rule) {
            case 'email'   :
                if (empty($id)) {
                    $hasValue = Db::name('Users')->where('email',$value)->find();
                    if (empty($hasValue)) {
                        return true;
                    } else {                        
                        return "邮箱已存在";
                    }
                } else {
                    //更改资料判断邮箱是否与其他人的邮箱相同
                    $checkValue = Db::name('Users')
                        ->where('id','neq',$id)
                        ->where('email',$value)
                        ->find();
                    if (empty($checkValue)) {
                        return true;
                    } else {
                        return "邮箱已存在";
                    }
                }
            break;
            case 'mobile'  :
                if (empty($id)) {
                    $hasValue = Db::name('Users')->where('mobile',$value)->find();
                    if (empty($hasValue)) {
                        return true;
                    } else {                        
                        return "手机号已存在！";                        
                    }
                } else {
                    //更改资料判断手机号是否与其他人的手机号相同
                    $checkValue = Db::name('Users')
                        ->where('id','neq',$id)
                        ->where('mobile',$value)
                        ->find();
                    if (empty($checkValue)) {
                        return true;
                    } else {
                        return "手机号已存在";
                    }
                }
            break;            
            case 'username': 
                if (empty($id)) {
                    $hasValue = Db::name('Users')->where('username',$value)->find();
                    if (empty($hasValue)) {
                        return true;
                    } else {
                        return '用户名已存在';
                    } 
                }else{
                    //更改资料判断用户名是否与其他人的用户名相同
                    $checkValue = Db::name('Users')
                        ->where('id','neq',$id)
                        ->where('username',$value)
                        ->find();
                    if (empty($checkValue)) {
                        return true;
                    } else {
                        return "用户名已存在";
                    }
                }    
            default:
                # code...
            break;
        }
    }
}