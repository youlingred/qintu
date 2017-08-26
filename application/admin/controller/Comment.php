<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 天行健 <whjfordream@163.com> 
// +----------------------------------------------------------------------

namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\Loader;
use think\Request;

/**
 * 用户评论管理控制器
 * 实现查看、审核、删除功能
 * @author  天行健
 */

class Comment extends Common
{
	/**
     * 显示评论、订单号、部分评论内容等信息
     * 支持通过订单号搜索评论
     * 评分为1显示灰色，方便对此类评论的管理
     * @author 天行健
     */
	public function index() {
		 //搜索词
        $q = input('q');
        if (!empty($q)) {
            $map['order_id'] = ['like','%'.mb_convert_encoding($q, "UTF-8", "auto").'%'];
        }

        //筛选用户状态
        $status = input('approved');
        if (!empty($status)) {
            $map['approved'] = $status;
        }

        //条件为空赋值
        if (empty($map)) {
            $map = 1;
        }

        //评论列表
        $comment = Db::name('GoodsComment')
            ->where($map)
            ->order("id desc")    
            ->paginate(10);
                  
        $this->assign('comment',$comment);
  
        return $this->fetch('index');

    }

    /**
     * 审核或删除评论
     * Y:审核通过
     * N:审核驳回
     * -1:删除评论
     * @author 天行健
     */
    public function setStatus()
    {
        $status       = input('post.status');
        $commentids   = input('post.ids/a');
        if (!in_array($status,['1','0','-1','2'])) {
            return $this->error('请勾选需要操作的评论');
        }
        if($status == "0"){
            return $this->error('请勾选需要操作的评论');
        }
        if($status == "-1") {
            $result = Db::name('GoodsComment')->where('id','in',implode(',',$commentids))->delete();
            if($result) {
                return $this->success('删除成功！');

            } else {
                return $this->error('删除失败！');
            }      
        }

        if($status == "1") {
            $result = Db::name('GoodsComment')->where('id','in',implode(',',$commentids))->update(['approved' => '1']);
            if($result) {
                return $this->success('审核已通过！');
            } else {
                return $this->error('此评论已审核，请重试！');
            }      
        }

        if($status == "2") {
            $result = Db::name('GoodsComment')->where('id','in',implode(',',$commentids))->update(['approved' => '2']);
            if($result) {
                return $this->success('审核已驳回！');
            } else {
                return $this->error('此评论已驳回，请重试！');
            }      
        }

    }

    /**
    * 查看完整评论
    * 可在此界面完成审核、删除操作
    * 点击完成返回用户评论管理界面 
    * @author 天行健
    */
    public function detail(){
         //查看评论详情
        $map    = input('id');
        $commentInfo = Db::name('GoodsComment')->where('id',$map)->find();            
                  
        $this->assign('commentInfo',$commentInfo);
        return $this->fetch('detail');
    }
    /**
    * 可在此界面完成修改审核状态、删除评论操作
    * 点击完成返回用户评论管理界面 
    * @author 天行健
    */
    public function edit(){
        $id        = input('post.id');
        $approved  = input('post.approved');
        $visible   = input('post.visible');
        //0 -待审核，1 -已审核
        if (!in_array($approved,['1','0'])) {
            return $this->error('参数错误！');
        }
        //-1 -删除，1 -正常
        if (!in_array($visible,['1','-1'])) {
            return $this->error('参数错误！');
        }
        if($visible == "-1") {
            $result = Db::name('GoodsComment')->where('id',$id)->delete();
            if($result) {
                return $this->success('删除成功！',url('admin/comment/index'));

            } else {
                return $this->error('删除失败！请重试');
            }      
        }else if($visible == "1") {
                $result = Db::name('GoodsComment')->update(['id' => $id, 'approved' => $approved]);
                if($result == 1 ||$result == 0) {
                    return $this->success('修改成功！',url('admin/comment/index'));
                } else {
                    return $this->error('修改失败！请重试！');
                }         
            }
    }
}

	



		
		



