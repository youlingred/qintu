<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: tangtanglove <dai_hang_love@126.com> <http://www.ixiaoquan.com>
// +----------------------------------------------------------------------

namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\Loader;
use think\Request;

/**
 * 系统用户控制器
 * @author  完美°ぜ界丶
 */
class User extends Common
{
    /**
     * 修改个人资料
     * @author 完美°ぜ界丶
     */
    public function edit()
    {
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
                return $this->success('编辑成功',url('admin/user/edit'));
            } else {
                return $this->error('编辑失败');
            }
        } else {      
            $userInfo      = Db::name('Users')->where('id',UID)->find();              
            $this->assign('userInfo',$userInfo);
            return $this->fetch('edit');
        }
    }

    /**
     * 修改密码
     */
    public function password()
    {
       if (Request::instance()->isPost()) {
            //获取参数          
            $password               =   input('post.password');
            $userInfo = Db::name('Users')->where('id',UID)->find();
            if (minishop_md5($password,$userInfo['salt']) !== $userInfo['password']) {
                return $this->error('密码不正确');
            } 
            $repassword             =   input('post.repassword');
            $confirmpassword        =   input('post.confirmpassword');
            // 实例化验证器
            $validate = Loader::validate('User');
            // 验证数据
            $data = ['password'=>$password,'repassword'=>$repassword,'confirmpassword'=>$confirmpassword];
            // 验证
            if (!$validate->scene('password')->check($data)) {
                return $this->error($validate->getError());
            }            
            $repassword=minishop_md5($repassword,$userInfo['salt']);                  
            $res = Db::name('Users')->where('id',UID)->update(['password'=>$repassword]);  
            if ($res) {
                return $this->success('修改密码成功');
            } else {
                return $this->error('修改失败！');
            }
        } else {
            return $this->fetch('password');
        }

    }

    
}
