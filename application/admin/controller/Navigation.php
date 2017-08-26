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
use think\Request;

/**
 * 导航控制器
 * @author  ILSunshine
 */
class Navigation extends Common
{
    /**
     * 后台菜单首页
     * @author  ILSunshine
     */
    public function index()
    {
        // 搜索词
        $q = input('q');
        if (!empty($q)) {
            $map['a.name'] = ['like','%'.mb_convert_encoding($q, "UTF-8", "auto").'%'];
        }
        // 条件为空则赋值
        if (empty($map)) {
            $map = 1;
        }
        // Navigation列表数据
        $navigationList = Db::name('Navigation')->select();
        // Select列表数据转换成树
        $navigationListTree = list_to_tree($navigationList);
        // 输出赋值
        $this->assign('navigationListTree',$navigationListTree);
        return $this->fetch();
    }

    /**
     * 新增导航
     * @author  ILSunshine
     */
    public function add()
    {
        if (Request::instance()->isPost()) {
            $data = input('post.');
            $getStatus = Db::name('Navigation')->insert($data);
            if ($getStatus !== false) {
                return $this->success('添加成功',url('navigation/index'));
            } else {
                return $this->error('添加失败');
            }
        } else {
            $navigationList = Db::name('Navigation')->field(true)->select();
            // 列表数据转换成树
            $navigationTree = list_to_tree($navigationList);
            $this->assign('navigationTree', $navigationTree);
            return $this->fetch();
        }
    }

    /**
     * 编辑导航
     * @author  ILSunshine
     */
    public function edit($id)
    {
        if (Request::instance()->isPost()) {
            $data = input('post.');
            $getStatus = Db::name('Navigation')->where('id', $data['id'])->update($data);
            if ($getStatus !== false) {
                return $this->success('编辑成功',url('navigation/index'));
            } else {
                return $this->error('编辑失败');
            }
        } else {
            // 查询单条数据
            if (empty($id)) {
                return $this->error('请选择有效数据');
            }
            $map['id'] = $id;
            $navigationInfo = Db::name('Navigation')->where($map)->find();
            //查询navigation数组
            $navigationList = Db::name('Navigation')->field(true)->select();
            // 列表数据转换成树
            $navigationTree = list_to_tree($navigationList);
            $this->assign('navigationTree', $navigationTree);
            $this->assign('navigationInfo', $navigationInfo);
            return $this->fetch();
        }
    }

    /**
     * 删除导航
     * @author  ILSunshine
     */
    public function setstatus()
    {
        $status  = input('post.status');
        $navigationids = input('post.ids/a');
        if (!in_array($status,['delete'])) {
            return $this->error('请勾选需要操作的导航');
        }
        $navigationResult = Db::name('Navigation')->where('id','in',implode(',', $navigationids))->delete();
        if ($navigationResult) {
            return $this->success('操作成功！');
        } else {
            return $this->error('操作失败！');
        }
    }
}