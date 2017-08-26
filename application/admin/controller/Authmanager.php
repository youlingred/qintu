<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: vaey 
// +----------------------------------------------------------------------

namespace app\admin\controller;
use think\Db;
use think\Request;
use think\Loader;

/**
 * 权限管理控制器
 * @author vaey 
 */
class Authmanager extends Common
{

	/**
	 * 授权首页
	 * @return [type] [description]
	 */
    public function index()
    {
        $userGroup = Db::name('UserGroup')->order('id desc')->select();
        $this->assign('userGroup',$userGroup);
        return $this->fetch();
    }

    /**
     * 添加用户组
     */
    public function add()
    {
        //判断请求类型
        if(request()->isPost()){
            $group_name     = input('post.group_name');
            $description    = input('post.description');

            // 实例化验证器
            $validate = Loader::validate('Auths');                
            // 验证数据
            $data     = ['group_name'=>$group_name];
            // 验证
            if (!$validate->check($data)) {
                return $this->error($validate->getError());
            }
            $value['title']     = $group_name;
            $value['description']    = $description; 
            //插入数据表
            $res = Db::name('UserGroup')->insert($value);
            if($res) {
              return $this->success('添加成功',url('admin/authmanager/index'));
            } else {
              return $this->error('添加失败');
            }

        }else{
            return $this->fetch();
        }
    }

    /**
     * 用户组设置
     */
    public function setStatus()
    {
        $status     = input('post.status');
        $ids        = input('post.ids/a');
        if(empty($ids)){
            return $this->error('请选择用户组');
        }
        switch ($status) {
            case 'start':
                $info = Db::name('UserGroup')->where('id','in',$ids)->setField('status',1);
                if($info){
                    return $this->success('设置成功');
                }else{
                    return $this->error('设置失败');
                }
                break;
            case 'forbid':
                //设置禁用
                $flg = Db::name('UserGroup')->where('id','in',$ids)->setField('status',-1);
                if($flg){
                    return $this->success('设置成功');
                }else{
                    return $this->error('设置失败');
                }
                break;
            case 'delete':
                Db::startTrans();
                $flg = true;
                try{
                    Db::name('UserGroup')->where('id','in',$ids)->delete();
                    Db::name('UserGroupAccess')->where('group_id','in',$ids)->delete();
                    Db::name('UserExtend')->where('group_id','in',$ids)->delete();
                    // 提交事务
                    Db::commit();    
                } catch (\PDOException $e) {
                    // 回滚事务
                    $flg = false;
                    Db::rollback();
                }
                if($flg){
                    return $this->success('删除成功');
                }else{
                    return $this->error('删除失败');
                }
                break;
            default:
                # code...
                break;
        }
    }
    /**
     * 编辑用户组
     * @return [type] [description]
     */
    public function edit()
    {
        //判断请求类型
        if(request()->isPost()){
            $group_name     = input('post.group_name');
            $description    = input('post.description');
            $gid            = input('post.gid');
            if(!$group_name){
                return $this->error('用户组必填');
            }
            $hasValue = Db::name('UserGroup')->where('title',$group_name)->where('id','neq',$gid)->find();
            if($hasValue){
                return $this->error('用户组名称不能重复');
            }
            $value['title']         = $group_name;
            $value['description']   = $description; 
            $value['id']            = $gid;
            //插入数据表
            $res = Db::name('UserGroup')->update($value);
            if($res) {
              return $this->success('修改成功',url('admin/authmanager/index'));
            } else {
              return $this->error('修改失败');
            }

        }else{
            //获取用户组id
            $gid = input('id');
            //查询当前用户组信息
            $group  = Db::name('UserGroup')->where('id',$gid)->find();
            $this->assign('group',$group);
            return $this->fetch();
        }
    } 



    /**
     * 访问授权
     * @return [type] [description]
     */
    public function access()
    {
        //获取用户组id
        $gid = input('id'); 
        // Menu列表数据
        $menuList = Db::name('Menu')->select();
        //获取已有权限
        $rules   = Db::name('UserGroup')->where('id',$gid)->value('rules');
        //查询当前用户组的名称
        $group  = Db::name('UserGroup')->where('id',$gid)->value('title');
        // Select列表数据转换成树
        $menuListTree = list_to_tree($menuList);
        // dump($menuListTree);
        // die();
        // 输出赋值
        $this->assign('rules',$rules);
        $this->assign('gid',$gid);
        $this->assign('group',$group);
        $this->assign('menuListTree',$menuListTree);
        return $this->fetch();
    }
    /**
     * 设置访问授权
     */
    public function setAccess()
    {
        //用户组id
        $gid = input('post.gid');
        //权限id数组
        $ids = input('post.ids/a');
        //转换数组为字符串
        if(is_array($ids)){ 
            $ids = implode(',',$ids);
        }
        $info = Db::name('UserGroup')->where('id',$gid)->setField('rules',$ids);
        if($info){
            return $this->success('设置成功！',url('admin/authmanager/index'));
        }else{
            return $this->error('设置失败');
        }
    }

