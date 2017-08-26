<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: Vaey
// +----------------------------------------------------------------------

namespace app\upgrade\controller;

use think\Controller;
use think\Request;
use think\Db;

/**
 * 系统升级控制器
 * @author  矢志bu渝
 */
class Index extends Controller
{
    
    //检测新版本
    public function index()
    {
        //新版本的版本号
        $data['version'] = "";
        //$data['address'] = "";

        $version = input('post.version');
        
        $info = Db::name("KeyValue")->where('name','version')->where('value','>',$version)->order('value asc')->find();
        if($info){
            //$data['address'] = Db::name('KeyValue')->where('name','address')->where('uuid',$info['uuid'])->value('value');
            $data['version'] = $info['value'];
        }
        return json_encode($data);
    }

    //详细版本信息
    public function versionInfo(){
        //新版本的版本号、下载路径、文章详情、标题
        $data['version'] = "";
        $data['address'] = "";
        $data['content'] = "";
        $data['title']   = "";

        $version = input('post.version');
        
        $info = Db::name("KeyValue")->where('name','version')->where('value','>',$version)->order('value asc')->find();
        if($info){
            $data['address'] = Db::name('KeyValue')->where('name','address')->where('uuid',$info['uuid'])->value('value');
            $data['version'] = $info['value'];

            $article = Db::name('Posts')->where('uuid',$info['uuid'])->find();
            $data['content'] = $article['content'];
            $data['title']   = $article['title'];
        }
        return json_encode($data);
    }
    
}
   

