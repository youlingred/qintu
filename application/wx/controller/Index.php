<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: tangtanglove <dai_hang_love@126.com> <http://www.ixiaoquan.com>
// +----------------------------------------------------------------------

namespace app\wx\controller;

use think\Controller;
use think\Request;

/**
 * 网站首页控制器
 * @author  tangtnglove <dai_hang_love@126.com>
 */
class Index extends Base
{
    public function index()
    {
    	// 输出主题
        return $this->themeFetch('index');
    }
}
