<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: vaey
// +----------------------------------------------------------------------

namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\Loader;
use think\Request;

/**
 *微信管理
 *@author vaey
 */
class Wx extends Common
{
	/**
	 * 微信设置首页
	 * @author vaey
	 */
	public function index()
	{
		return $this->fetch();
	}



	/**
	 * 微信菜单设置页
	 * @author vaey
	 * @return [type] [description]
	 */
	public function wxmenu()
	{

			$data = Db::name('WxMenu')->select();
			$tree = list_to_tree($data,'id','parent');
			$this->assign('tree',$tree);
			return $this->fetch();
		
	}

	/**
	 * 添加菜单
	 * @author vaey
	 */
	public function add()
	{
		if(Request::instance()->isPost()){
			$data['name'] 	= input('post.name');
			$data['type'] 	= input('post.type');
			$data['url'] 	= input('post.url');
			$data['msg']	= input('post.msg');
			$data['parent'] = input('post.parent');
			$data['key'] 	= 'K_'.time();
			if(empty($data['name'])){
				return $this->error('菜单名称不能为空');
			}
			if($data['type']==1){  //跳转链接
				if(empty($data['url'])){
					return $this->error('跳转链接不能为空');
				}
			}else{  //回复消息
				if(empty($data['msg'])){
					return $this->error('回复消息不能为空');
				}
			}
			//判断顶级菜单是否超过三个
			if($data['parent']==0){
				$parent = Db::name('WxMenu')->where('parent',0)->count();
				if($parent>2){
					return $this->error('顶级菜单最多能添加三个');
				}
			}else{//判断子菜单是否超过五个
				$children = Db::name('WxMenu')->where('parent',$data['parent'])->count();
				if($children>4){
					return $this->error('子菜单最多能添加五个');
				}
			}
			//插入数据
			if(Db::name('WxMenu')->insert($data)){
				return $this->success('菜单添加成功');
			}else{
				return $this->error('菜单添加失败');
			}
		}else{
			$data = Db::name('WxMenu')->where('parent',0)->select();
			$this->assign('data',$data);
			return $this->fetch();
		}
	}
	
	/**
	 * 菜单修改
	 * @author vaey
	 */
	public function edit()
	{
		if(Request::instance()->isPost()){
			$pid 			= input('post.pid');
			$id 			= input('post.id');
			$data['name'] 	= input('post.name');
			$data['type'] 	= input('post.type');
			$data['url'] 	= input('post.url');
			$data['msg']	= input('post.msg');
			$data['parent'] = input('post.parent');

			if(empty($data['name'])){
				return $this->error('菜单名称不能为空');
			}
			if($data['type']==1){  //跳转链接
				if(empty($data['url'])){
					return $this->error('跳转链接不能为空');
				}
			}else{  //回复消息
				if(empty($data['msg'])){
					return $this->error('回复消息不能为空');
				}
			}

			if($pid==0){
				if($data['parent']!=0){
					return $this->error('顶级菜单不允许移动');
				}
			}
			//判断菜单是否移动
			if($pid!=$data['parent']){
				if($data['parent']==0){ //判断顶级菜单是否超过三个
					$parent = Db::name('WxMenu')->where('parent',0)->count();
					if($parent>2){
						return $this->error('顶级菜单已有三个，不允许再添加');
					}
				}else{ //判断子菜单是否超过五个
					$children = Db::name('WxMenu')->where('parent',$data['parent'])->count();
					if($children>4){
						return $this->error('该菜单下已五个子菜单，不允许再添加');
					}
				}
			}
			//插入数据
			if(Db::name('WxMenu')->where('id',$id)->update($data)){
				return $this->success('菜单修改成功');
			}else{
				return $this->error('菜单没有任何修改');
			}
		}else{
			$id = input('get.id');
			$data = Db::name('WxMenu')->where('parent',0)->select();
			$info = Db::name('WxMenu')->where('id',$id)->find();
			$this->assign('data',$data);
			$this->assign('info',$info);
			return $this->fetch();
		}
		
	}

	/**
	 * 菜单删除
	 * @return [type] [description]
	 */
	public function del(){
		$id 			= input('post.id');
		$pid 			= input('post.pid');
		$info = "";
		if(!empty($id)){
			$info = Db::name('WxMenu')->where('id',$id)->delete();
			if($pid==0 && $info){
				Db::name('WxMenu')->where('parent',$id)->delete();
			}
		}
		if($info){
			return $this->success('菜单删除成功');
		}else{
			return $this->success('菜单删除失败');
		}
	}



	/**
	 * 关注回复和自动回复
	 * @param  [type] $type [1关注回复，2消息回复]
	 * @return [type]       [description]
	 */
	public function reply($type)
	{
		if(Request::instance()->isPost()){
			//获取关注回复的内容
			$data['msg']  = input('post.msg');
			$data['type'] = input('post.type');
			//查询是否已有数据
			$has = Db::name('WxReply')->where('type',$data['type'])->find();
			if($has){ //修改
				$info = Db::name('WxReply')->where('type',$data['type'])->update($data);
			}else{    //插入
				$info = Db::name('WxReply')->insert($data);
			}
			if($info){
				return $this->success('设置成功');
			}else{
				return $this->error('设置失败，请稍后');
			}
		}else{
			$data = Db::name('WxReply')->where('type',$type)->find();
			$this->assign('data',$data);
			if($type==1){
				$this->assign('title','用户第一次添加公众号时回复的消息');
				$this->assign('small','为空则无回复');
			}else{
				$this->assign('title','用户发送消息时回复');
				$this->assign('small','为空则无回复');
			}
			return $this->fetch();
		}
		
	}


	/**
	 * 关键词回复
	 */
	public function keywords()
	{
		if(Request::instance()->isPost()){
			//获取关注回复的内容
			$data['msg']  = input('post.msg');
			$data['key']  = input('post.key');
			$data['type'] = 3;
			if(empty($data['key'])){
				return $this->success('关键词不能为空');
			}
			if(empty($data['msg'])){
				return $this->success('回复内容不能为空');
			}
			$has = Db::name('WxReply')->where('key',$data['key'])->find();
			if($has){
				return $this->success('关键词不能重复');
			}
			$info = Db::name('WxReply')->insert($data);
			if($info){
				return $this->success('设置成功');
			}else{
				return $this->error('设置失败，请稍后');
			}
		}else{
			$data = Db::name('WxReply')->where('type',3)->order('id desc')->paginate(10);
			$this->assign('data',$data);
			return $this->fetch();
		}
		
	}

	/**
	 * 删除关键词回复
	 * @return [type] [description]
	 */
	public function delKeywords(){
		$id = input('post.id');
		$info = "";
		if(!empty($id)){
			$info = Db::name('WxReply')->where('id',$id)->delete();
		}
		if($info){
			return $this->success('删除成功');
		}else{
			return $this->error('删除失败');
		}
	}


}

?>