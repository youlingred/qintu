<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: tangtanglove <dai_hang_love@126.com> <http://www.ixiaoquan.com>
// +----------------------------------------------------------------------

namespace app\index\controller;

use think\Controller;
use think\Request;
use common\library\Mini;

/**
 * 系统通用控制器：需登录
 * @author  tangtnglove <dai_hang_love@126.com>
 */
class Common extends Mini
{
	var $users = '';
    /**
     * 初始化方法
     * @author tangtanglove
     */
    protected function _initialize()
    {
    	$this->users = session('index_user_auth');
    	if(empty($this->users)){
    		 $this->redirect(url('base/login'));
    	}
    	
    	define('UID', session('index_user_auth.uid'));
    	
        // 用户登陆id
        $this->users = session('index_user_auth');
        
        $this->assign('userinfo',session('index_user_auth'));
        // 不存在index.php，则定义
        $request = Request::instance();
        if (!substr_count($request->url(),'index.php')) {
            //设置请求信息，解决某些环境下面url()方法获取不到index.php
            $request->root('index.php');
        }
        // 储存网站配置
        config(select_key_value('config.base'));
        load_config();// 加载接口配置      
    }

    /**
     * 退出处理
     */
    public function logout()
    {
        //退出登錄註銷session
        session('index_user_auth',null);
//      $this->redirect(url('base/login'));
		$this->redirect(url('index/index'));
    }

}
