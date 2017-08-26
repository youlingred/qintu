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
use think\Input;

class Member extends Validate
{
    protected $rule =   [      
        'nickname'       => 'require',
        'username'       => 'require',
        'username'       => 'checkHasValue:username',
        'email'          => 'require|email|checkHasValue:email',            
        'mobile'         => ['regex'=>'/^13[0-9]{1}[0-9]{8}$|15[0-9]{1}[0-9]{8}$|18[0-9]{1}[0-9]{8}$|17[0-9]{9}$/'],
        'mobile'         => 'checkHasValue:mobile',
        'password'       => 'require',        
       
        'newpassword'    => 'require',
        'repassword'     => 'require|confirm:password',
        'repeatpassword' => 'require|confirm:newpassword',
    ];

    protected $message  =   [
        'nickname.require'               => '用户昵称不能为空',
        'username.require'               => '用户名不能为空',        
        'username.alphaNum'               => '名称必须是字母、数字',  
        'username.checkHasValue:username' => '用户名已存在',
        'mobile.require'                  => '输入手机号', 

        'email.require'                   => '邮箱不能为空',
        'email'                           => '邮箱格式不正确',
        'email.checkHasValue:email'       => '邮箱已存在',

        'mobile.regex'                    => '手机号不正确',
        'mobile.checkHasValue:mobile'     => '手机号已存在',

        'password.require'                => '请输入密码', 
        'newpassword.require'             => '请输入新密码',
        'repassword.require'              => '请输入确认密码', 
        'repassword.confirm'              => '两次输入的密码不一致',

        'repeatpassword.require'          => '请输入确认密码', 
        'repeatpassword.confirm'          => '两次输入的密码不一致',
               
    ];

    protected $scene = [

        'edit'      =>  ['email','nickname','mobile'],
        'add'       =>  ['username','nickname','email','mobile','password','captcha'],
        'register'  =>  ['username','mobile','password','repassword','nickname'],
        'password'  =>  ['password','newpassword','repeatpassword'],
        'editpass'  =>  ['password','repassword'],
        'getpass'   =>  ['password','repassword',],
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