    /**
     * 分类授权
     * @return [type] [description]
     */
    public function category()
    {
        //获取用户组id
        $gid = input('id');
        //获取已有权限
        $rules   = Db::name('UserExtend')->where('group_id',$gid)->value('extend_id'); 
        //查询当前用户组的名称
        $group  = Db::name('UserGroup')->where('id',$gid)->value('title');
    	// 列表数据
        $termTaxonomyList = Db::name('TermTaxonomy')
        ->alias('a')
        ->join('terms b','b.id= a.term_id','LEFT')
        ->field('a.*,b.name,b.slug')
        ->select();
        // 列表数据转换成树
        $termTaxonomyTree = list_to_tree($termTaxonomyList);
        // 输出赋值
        if($rules){
            $this->assign('rules',$rules);
        }else{
            $this->assign('rules','');
        }
        $this->assign('gid',$gid);
        $this->assign('group',$group);
        $this->assign('termTaxonomyTree',$termTaxonomyTree);
        return $this->fetch();
    }
    /**
     * 设置分类授权
     * @return [type] [description]
     */
    public function setCategory()
    {
         //用户组id
        $gid = input('post.gid');
        //权限id数组
        $ids = input('post.ids/a');
        //转换数组为字符串
        if(is_array($ids)){ 
            $ids = implode(',',$ids);
        }
        if(!$ids){
            return $this->error('请选择要设置的权限');
        }
        //查询是否已存在该用户组的扩展权限
        $info = Db::name('UserExtend')->where('group_id',$gid)->find();
        if($info){ //已存在此用户组
            $flg = Db::name('UserExtend')->where('group_id',$gid)->setField('extend_id',$ids);
            if($flg){
                return $this->success('设置成功！',url('admin/authmanager/index'));
            }else{
                return $this->error('设置失败');
            }
        }else{     //不存在此用户组
            $data['extend_id']  = $ids;
            $data['group_id']   = $gid;
            $flg = Db::name('UserExtend')->insert($data);
            if($flg){
                return $this->success('设置成功！',url('admin/authmanager/index'));
            }else{
                return $this->error('设置失败');
            }
        }
        
    }

    /**
     * 用户组下的会员列表
     * @return [type] [description]
     */
    public function member()
    {
            $gid    = input('id');
            //查询当前用户组的名称
            $group  = Db::name('UserGroup')->where('id',$gid)->value('title');
            //查询当前用户组有哪些用户
            $user   = Db::name('UserGroupAccess')->where('group_id',$gid)->select();

            $this->assign('user',$user);
            $this->assign('group',$group);
            $this->assign('gid',$gid);
            return $this->fetch();
    }
    /**
     * 用户组下添加用户
     */
    public function addUser()
    {
        //判断请求类型
        if(request()->isPost()){
            //获取用户id,组id
            $uid    = input('uid');
            $gid    = input('gid');
            $hasUid = Db::name('Users')->where('id',$uid)->find();
            if($hasUid){
                $data['uid']        = $uid;
                $data['group_id']   = $gid;
                if(Db::name('UserGroupAccess')->insert($data)){
                    return $this->success('设置成功',url('admin/Authmanager/member',['id'=>$gid]));
                }else{
                    return $this->error('设置失败');
                }
            }else{
                return $this->error('无此用户');
            }

        }else{
            $gid    = input('gid');
            //查询当前用户组的名称
            $group  = Db::name('UserGroup')->where('id',$gid)->value('title');
            $this->assign('group',$group);
            $this->assign('gid',$gid);
            return $this->fetch();
        }
    }

    public function delUser()
    {
        //用户组id
        $gid = input('post.gid');
        //状态
        $status = input('post.status');
        //用户id(可多个)
        $ids = input('post.ids/a');
        //转换数组为字符串
        if(is_array($ids)){ 
            $ids = implode(',',$ids);
        }
        if($status==1){
            $info = Db::name('UserGroupAccess')->where('uid','in',$ids)->where('group_id',$gid)->delete();
            if($info){
                return $this->success('删除成功');
            }else{
                return $this->error('删除失败');
            }
        }else{
            return $this->error('请选择要删除的用户');
        }
        

    } 

}
