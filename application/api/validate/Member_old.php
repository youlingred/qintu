<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: tangtnglove <dai_hang_love@126.com> <http://www.ixiaoquan.com>
// +----------------------------------------------------------------------

namespace app\api\validate;

use think\Validate;
use think\Lang;
use think\Db;
use think\Input;

class Member extends Validate
{
    protected $rule =   [      
        
        'username'       => 'require|checkHasValue:username',
        // 'nickname'       => 'require|alphaNum',
        // 'email'          => 'email|checkHasValue:email', 
        'mobile'         => ['regex'=>'^(0|86|17951)?(13[0-9]|15[012356789]|18[0-9]|14[57])[0-9]{8}$'],
        'password'       => 'require',        
        // 'captcha'        => 'require|checkCaptcha:captcha',
        // 'newpassword'    => 'require',
        'repassword'     => 'require|confirm:password',
    ];

    protected $message  =   [

        'username.require '               => '用户名不能为空',
        'username.checkHasValue:username' => '用户名已存在',
        // 'username.alphaNum'               => '用户名必须是字母、数字', 

        // 'nickname.require '               => '昵称不能为空',        
        // 'nickname.alphaNum'               => '名称必须是字母、数字', 
       
        'mobile.regex'                    => '手机号不正确',
        
        // 'email'                           => '邮箱格式错误',
        
        'password.require'                => '请输入密码',
        
        // 'newpassword.require'             => '请输入新密码',
        'rempassword.require'              => '请输入确认密码', 
        'repassword.confirm'               => '两次输入的新密码不一致',
               
    ];

    protected $scene = [

        'edit'      =>  ['email','nickname','mobile'],
        'add'       =>  ['username','nickname','email','mobile','password','captcha'],
        
        'password'  =>  ['password','newpassword','confirmpassword'],
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
                        return "邮箱已存在！";
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
                        return '手机号已存在';
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
            case 'nickname':
                if (empty($id)) {
                    $hasValue = Db::name('Users')->where('nickname',$value)->find();
                    if (empty($hasValue)) {
                        return true;
                    } else {
                        return '昵称已存在';
                    }
                } else {
                    //更改资料判断昵称是否与其他人的昵称相同
                    $checkValue = Db::name('Users')
                        ->where('id','neq',$id)
                        ->where('nickname',$value)
                        ->find();
                    if (empty($checkValue)) {
                        return true;
                    } else {
                        return "昵称已存在";
                    }
                }
            break; 
            case 'username': 
                $hasValue = Db::name('Users')->where('username',$value)->find();
                if (empty($hasValue)) {
                    return true;
                } else {
                    return '用户名已存在';
                } 
            default:
                # code...
            break;
        }
    }
}