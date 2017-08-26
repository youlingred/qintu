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
use think\Db;
use think\Loader;
use think\Request;
use common\library\Form;

/**
 * 智能表单demo控制器，其它可参照此控制器
 * @author  tangtanglove <dai_hang_love@126.com>
 */
class Demo extends Common
{
    /**
    * 智能表单实例
    * @author  tangtanglove <dai_hang_love@126.com>
    */
    public function form()
    {
        // 智能表单对象
        $form  = new Form;
        // checkbox默认条件
        $checkboxOption = ['index'=>'首页推荐','channel'=>'频道页推荐','list'=>'列表页推荐'];
        // select默认条件
        $selectOption   = ['index'=>'首页推荐','channel'=>'频道页推荐','list'=>'列表页推荐'];
        // radio默认条件
        $radioOption    = ['index'=>'首页推荐','channel'=>'频道页推荐','list'=>'列表页推荐'];
        // checkbox传入数据
        $checkboxData = ['channel','list'];
        // select传入数据
        $selectData = 'list';
        // radio传入数据
        $radioData = 'list';

        return $formhandle = $form
        ->text('text控件','','text控件','text控件','text控件')
        ->radio('radio控件',$radioOption,$radioData,'radio','radio控件',$class = '')
        ->checkbox('checkbox控件',$checkboxOption,$checkboxData,'checkbox','checkbox控件',$class = '')
        ->select('select控件',$selectOption,$selectData,'checkbox','select控件',$class = '')
        ->renderhtml('body','文章|添加文章');
    }
}
