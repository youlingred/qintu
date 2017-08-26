<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 矢志bu渝 <745152620@qq.com> <http://www.ixiaoquan.com>
// +----------------------------------------------------------------------

namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\Loader;
use think\Request;

/**
 * 链接管理控制器
 * @author  矢志bu渝
 */
class Links extends Common
{
    /**
     * 链接管理首页，链接列表
     * @author 矢志bu渝
     */
    public function index() {

        //搜索词
        $q = input('q');
        if (!empty($q)) {
            $map['name'] = ['like','%'.mb_convert_encoding($q, "UTF-8", "auto").'%'];
        }   

        //筛选用户状态
        $status   = input('visible');
        if (!empty($status)) {
            $map['visible'] = $status;
        }  

        //条件为空赋值
        if (empty($map)) {
            $map = 1;
        }

        //链接列表
        $linkList = Db::name('Links')
            ->where($map)
            ->order("id desc")    
            ->paginate(10);
                    
        $this->assign('linkList',$linkList);

        return $this->fetch('index');

    }


    /**
     * @author 矢志bu渝
     * 添加链接
     */
    public function add ()
    {

        if (Request::instance()->isPost()) {

            // 接收post数据
            $data['name']           = input('post.link_name');  // 链接标题
            $data['url']            = input('post.link_url');   // 链接URL            
            $data['target']         = input('post.target');     // 链接打开方式
            $data['description']    = input('post.description');// 链接描述
            $data['visible']        = input('post.visible');    // 是否可见（Y/N）
            $data['owner']          = UID;                      // 添加者用户ID
            $data['createtime']     = time();                   // 添加时间
            $coverPath              = input('post.cover_path'); // 链接图片

            // 实例化验证器
            $validate = Loader::validate('Links');                

            // 验证
            if (!$validate->scene('add')->check($data)) {
                return $this->error($validate->getError());
            } 
                       
            // 添加封面图
            if ($coverPath) {
                // $coverList     = explode(",",$coverPath);
                $data['image'] = $coverPath; 
            }
            //插入数据表
            $result = Db::name('Links')->insert($data);
            if ($result) {
                return $this->success('添加成功',url('admin/links/index'));
            } else {
                return $this->error('添加失败');
            }
          
        } else {
            return $this->fetch('add');
        }
    }  

    /**
     * @author 矢志bu渝
     * 编辑链接
     */
    public function edit($id)
    {
        if (Request::instance()->isPost()) {
            // 接收post数据
            $data['id']             = input('post.id');         // 链接id
            $data['name']           = input('post.link_name');  // 链接标题
            $data['url']            = input('post.link_url');   // 链接URL            
            $data['target']         = input('post.target');     // 链接打开方式
            $data['description']    = input('post.description');// 链接描述
            $data['visible']        = input('post.visible');    // 是否可见（Y/N）
            $coverPath              = input('post.cover_path'); // 链接图片          
            // 实例化验证器
            $validate = Loader::validate('Links');                
            // 验证数据            
            if (!$validate->scene('edit')->check($data)) {
                return $this->error($validate->getError());
            } 
            // 添加封面图
            if ($coverPath) {              
                $data['image'] = $coverPath;              
            }
            $getStatus = Db::name('Links')->where('id',$data['id'])->update($data);

            if($getStatus !== false){
                return $this->success('修改成功！',url('admin/links/index'));
            } else {
                return $this->error('修改失败！');
            }
          
        } else {
            // 查询单条数据
            if (empty($id)) {
                return $this->error('请选择有效数据！');
            }   
            $map['id']     = $id;          
            $linkInfo      = Db::name('Links')->where($map)->find();  

            $this->assign('linkInfo',$linkInfo);
            return $this->fetch('Links/edit');
        }
    }


    /**
     * 更改链接是否可见，删除链接
     * Y:可见
     * N:隐藏
     * -1:删除
     * @author 矢志bu渝
     */
    public function setStatus()
    {
        $status    = input('post.status');
        $linkids   = input('post.ids/a');
        if (!in_array($status,['Y','N','-1'])) {
            return $this->error('请勾选需要操作的链接');
        }
    
        if($status=="-1") {
            $result = Db::name('Links')->where('id','in',implode(',',$linkids))->delete();
            if($result) {
                return $this->success('删除成功！');
            } else {
                return $this->error('删除失败！');
            }      
        }

        $result1 = Db::name('Links')->where('id','in',implode(',',$linkids))->update(['visible'=>$status]);
        
        if ($result1) {        
            return $this->success('修改成功！');
        } else {
            return $this->error('修改失败！');
        }
    }


        
}
