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
use think\Request;
use think\Db;

/**
 * 留言管理控制器
 * @author  矢志bu渝
 */
class Message extends Common
{
	/**
	 * 显示收益表
	 * @author  矢志bu渝
	 */
	public function index(){		

        $map['status'] = array('neq',-1);// 显示未被删除的留言
		$list = Db::name('message')->where($map)->order('createtime desc')->paginate(10);

		$this->assign('list',$list);

		return $this->fetch();
	}	

    /**
     * 答复留言
     * @author 矢志bu渝
     */
    public function reply($id){

        if (Request::instance()->isPost()) {
            $id = input('post.id');
            $data['response'] = input('post.response');
            $data['responsetime'] = time();
            $data['updatetime'] = $data['responsetime'];
            $data['status'] = 1;
            $map['id'] = $id;

            $result = Db::name('message')->where($map)->update($data);
            if ( $result ) {
                $this->success('答复成功！',url('index'));
            } else {
                $this->error('留言失败！');
            }

        } else {

            if(empty($id)){
                $this->error('留言不存在');
            }

            $map['id'] = $id;
            $info = Db::name('message')->where($map)->find();
            $this->assign('info',$info);

            return $this->fetch();
        }
        
    }

	/**
     * 批量删除  
     * @author 矢志bu渝
     */
    public function dele()
    {
        
        $listids = input('post.ids/a');
        
        if (empty($listids)) {
            return $this->error('参数错误！');
        }
        if(is_array($listids)){
        	$result = Db::name('message')->where('id','in',implode(',',$listids))->update(['status'=>-1,'updatetime'=>time()]);
        }else{
        	$result = Db::name('message')->where('id',$listids)->update(['status'=>-1,'updatetime'=>time()]);
        }
        
        if ($result) {        
            return $this->success('批量删除成功！');
        } else {
            return $this->error('批量删除失败！');
        }
    }

    /**
     * 删除该项     
     * @author 矢志bu渝
     */
    public function dele1($id)
    {        
        
        if (empty($id)) {
            return $this->error('参数错误！');
        }
        
        $result = Db::name('message')->where('id',$id)->update(['status'=>-1,'updatetime'=>time()]);
                
        if ($result) {        
            return $this->success('删除成功！');
        } else {
            return $this->error('删除失败！');
        }
    }
}