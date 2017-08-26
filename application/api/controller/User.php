<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 矢志bu渝 <745152620@qq.com> <http://www.ixiaoquan.com>
// +----------------------------------------------------------------------

namespace app\api\controller;
 
use think\Db;
use think\Loader;
use think\Request;
use think\controller\Rest;

/**
 * 前台用户控制器
 * @author  矢志bu渝
 */
class User extends Common
{

    /**
     * 个人中心
     * @author  矢志bu渝
     */
    public function userCenter_get_json()
    {
        // $uid = input('uid');
        $userInfo   = Db::name('Users')->where('id',UID)->find();
        if(!empty($userInfo)) {
            return $this->restSuccess('获取成功！',$userInfo);
        } else {
            return $this->restError('没有数据了！');
        }
    }
    
    /**
     * 修改密码
     * @author  
     */
    public function editPassword_post_json()
    {
        //获取参数          
        $password               =   input('post.password');
        $newpassword            =   input('post.newpassword');
        $repassword             =   input('post.repassword');
        $userInfo = Db::name('Users')->where('id',UID)->find();            
        //验证密码            
        if (minishop_md5($password,$userInfo['salt']) != $userInfo['password']) {                
            return $this->restError('密码不正确');
        } 
        if(minishop_md5($newpassword,$userInfo['salt']) == $userInfo['password']){
            return $this->restError('新密码不能与原密码相同');            
        }            
        // 实例化验证器
        $validate = Loader::validate('User');
        // 验证数据
        $data = [
            'password'          => $password,
            'newpassword'       => $newpassword,
            'repassword'        => $repassword,
        ];
        // 验证
        if (!$validate->scene('password')->check($data)) {
            return $this->error($validate->getError());
        }            
        $newpassword=minishop_md5($newpassword,$userInfo['salt']);                  
        $res = Db::name('Users')->where('id',UID)->update(['password'=>$newpassword]);  
        if ($res) {
            return $this->restSuccess('修改密码成功！');
        } else {
            return $this->restError('修改失败！');
        }
    }
    /**
     * 修改手机号
     * @author  ILsunsine
     */
    public function editMobile_post_json()
    {   
        $mobile    =   input('post.mobile');                        
        // 验证手机号是否存在
        $hasMobile = Db::name('Users')->where('mobile',$mobile)->find();
        if($hasMobile) {
            return $this->restError('手机号已存在');
        }    
        $res = Db::name('Users')->where('id',UID)->update(['mobile'=>$mobile]);  
        if($res) {
            return $this->restSuccess('修改手机号成功！');
        } else {
            return $this->restError('修改失败！');
        }
    }
    /**
     * 修改邮箱
     * @author  ILsunsine
     */
    public function editEmail_post_json()
    {
        $email    =   input('post.email');                        
        // 验证邮箱是否存在
        $hasEmail = Db::name('Users')->where('email',$email)->find();
        if($hasEmail) {
            return $this->restError('邮箱已存在');
        }    
        $res = Db::name('Users')->where('id',UID)->update(['email'=>$email]);  
        if($res) {
            return $this->restSuccess('修改邮箱成功！');
        } else {
            return $this->restError('修改失败！');
        }
    }
    /**
     * 修改昵称
     * @author  ILsunsine
     */
    public function editNickname_post_json()
    {
        $nickname    =   input('post.nickname');
        $res = Db::name('Users')->where('id',UID)->update(['nickname'=>$nickname]);  
        if($res) {
            return $this->restSuccess('修改昵称成功！');
        } else {
            return $this->restError('修改失败！');
        }
    }

    /**
     * 退出处理
     */
    public function logout_post_json()
    {
    	$token = input('token');
    	if(cache('api_token_'.$token,null)) {
            return $this->restSuccess('退出成功！');
        } else {
            return $this->restError('退出失败，请重试！');
        }
    }
}
