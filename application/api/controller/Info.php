<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: vaey
// +----------------------------------------------------------------------

namespace app\api\controller;

use think\Db;
use think\Log;
use think\Request;
use think\controller\Rest;

/**
 * 商品
 * @author  vaey 
 */
class Info extends Base
{

    //反馈信息
	public function feedback_post_json()
    {
        
        $user       = input('post.user');
        $mobile     = input('post.mobile');
        $email      = input('post.email');
        $content    = input('post.content');
        if(empty($user)){
            return $this->restError('姓名不能为空');
        }
        if(empty($mobile)){
            return $this->restError('手机号不能为空');
        }
        if(empty($email)){
            return $this->restError('邮箱不能为空');
        }
        if(empty($content)){
            return $this->restError('内容不能为空');
        }

        $data['nickname']         = $user;
        $data['email']            = $email;
        $data['mobile']           = $mobile;
        $data['content']          = $content;
        $data['createtime']       = time();

        $info = Db::name('Message')->insert($data);
        if($info){
            return $this->restSuccess('反馈成功');
        }else{
            return $this->restError('反馈失败，稍后再试');
        }        
        
    }

    //定制信息
    public function custom_post_json()
    {
        
        $user       = input('post.user');
        $title      = input('post.title');
        $mobile     = input('post.mobile');
        $content    = input('post.content');
        if(empty($user)){
            return $this->restError('姓名不能为空');
        }
        if(empty($mobile)){
            return $this->restError('手机号不能为空');
        }
        if(empty($title)){
            return $this->restError('定制产品不能为空');
        }
        if(empty($content)){
            return $this->restError('定制内容不能为空');
        }

        $data['username']         = $user;
        $data['title']            = $title;
        $data['phone']            = $mobile;
        $data['content']          = $content;
        $data['createtime']       = time();

        $info = Db::name('CustomService')->insert($data);
        if($info){
            return $this->restSuccess('提交定制信息成功');
        }else{
            return $this->restError('提交定制信息失败，稍后再试');
        }        
        
    }

	
}
