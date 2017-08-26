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
use think\Request;
use think\Loader;

/**
 *插件管理
 * @author 完美°ぜ界丶
 */
class Banner extends Common
{
	public function index()
	{
		//搜索词
		$q = input('q');
		if (!empty($q)) {
			$map['name'] = ['like','%'.mb_convert_encoding($q,'utf-8','auto').'%'];
		}
		//筛选状态
		$status = input('status');
		if (!empty($status)) {
			$map['a.status'] = $status;
		}
		//条件为空赋值
		if (empty($map)) {
			$map = 1;
		}
		//广告管理
        $adList = Db::name('Banner')
        ->alias('a')
        ->join('banner_position b','b.id= a.position','LEFT')
        ->where($map)
        ->order("a.id desc")
        ->distinct(true)
        ->field('a.*,b.title')
        ->paginate(10);
        $this->assign('adList',$adList);        
      	return $this->fetch('index');
	}

    /**
     *添加广告
     * @author 完美°ぜ界丶
     */
    public function add() 
    {
    	//接收数据
    	if (Request::instance()->isPost()) {
    		$data['name']           = input('post.adname');
    		$data['description']    = input('post.description');
    		$data['link']           = input('post.link');
    		$data['position']       = input('post.pos');
    		$data['level']          = input('post.level');
    		$data['createtime']     = time();
    		//链接图片
    		$coverPath              = input('post.banner_path');

    		//实例化验证器
    		$validate = Loader::validate('Banner');

    		//验证
    		if (!$validate->scene('add')->check($data)) {
    			return $this->error($validate->getError());
    		}
    		

    		//添加封面图
    		if ($coverPath) {
    			$data['banner_path'] = $coverPath;
    		}
    		//插入数据表
    		$result = Db::name('Banner')->insert($data);
    		if ($result) {
    			return $this->success('添加成功',url('admin/banner/index'));
    		} else {
    				return $this->error('添加失败');
    		}
    	} else {
    		$pos=Db::name('BannerPosition')->where('status',1)->field('id,title')->select();
    	    $this->assign('pos',$pos);
    		return $this->fetch('add');

    	}
    }

	/**
	 * 编辑广告
     * @author 完美°ぜ界丶
	 */
	public function edit($id)
	{
		if (Request::instance()->isPost()) {
            $data['id']          = input('post.id');
			$data['name']        = input('post.name');
			$data['description'] = input('post.description');
			$data['position']    = input('post.position');
			$data['link']        = input('post.link');
			$data['level']       = input('post.level');
			$data['status']      = input('post.status');
			$coverPath           = input('post.banner_path'); 
			 // 实例化验证器
            $validate = Loader::validate('Banner');                
            // 验证数据            
            if (!$validate->scene('edit')->check($data)) {
                return $this->error($validate->getError());
            } 
            // 添加封面图
            if ($coverPath) {              
                $data['banner_path'] = $coverPath;              
            }
            $getStatus = Db::name('Banner')->where('id',$data['id'])->update($data);

            if($getStatus !== false){
                return $this->success('编辑成功！',url('admin/banner/index'));
            } else {
                return $this->error('编辑失败！');
            }
		} else {
			if (empty($id)) {
				return $this->error('请选择有效数据');
			}

			$map['a.id'] = $id;
			$adInfo    = Db::name('Banner')
			->alias('a')
            ->join('banner_position b','b.id= a.position','LEFT')
			->where($map)
			->field('a.id,a.name,a.description,a.position,b.title,a.link,a.banner_path,a.status,a.level,a.createtime')
			->find();
			$pos=Db::name('BannerPosition')->where('status',1)->field('id,title')->select();
    	    $this->assign('pos',$pos);
			$this->assign('adInfo',$adInfo);
			return $this->fetch('edit');
		}
	}

	/**
     * 设置状态
     * @author 完美°ぜ界丶
	 */
	public function setStatus()
	{
		$status = input('post.status');
		$posids = input('post.ids/a');
		if (!in_array($status,['1','2','-1'])) {
			return $this->error('请勾选需要操作的广告');
		}
		$posStatus = Db::name('Banner')->where('id','in',implode(',',$posids))->update(['status'=>$status]);
		if ($posStatus) {
			if($status=='-1') 
				Db::name('Banner')->where('id','in',implode(',',$posids))->where('status',$status)->delete();
				return $this->success('修改成功！');
			
		} else {
			return $this->error('修改失败!');
		}
	}

	
}