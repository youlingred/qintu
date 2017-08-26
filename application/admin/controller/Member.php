<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 完美°ぜ界丶 
// +----------------------------------------------------------------------
namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\Input;
use think\Loader;
use think\Request;

/**
 * 系统用户控制器
 * @author  完美°ぜ界丶 
 */
class Member extends Common
{        
  public function index()
  {  
      //搜索词
      $q = input('q');
      if (!empty($q)) {
        $map['username'] = ['like','%'.mb_convert_encoding($q, "UTF-8", "auto").'%'];
      }    
      //筛选用户状态
      $status   = input('status');
      if (!empty($status)) {
        $map['status'] = $status;
      }  
      //条件为空赋值
      if (empty($map)) {
        $map = 1;
      }
      //会员列表  
      $userList = Db::name('Users')
      ->where($map)
      ->order("id desc")
      ->distinct(true)
      ->paginate(10);
      $this->assign('userList',$userList);
      return $this->fetch('index');
  }

  /**
   * @author 完美°ぜ界丶
   * 添加会员
   */
  public function add()
    {
        if (Request::instance()->isPost()) {
            // 接收post数据
            $username          = input('post.username');// 用户名
            $nickname          = input('post.nickname');// 昵称
            $email             = input('post.email');// 邮箱
            $mobile            = input('post.mobile');//手机号
            $password          = input('post.password');//密码
            $repassword        = input('post.repassword');//密码
       
            // 实例化验证器
            $validate = Loader::validate('Member');                
            // 验证数据
            $data     = ['username'=>$username,'nickname'=>$nickname,'email'=>$email,'mobile'=>$mobile,'password'=>$password,'repassword'=>$repassword];
            // 验证
            if (!$validate->scene('addUser')->check($data)) {
                return $this->error($validate->getError());
             } 
            $value['username']      = $username;
            $value['nickname']      = $nickname;
            $value['uuid']          = create_uuid();
            $value['email']         = $email;
            $value['mobile']        = $mobile;
            $value['salt']          = create_salt();
            $value['password']      = minishop_md5($password,$value['salt']);
            $value['status']        = '1';
            
            //插入数据表
            $res = Db::name('Users')->insert($value);
            if($res) {
              return $this->success('添加成功',url('admin/member/index'));
            } else {
              return $this->error('添加失败');
            }
        } else {
            return $this->fetch('add');
        }
    }  

  /**
   ** @author 完美°ぜ界丶
   *  编辑会员
   */
    public function edit($id)
    {
       if (Request::instance()->isPost()) {
            $data          = input('post.');           
            // 实例化验证器
            $validate = Loader::validate('Member');                
            // 验证数据
            // 验证
            if (!$validate->scene('edit')->check($data)) {
                return $this->error($validate->getError());
             } 
            $getStatus     = Db::name('Users')->where('id',$data['id'])->update($data);
            if($getStatus !== false){
                return $this->success('编辑成功',url('admin/member/index'));
            } else {
                  return $this->error('编辑失败');
              }
      } else {
        // 查询单条数据
              if (empty($id)) {
              return $this->error('请选择有效数据');
          }   
          $map['id']     = $id;          
          $usersInfo      = Db::name('Users')->where($map)->find();              
          $this->assign('usersInfo',$usersInfo);
          return $this->fetch('edit');
      }
    }

  /**
   *设置会员状态
   * 1:正常
   * 2:禁用
   * -1:删除
   * @author 完美°ぜ界丶
   */
  public function setStatus()
  {
    $status    = input('post.status');
    $userids   = input('post.ids/a');
    if (!in_array($status,['1','2','-1'])) {
      return $this->error('请勾选需要操作的会员');
    }
  
    $userPost  = Db::name('Users')->where('id','in',implode(',',$userids))->update(['status'=>$status]);
    if ($userPost) {
        if($status=='-1')
        Db::name('Users')->where('id','in',implode(',',$userids))
        ->where('status',$status)
       ->delete();
      return $this->success('修改成功！');
    } else {
      return $this->error('修改失败！');
    }
  }

  /*编辑会员密码*/
  public function editPass($id) 
  {
    $id=$id;
    if (Request::instance()->isPost()) {
      $data     =  input('post.');
      
      //实例化验证器
      $validate =  Loader::validate('Member');
      //验证数据
      if (!$validate->scene('editPass')->check($data)) {
          return $this->error($validate->getError());
      } 

      $salt = Db::name('Users')->where('id',$id)->field('salt')->find();

      $password = minishop_md5($data['repassword'],$salt['salt']);
    
      $getStatus     = Db::name('Users')->where('id',$data['id'])->update(['password'=>$password]);
      
      if($getStatus !== false){
         return $this->success('编辑成功',url('admin/member/index'));
      } else {
         return $this->error('编辑失败');
      }
    } 
  }

}