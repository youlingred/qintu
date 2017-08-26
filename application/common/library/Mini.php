<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: tangtnglove <dai_hang_love@126.com> <http://www.ixiaoquan.com>
// +----------------------------------------------------------------------

namespace common\library;

use think\Controller;
use think\Request;

/**
 * 系统底层控制器
 * @author  tangtnglove <dai_hang_love@126.com>
 */
class Mini extends Controller
{
    /**
     * 主题渲染方法
     * @author  tangtnglove <dai_hang_love@126.com>
     */
    public function themeFetch($templateName = '',$depr = '/',$suffix = 'html')
    {
        $request = Request::instance();
        // 初始化主题名称
        $this->initThemeName();
        // 初始化主题路径
        $this->initThemePath();
        // 获取当前前台设置的主题
        $themePath = './'.config('theme_dir').'/'.config('theme_name').'/';
        // 如果路径为空，则加载默认路径主题
        if (empty($templateName)) {
            // 获取当前主题文件
            $themePath = $themePath.$request->module().$depr.$request->controller().$depr.$request->action().'.'.$suffix;
        } else {
            $themePath = $themePath.$request->module().$depr.$templateName.'.'.$suffix;
        }
        // 返回模板内容
        return $this->fetch($themePath);
    }

    /**
     * 初始化主题名称
     * @author  tangtanglove
     */
    protected function initThemeName()
    {
        $theme_name = config('theme_name');
        if (empty($theme_name)) {
            $currentTheme = find_key_value('indextheme');
            if (empty($currentTheme)) {
                $currentTheme = 'default';
            }
            config('theme_name',$currentTheme);
        }
    }

    /**
     * 初始化主题路径
     * @author  tangtanglove
     */
    protected function initThemePath()
    {
        $theme_path = config('theme_path');
        if (empty($theme_path)) {
            config('theme_path',__ROOT__.'/'.config('theme_dir').'/'.config('theme_name'));
        }
    }
}
