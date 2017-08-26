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
use think\Lang;
use think\Db;
use think\Input;

class Member extends Validate
{
    protected $rule =   [      
        'nickname'       => 'require|checkHasValue:nickname|alphaNum',
        'username'       => 'require|checkHasValue:username|alphaNum',
        'email'          => 'checkHasValue:email', 
        'mobile'         => 'checkHasValue:mobile',
        'password'       => 'require',
        'repassword'     => 'require|confirm:password',
        
    ];

    protected $message  =   [

        'nickname.require '               => '昵称不能为空',
        'nickname.checkHasValue:nickname' => '昵称已存在',
        'nickname.alphaNum'               => '名称必须是字母、数字', 

        'username.require '               => '用户名不能为空',
        'username.checkHasValue:username' => '用户名已存在',
        'username.alphaNum'               => '用户名必须是字母、数字', 

       
        'mobile.checkHasValue:mobile'     => '该手机号已存在',
        
        'email.checkHasValue:email'       => '邮箱已存在',
        
        'password.require'                => '请输入密码',
        'repassword.require'              => '请输入密码',
        'repassword.confirm'              => '请重新输入确认密码',
        
    ];

    protected $scene = [
        'edit'                 =>  ['email','nickname','mobile'],
        'add'                  =>  ['username','nickname','email','mobile','password','repassword'],
        
        'editPass'             =>  ['password','repassword'],
    ];

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