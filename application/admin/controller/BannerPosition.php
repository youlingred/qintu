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

/**
 *广告位置管理
 * @author 完美°ぜ界丶
 */
class BannerPosition extends Common
{
	public function index()
	{
		
		 //搜索词
        $q = input('q');
        if (!empty($q)) {
        $map['title'] = ['like','%'.mb_convert_encoding($q, "UTF-8", "auto").'%'];
        }   
		//筛选状态
		$status = input('status');
		if (!empty($status)) {
			$map['status'] = $status;
		}
		//条件为空赋值
		if (empty($map)) {
			$map = 1;
		}
		//广告管理
        $posList = Db::name('BannerPosition')
        ->where($map)
        ->order("id desc")
        ->distinct(true)
        ->paginate(10);
        $this->assign('posList',$posList);
      	return $this->fetch('index');
	}

    /**
     *添加广告位置
     * @author 完美°ぜ界丶
     */
    public function add() 
    {
    	//接收数据
    	if (Request::instance()->isPost()) {
    		$data['title']  = input('post.title');
    		$data['width']  = input('post.width');
    		$data['height'] = input('post.height');
    		if ($data['title']=='') {
    			return $this->error('广告位名称不能为空！');
    		}
    		//添加数据
    		$getStatus = Db::name('BannerPosition')->insert($data);
    		if ($getStatus!==false) {
    			return $this->success('添加成功',url('index'));
    		} else {
    			return $this->error('添加失败！');
    		}
    	} else {
    		return $this->fetch('add');

    	}
    }

	/**
	 * 编辑广告位置
     * @author 完美°ぜ界丶
	 */
	public function edit($id)
	{
		if (Request::instance()->isPost()) {
			$data = input('post.');
			$getStatus = Db::name('BannerPosition')->where('id',$data['id'])->update($data);
			if ($getStatus!==false) {
				return $this->success('编辑成功',url('index'));
			} else {
				return $this->error('编辑失败');
			}


		} else {
			if (empty($id)) {

				return $this->error('请选择有效数据');
			}
			$map['id'] = $id;
			$posInfo    = Db::name('BannerPosition')->where($map)->find();

			$this->assign('posInfo',$posInfo);
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
		$posStatus = Db::name('BannerPosition')->where('id','in',implode(',',$posids))->update(['status'=>$status]);
		if ($posStatus) {
			if($status=='-1') 
				Db::name('BannerPosition')->where('id','in',implode(',',$posids))->where('status',$status)->delete();
				return $this->success('修改成功！');
			
		} else {
			return $this->success('修改失败!');
		}
	}

}