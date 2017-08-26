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
use think\Input;
use think\Loader;
use think\Request;

/**
 * 系统用户控制器
 * @author  tangtanglove
 */
class Page extends Common
{
    /**
     * 后台页面首页
     * @author  tangtanglove
     */
    public function index()
    {
        // 搜索词
        $q = input('q');
        if (!empty($q)) {
            $map['a.title'] = ['like','%'.mb_convert_encoding($q, "UTF-8", "auto").'%'];
        }
        // 条件为空则赋值
        if (empty($map)) {
            $map = 1;
        }
        // posts列表数据
        $postsList = Db::name('Posts')->where(['type'=>'page'])->select();
        // Select列表数据转换成树
        $postsListTree = list_to_tree($postsList);
        // 输出赋值
        $this->assign('postsListTree',$postsListTree);
        return $this->fetch();
    }

    /**
     * 新增页面
     * @author  tangtanglove
     */
    public function add()
    {
        if (Request::instance()->isPost()) {
            // 接收post数据
            $title          = input('post.title');// 文章标题
            $pid            = input('post.pid');// pid
            $content        = input('post.content');// 文章内容
            $level          = input('post.level');// 文章排序
            $name           = input('post.name');// 文章别名
            $page_tpl       = input('post.page_tpl');// 文章模板
            $coverPath      = input('post.cover_path');

            $data['title']      = $title;
            $data['uid']        = UID;
            $data['pid']        = $pid;
            $data['uuid']       = create_uuid();
            $data['content']    = $content;
            $data['level']      = $level;
            $data['name']       = $name;
            $data['createtime'] = time();
            $data['updatetime'] = $data['createtime'];
            $data['type']       = 'page';
            $data['status']     = 'publish';
            // 添加数据
            $postid = $this->update($data);
            if ($postid) {
                // 添加封面图
                if ($coverPath) {
                    $coverList = explode(",",$coverPath);
                    foreach ($coverList as $key => $value) {
                        if ($value) {
                            insert_key_value('posts.cover',['cover_path_'.$key=>$value],$data['uuid']);
                        }
                    }
                }
                // 添加页面模板
                if ($page_tpl) {                 
                    insert_key_value('posts.form',['page_tpl'=>$page_tpl],$data['uuid']);
                }
                return $this->success('发布成功！',url('index'));
            } else {
                return $this->error('发布失败！');
            }
        } else {
            // posts列表数据
            $postsList = Db::name('Posts')->where(['type'=>'page'])->select();
            // Select列表数据转换成树
            $postsListTree = list_to_tree($postsList);
            // 输出赋值
            $this->assign('postsListTree',$postsListTree);
            return $this->fetch();
        }
    }

    /**
     * 编辑页面
     * @author  tangtanglove
     */
    public function edit($id)
    {
        if (Request::instance()->isPost()) {
            // 接收post数据
            $id             = input('post.id');
            $uuid           = input('post.uuid');
            $title          = input('post.title');// 文章标题
            $pid            = input('post.pid');// pid
            $content        = input('post.content');// 文章内容
            $level          = input('post.level');// 文章排序
            $name           = input('post.name');// 文章别名
            $page_tpl       = input('post.page_tpl');// 文章别名
            $coverPath      = input('post.cover_path');

            $data['title']      = $title;
            $data['uuid']       = $uuid;
            $data['uid']        = UID;
            $data['pid']        = $pid;
            $data['uuid']       = create_uuid();
            $data['content']    = $content;
            $data['level']      = $level;
            $data['name']       = $name;
            $data['updatetime'] = time();
            $data['type']       = 'page';
            $data['status']     = 'publish';
            // 添加数据
            $postid = $this->update($data,['id'=>$id]);
            if ($postid) {
                // 清除历史封面
                delete_key_value('posts.cover',$data['uuid']);
                // 添加封面图
                if ($coverPath) {
                    $coverList = explode(",",$coverPath);
                    foreach ($coverList as $key => $value) {
                        if ($value) {
                            insert_key_value('posts.cover',['cover_path_'.$key=>$value],$data['uuid']);
                        }
                    }
                }
                // 更新page页模板
                delete_key_value('posts.form',$data['uuid']);
                if ($page_tpl) {
                    insert_key_value('posts.form',['page_tpl'=>$page_tpl],$data['uuid']);
                }
                return $this->success('编辑成功！',url('index'));
            } else {
                return $this->error('编辑失败！');
            }
        } else {
            // 更新数据
            $id = input('id');
            if (empty($id)) {
                return $this->error('请选择数据！');
            }
            // 文章信息
            $postsInfo        = Db::name('Posts')->where('id',$id)->find();
            // 文章封面图
            $coverList        = select_key_value('posts.cover',$postsInfo['uuid']);
            // 文章模板
            $page_tpl         = find_key_value('posts.form',$postsInfo['uuid']);
            // posts列表数据
            $postsList = Db::name('Posts')->where(['type'=>'page'])->select();
            // Select列表数据转换成树
            $postsListTree = list_to_tree($postsList);
            // 输出赋值
            $this->assign('postsInfo',$postsInfo);
            $this->assign('coverList',$coverList);
            $this->assign('page_tpl' ,$page_tpl);
            $this->assign('postsListTree',$postsListTree);
            return $this->fetch();
        }
    }

    /**
     * 更新页面
     * @author tangtanglove
     */
    private function update($data,$map = '')
    {
        // 实例化验证器
        $validate = Loader::validate('Posts');
        // 验证
        if(!$validate->check($data)){
            return $this->error($validate->getError());
        }
        if (empty($map)) {
            // 新增数据
            $postsStatus = Db::name('Posts')->insert($data);
            // 执行成功，返回文章id
            return $postsStatus ? Db::getLastInsID() : false;
        } else {
            // 更新数据
            $postsStatus = Db::name('Posts')->where($map)->update($data);
            // 执行成功，返回文章id
            return $postsStatus ? $map['id'] : false;
        }
    }

    /**
     * 删除页面
     * @author  tangtanglove
     */
    public function setstatus()
    {
        $status  = input('post.status');
        $menuids = input('post.ids/a');
        if (!in_array($status,['delete'])) {
            return $this->error('请勾选需要操作的页面');
        }
        $menuResult = Db::name('Posts')->where('id','in',implode(',', $menuids))->delete();
        if ($menuResult) {
            return $this->success('操作成功！');
        } else {
            return $this->error('操作失败！');
        }
    }
}