<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 矢志bu渝 <745152620@qq.com> <http://www.ixiaoquan.com>
// +----------------------------------------------------------------------

namespace app\wap\controller;

use think\Controller;
use think\Db;
use think\Loader;
use think\Request;
use common\library\Mini;

/**
 * 前台用户控制器
 * @author  矢志bu渝
 */
class User extends Common
{
    /**
     * 个人中心
     * @author  ILsunshine
     */
    public function userCenter(){
        $userInfo   = Db::name('Users')->where('id',UID)->find(); 
        $this->assign('userInfo',$userInfo);
        return $this->themeFetch('user_center');
    }
    
    /**
     * 修改密码
     * @author  
     */
    public function editPassword() {
        
        if (Request::instance()->isPost()) {
            //获取参数          
            $password               =   input('post.password');
            $newpassword            =   input('post.newpassword');
            $repassword             =   input('post.repassword');
            $userInfo = Db::name('Users')->where('id',UID)->find();            
            //验证密码            
            if (minishop_md5($password,$userInfo['salt']) != $userInfo['password']) {                
                return $this->error('密码不正确');
            } 
            if(minishop_md5($newpassword,$userInfo['salt']) == $userInfo['password']){
                return $this->error('新密码不能与原密码相同');            
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
                return $this->success('修改密码成功！');
            } else {
                return $this->error('修改失败！');
            }
        } else {
            return $this->themeFetch('edit_pass');
        }
    }
    /**
     * 修改手机号
     * @author  ILsunsine
     */
    public function editMobile() {
        
        if (Request::instance()->isPost()) {         
            $mobile    =   input('post.mobile'); 
            if(!preg_match("/^1[34578]{1}\d{9}$/",$mobile)){
                return $this->error('手机号格式不正确');
            }                       
            // 验证手机号是否存在
            $hasMobile = Db::name('Users')->where('mobile',$mobile)->find();
            if($hasMobile) {
                return $this->error('手机号已存在');
            }    
            $res = Db::name('Users')->where('id',UID)->update(['mobile'=>$mobile]);  
            if($res) {
                return $this->success('修改手机号成功！');
            } else {
                return $this->error('修改失败！');
            }
        } else {
            $userInfo = Db::name('Users')->where('id',UID)->find();
            $this->assign('userInfo',$userInfo);
            return $this->themeFetch('edit_mobile');
        }
    }
    /**
     * 修改邮箱
     * @author  ILsunsine
     */
    public function editEmail() {
        
        if (Request::instance()->isPost()) {
         
            $email    =   input('post.email'); 
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                return $this->error('邮箱格式不正确');
            }                       
            // 验证邮箱是否存在
            $hasEmail = Db::name('Users')->where('email',$email)->find();
            if($hasEmail) {
                return $this->error('邮箱已存在');
            }    
            $res = Db::name('Users')->where('id',UID)->update(['email'=>$email]);  
            if($res) {
                return $this->success('修改邮箱成功！');
            } else {
                return $this->error('修改失败！');
            }
        } else {
            $userInfo = Db::name('Users')->where('id',UID)->find();
            $this->assign('userInfo',$userInfo);
            return $this->themeFetch('edit_email');
        }
    }
    /**
     * 修改昵称
     * @author  ILsunsine
     */
    public function editNickname() {
        
        if (Request::instance()->isPost()) {
         
            $nickname    =   input('post.nickname');                        
            // 验证邮箱是否存在
            $hasEmail = Db::name('Users')->where('nickname',$nickname)->find();
             
            $res = Db::name('Users')->where('id',UID)->update(['nickname'=>$nickname]);  
            if($res) {
                return $this->success('修改昵称成功！');
            } else {
                return $this->error('修改失败！');
            }
        } else {
            $userInfo = Db::name('Users')->where('id',UID)->find();
            $this->assign('userInfo',$userInfo);
            return $this->themeFetch('edit_nickname');
        }
    }

    /**
     * 个人资料
     * @author  ILsunsine
     */
    public function userProfile() {       
        $userInfo = Db::name("Users")->where('id',UID)->find();
        $this->assign('userInfo',$userInfo);
        return $this->themeFetch('user_profile');
    }


    
}


