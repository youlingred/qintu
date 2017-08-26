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
 * 系统用户控制器
 * @author  ILSunshine
 */
class Menu extends Common
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
        // Menu列表数据
        $menuList = Db::name('Menu')->select();
        // Select列表数据转换成树
        $menuListTree = list_to_tree($menuList);
        // 输出赋值
        $this->assign('menuListTree',$menuListTree);
        return $this->fetch();
    }

    /**
     * 新增菜单
     * @author  ILSunshine
     */
    public function add()
    {
        if (Request::instance()->isPost()) {
            $data = input('post.');
            $getStatus = Db::name('Menu')->insert($data);
            if ($getStatus !== false) {
                return $this->success('添加成功',url('menu/index'));
            } else {
                return $this->error('添加失败');
            }
        } else {
            $menuList = Db::name('Menu')->field(true)->select();
            // 列表数据转换成树
            $menuTree = list_to_tree($menuList);
            $this->assign('menuTree', $menuTree);
            return $this->fetch();
        }
    }

    /**
     * 编辑菜单
     * @author  ILSunshine
     */
    public function edit($id)
    {
        if (Request::instance()->isPost()) {
            $data = input('post.');
            $getStatus = Db::name('Menu')->where('id', $data['id'])->update($data);
            if ($getStatus !== false) {
                return $this->success('编辑成功',url('menu/index'));
            } else {
                return $this->error('编辑失败');
            }
        } else {
            // 查询单条数据
            if (empty($id)) {
                return $this->error('请选择有效数据');
            }
            $map['id'] = $id;
            $menuInfo = Db::name('Menu')->where($map)->find();
            //查询menu菜单数组
            $menuList = Db::name('Menu')->field(true)->select();
            // 列表数据转换成树
            $menuTree = list_to_tree($menuList);
            $this->assign('menuTree', $menuTree);
            $this->assign('menuInfo', $menuInfo);
            return $this->fetch();
        }
    }

    /**
     * 删除后台菜单
     * @author  ILSunshine
     */
    public function setstatus()
    {
        $status  = input('post.status');
        $menuids = input('post.ids/a');
        if (!in_array($status,['delete'])) {
            return $this->error('请选择需要操作的名称');
        }
        $menuResult = Db::name('Menu')->where('id','in',implode(',', $menuids))->delete();
        if ($menuResult) {
            return $this->success('操作成功！');
        } else {
            return $this->error('操作失败！');
        }
    }
}