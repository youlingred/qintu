<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: tangtanglove <dai_hang_love@126.com> <http://www.ixiaoquan.com>
// +----------------------------------------------------------------------

namespace app\wap\controller;

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
        if (session('wap_user_auth')) {
            define('UID', session('wap_user_auth.uid'));
        } else {
            define('UID', null);
        }
        if(!(UID)){
            $this->redirect(url('base/login'));
        }
     
        // 用户登陆id
        $this->users = session('wap_user_auth');
        
        $this->assign('userinfo',session('wap_user_auth'));
        // 不存在index.php，则定义
        $request = Request::instance();
        if (!substr_count($request->url(),'wap.php')) {
            //设置请求信息，解决某些环境下面url()方法获取不到index.php
            $request->root('wap.php');
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
        session('wap_user_auth',null);
        $this->redirect(url('index/index'));
    }

}
