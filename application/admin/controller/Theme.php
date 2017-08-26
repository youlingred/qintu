<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 天行健 <764617706@qq.com> 
// +----------------------------------------------------------------------

namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\Loader;
use think\Request;

/**
 * 主题设置控制器
 * @author  天行健
 */
class Theme extends Common
{
    /**
     * 读取 public\themes\ 下文件名
     * 此目录下只可放主题文件夹
     * 文件夹名称即主题名称
     * 只可使用英文名命名文件夹
     * 主题预览图片默认大小260*150
     * @author 天行健
     */
    public function index() {

        //查找目录下的主题文件夹
        $dir  ="themes";
        $file =scandir($dir);
        $this->assign('file',$file);               
        //判断主题是否应用        	
        $result = Db::name('key_value')->where('collection','indextheme')->value('value');
        $this->assign('result',$result);

    	return $this->fetch('index');
    }

     /**
     * 实现主题切换功能
     * @author 天行健
     */
    public function change(){

        $name = input('post.name'); 
        $result = Db::name('key_value')->where('collection','indextheme')->update(['value' => $name]);

        if($result){
            return  $this->success('主题更换成功');
        }else{
            return $this->error('此主题已应用');
                }


    }


}