<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: tangtanglove <dai_hang_love@126.com> <http://www.ixiaoquan.com>
// +----------------------------------------------------------------------

namespace app\admin\controller;

use think\Controller;
use think\Lang;
use think\Request;
use think\Db;

/**
 * 系统通用控制器：需登录
 * @author  tangtanglove <dai_hang_love@126.com>
 */
class Common extends Controller
{
    /**
     * 初始化方法
     * @author tangtanglove
     */
    protected function _initialize()
    {
    	if (session('admin_user_auth')) {
            if (!defined('UID')) {
    		    define('UID', session('admin_user_auth.uid'));
            }
            // 初始化导航
            $this->navbar();
    	} else {
    		define('UID', null);
    	}
        if(!UID){
            $this->redirect(url('base/login'));
        }
        //权限判断
        $this->auth();
        load_config();// 加载接口配置      
    }

    /* 退出登录 */
    public function logout()
    {
        //退出登錄註銷session
        session('admin_user_auth',null);
        $this->redirect(url('base/login'));
    }

    /**
     * 后台菜单
     * @author tangtanglove
     */
    protected function navbar()
    {
        $menuList = Db::name('Menu')->where(['hide'=>0])->select();
        $menuList = list_sort_by($menuList,'sort');

        //获取当前登录者的权限
        $authArray = get_menu_auth();
        $list = [];
        foreach ($menuList as $key => $data) {
            if(check_menu_auth($data['id'],$authArray)){
                $list[] = $data; 
            }
        }
        // 列表数据转换成树
        $menuTree = list_to_tree($list);
        $this->assign('menuTree', $menuTree);
    }

     /**
     * 权限判断
     * @return [type] [description]
     */
    protected function auth(){
        $request        = Request::instance();
        //获取当前控制器
        $controller     = strtolower($request->controller());
        //获取当前方法
        $action         = strtolower($request->action());
        //组合url
        $url            = $controller."/".$action;
        //查询当前登录用户的uuid
        $uuid           = Db::name('Users')->where('id',UID)->value('uuid');
        $keyValue       = Db::name('KeyValue')->where('uuid',$uuid)->find();
        if($keyValue && $keyValue['value']==1){
            //超级管理员，直接返回
            return true;
        }
        //获取菜单的id
        $ruleId         = Db::name('Menu')->where('url',$url)->value('id');
        //获取当前登录用户所在的用户组(可以是多组)
        $group          = Db::name('UserGroupAccess')->where('uid',UID)->select();
        if(!$group){
            return $this->error("没有权限");
        }
        //所有权限数组
        $rules_array = [];
        $arr = [];
        foreach ($group as  $v) {
            $rules = Db::name('UserGroup')->where('id',$v['group_id'])->where('status',1)->value('rules');
            if($rules){
                $arr = explode(',',$rules);
            }
            $rules_array = array_merge($rules_array, $arr);  
        }
        //去除重复值
        $rules_array = array_unique($rules_array); 
        //权限判断
        if(!in_array($ruleId,$rules_array)){
            return $this->error("没有权限");
        }

    }
}
