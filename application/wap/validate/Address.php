<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 矢志不渝 <745152620@qq.com> <http://www.ixiaoquan.com>
// +----------------------------------------------------------------------

namespace app\wap\validate;

use think\Validate;
use think\Lang;
use think\Db;
use think\Input;

class Address extends Validate
{
    protected $rule =   [              
            
        'consignee_name' => 'require',
        'mobile'         => 'require',
        'mobile'         =>  ['regex'=>'/^13[0-9]{1}[0-9]{8}$|15[0-9]{1}[0-9]{8}$|18[0-9]{1}[0-9]{8}$|17[0-9]{9}$/'],
        'address'        => 'require',
        'province'       => 'require',
        'city'           => 'require',
        'county'         => 'require',
    ];

    protected $message  =   [
 
        'mobile.require'                  => '输入手机号不能为空',     
        'mobile.regex'                    => '输入手机号格式不正确',
        'address.require'                 => '输入地址不能为空',      
        'consignee_name.require'          => '收货人不能为空',
        'province.require'                => '输入省份不能为空',
        'city.require'                    => '输入城市不能为空',      
        'county.require'                  => '输入县区不能为空',
    ];

    protected $scene = [       
        'address'  =>  ['address','consignee_name','mobile','province','city','county',],
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

    
}