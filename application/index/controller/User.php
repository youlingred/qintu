<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro business ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 矢志bu渝 <745152620@qq.com> <http://www.ixiaoquan.com>
// +----------------------------------------------------------------------

namespace app\index\controller;

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
     * @author  矢志bu渝
     */
    public function editPassword() {
    	
    	if (Request::instance()->isPost()) {
            //获取参数          
            $password               =   input('post.password');
            $newpassword            =   input('post.newpassword');
            $repeatpassword         =   input('post.repassword');
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
            	'password'		 	=> $password,
            	'newpassword'		=> $newpassword,
            	'repeatpassword'	=> $repeatpassword,
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
            return $this->themeFetch('edit_mobile');
        }
    }

    /**
     * 修改个人资料
     * @author  ILsunsine
     */
    public function editProfile() {
        
        if (Request::instance()->isPost()){

            $nickname              =   input('post.nickname');
            $email                 =   input('post.email');                        
            // 实例化验证器
            $validate = Loader::validate('User');
            // 验证数据
            $data = [
                'nickname'          => $nickname,
                'email'             => $email,            
            ];
            // 验证
            if (!$validate->scene('edit')->check($data)) {
                return $this->error($validate->getError());
            }  
            $res = Db::name('Users')->where('id',UID)->update($data);  
            if($res){
                return $this->success('修改资料成功！');
            }else{
                return $this->error('修改失败！');
            }
        }else{
            $userInfo = Db::name("Users")->where('id',UID)->find();
            $this->assign('userInfo',$userInfo);
            return $this->themeFetch('edit_profile');
        }
    }

    /**
     * 更新个人资料
     * @author  矢志bu渝
     */
    public function edit() {

    	if (Request::instance()->isPost()) {
            $data          = input('post.');           
            // 实例化验证器
            $validate = Loader::validate('User');                
            // 验证数据
            if (!$validate->scene('edit')->check($data)) {
                return $this->error($validate->getError());
            }             
            $getStatus     = Db::name('Users')->where('id',UID)->update($data);
            if($getStatus !== false){
                return $this->success('更新成功');
            } else {
                return $this->error('更新失败');
            }
        } else {    
            $userInfo      = Db::name('Users')->where('id',UID)->find(); 
            $this->assign('userInfo',$userInfo);
            $mini = new \common\library\Mini();
            return $mini->themeFetch('user_profile');
        }
    }     
}
