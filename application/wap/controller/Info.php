<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: vaey
// +----------------------------------------------------------------------

namespace app\wap\controller;

use think\Controller;
use think\Db;
use think\Request;

/**
 * 商品
 * @author  vaey 
 */
class Info extends Base
{

    //反馈信息
	public function feedback()
    {
        if (Request::instance()->isPost()){
            $user       = input('user');
            $mobile     = input('mobile');
            $email      = input('email');
            $content    = input('content');
            if(empty($user)){
                return $this->error('姓名不能为空');
            }
            if(empty($mobile)){
                return $this->error('手机号不能为空');
            }
            if(empty($email)){
                return $this->error('邮箱不能为空');
            }
            if(empty($content)){
                return $this->error('内容不能为空');
            }

            $data['nickname']         = $user;
            $data['email']            = $email;
            $data['mobile']           = $mobile;
            $data['content']          = $content;
            $data['createtime']       = time();

            $info = Db::name('Message')->insert($data);
            if($info){
                return $this->success('反馈成功');
            }else{
                return $this->error('反馈失败，稍后再试');
            }

        }else{
            return $this->themeFetch('info_feedback');
        }
        
    }

    //定制信息
    public function custom()
    {
        if (Request::instance()->isPost()){
            $user       = input('user');
            $title     = input('title');
            $mobile      = input('mobile');
            $content    = input('content');
            if(empty($user)){
                return $this->error('姓名不能为空');
            }
            if(empty($mobile)){
                return $this->error('手机号不能为空');
            }
            if(empty($title)){
                return $this->error('定制产品不能为空');
            }
            if(empty($content)){
                return $this->error('定制内容不能为空');
            }

            $data['username']         = $user;
            $data['title']            = $title;
            $data['phone']            = $mobile;
            $data['content']          = $content;
            $data['createtime']       = time();

            $info = Db::name('CustomService')->insert($data);
            if($info){
                return $this->success('提交定制信息成功');
            }else{
                return $this->error('提交定制信息失败，稍后再试');
            }

        }else{
            return $this->themeFetch('info_custom');
        }
        
    }

	
}
