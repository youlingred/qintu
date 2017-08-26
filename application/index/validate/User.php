<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 矢志不渝 <745152620@qq.com> <http://www.ixiaoquan.com>
// +----------------------------------------------------------------------

namespace app\index\validate;

use think\Validate;
use think\Lang;
use think\Db;
use think\Input;

class User extends Validate
{
    protected $rule =   [      
        
        
        'nickname'       => 'require',
        'email'          => 'require',            
        'email'          => 'checkHasValue:email',
        'mobile'         => ['regex'=>'/^13[0-9]{1}[0-9]{8}$|15[0-9]{1}[0-9]{8}$|18[0-9]{1}[0-9]{8}$|17[0-9]{9}$/'],
        'post_mobile'    => ['regex'=>'/^13[0-9]{1}[0-9]{8}$|15[0-9]{1}[0-9]{8}$|18[0-9]{1}[0-9]{8}$|17[0-9]{9}$/'],
        'mobile'         => 'checkHasValue:mobile',
        'mobile'         => 'require',
        'post_mobile'    => 'require',
        'password'       => 'require',        
        'newpassword'    => 'require',        
        'repeatpassword' => 'require|confirm:newpassword',
        'address'        => 'require',
        'address_detail' => 'require',
        'post_num'       => 'require',
        'post_man'       => 'require',
        'goods_id'       => 'require',
        'content'        => 'require',
        'order_id'       => 'require',
        'score'          => 'require',
    ];

    protected $message  =   [

        'nickname.require'                => '昵称不能为空',        
        'nickname.alphaNum'               => '名称必须是字母、数字',  
        'mobile.require'                  => '输入手机号不能为空', 
        'post_mobile.require'             => '输入手机号不能为空',
        'email.require'                   => '邮箱不能为空',
        'email.checkHasValue:email'       => '邮箱已存在',
        'post_mobile.regex'               => '手机号格式不正确',
        'mobile.regex'                    => '手机号格式不正确',
        'mobile.checkHasValue:mobile'     => '手机号已存在',

        'password.require'                => '请输入密码', 
        'newpassword.require'             => '请输入新密码',       

        'repeatpassword.require'          => '请输入确认密码', 
        'repeatpassword.confirm'          => '两次输入的密码不一致',
        'address.require'                 => '输入地址不能为空',      
        'address_detail.require'          => '详细地址不能为空',
        'post_man.require'                => '收货人不能为空',
        'goods_id.require'                => '商品id不能为空',
        'content.require'                 => '评论内容不能为空',
        'order_id.require'                => '订单号不能为空',
        'score.require'                   => '评分不能为空',
    ];

    protected $scene = [

        'edit'      =>  ['email','nickname'],
        'password'  =>  ['password','newpassword','repeatpassword'],        
        'edit_address'  =>  ['address','address_detail','post_mobile','post_man'],
        'comment'   =>  ['goods_id','content','order_id'],
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
        switch ($rule) {
            case 'email'   :
                if (empty($id)) {
                    $hasValue = Db::name('Users')->where('email',$value)->find();
                    if (empty($hasValue)) {

                        return true;
                    } else {     
                        if($hasValue['id']==UID){
                            return true;
                        }else{
                            return "邮箱已存在";   
                        }                   
                       
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
                        if($hasValue['id']==UID){
                            return true;
                        }else{
                            return "手机号已存在";   
                        }                              
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
            default:
                # code...
            break;
        }
    }
}