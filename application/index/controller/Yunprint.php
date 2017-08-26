<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 天行健 <764617706@qq.com> 
// +----------------------------------------------------------------------

namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Loader;
use think\Request;


/**
 * 云打印
 * @author  天行健
 */
class Yunprint extends Base
{
     
    public function action_print($header,$footer,$table,$total_num,$total_price){
    //测试专用
    //$table=json_encode($table);
    if (Request::instance()->isPost()) {
            //调用公共函数common    
            $state = actionprint($header,$footer,$table,$total_num,$total_price);
            //返回json格式
            echo $state;                                      
        }else{
            //非法提交，输出json格式字符串 '["state","error"]'
            $state = array("state","10"); 
            $state = json_encode($state);
            echo $state;
        }
    }
}

     //功能未确定，暂时保留
     // *
     // * 添加打印机功能
     // * @param  string $username      用户名（登录管理中心获取用户名）
     // * @param  string $printname     打印机终端名称（自定义）
     // * @param  string $mobilephone   终端手机号
     // * @param  string $machine_code  打印机终端号
     // * @param  string $msign         打印机终端密钥
     // * @author 天行健
     
    // public function add_print($username,$printname,$mobilephone,$add_machine_code,$add_msign){
    //     $machine_code = $add_machine_code;
    //     $msign = $add_msign;
    //     Config::set('machine_code',$machine_code);
    //     Config::set('msign',$msign);
    //     $res = addprint($username,$printname,$mobilephone,$machine_code,$msign);

    //     switch ($res){
    //     case 1:                            
    //     return  $this->success('添加成功');
    //     break;

    //     case 3:                     
    //     return  $this->success('添加失败，请重试');
    //     break;

    //     case 4:                            
    //     return  $this->success('添加失败，请重试');
    //     break;

    //     case 5:              
    //     return  $this->success('用户非法验证');
    //     break;

    //     case 6:                  
    //     return  $this->success('非法终端号');
    //     break;

    //     default:                    
    //     return  $this->success('重复添加');
    //     }
    // }

    //  /**
    //  * 删除打印机功能
    //  * @param  string $machine_code  打印机终端号
    //  * @param  string $msign         打印机终端密钥
    //  * @author 天行健
    //  */
    // public function delete_print($machine_code,$msign){
    //     $res = deleteprint();
    //     switch ($res){
    //     case 1:                        
    //     return  $this->success('删除成功');
    //     break;

    //     case 3:                           
    //     return  $this->success('删除失败');
    //     break;

    //     case 4:                           
    //     return  $this->success('认证失败');
    //     break;

    //     default:                         
    //     return  $this->success('没这个设备');
    //     }
    // }


