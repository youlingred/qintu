<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: tangtanglove <dai_hang_love@126.com> <http://www.ixiaoquan.com>
// +----------------------------------------------------------------------

namespace app\helper\controller;

use think\Controller;
use think\Db;
use think\Request;

/**
 * 助手控制器
 * @author  完美°ぜ界丶
 */
class Index extends Controller
{
    //首页
    public function index()
    {
        $is_login = session('helper');
        if(empty($is_login)){
            $this->redirect('index/login');
        }else{
            return $this->fetch();
        }
    }
    //登录
    public function login()
    {
        if (Request::instance()->isPost()) {
            $password = input('post.password');
            $get_config = ROOT_PATH . '/application/helper/config.php';
            if (is_file($get_config)) {
                $get_config_info = require($get_config);
                if (!empty($password) && $get_config_info['HELPER_PASSWORD']==$password) {
                    session('helper','is_login');
                    return $this->redirect('index/index');
                } else {
                    return $this->error('密码错误');
                }
            } else {
                return $this->error('无法登录！');
            }
        } else {
            return $this->fetch('login');
        }
    }
    //退出
    public function logout()
    {
        session('helper',null);
        return $this->success('退出成功！');
    }
}
