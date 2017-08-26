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
use think\Request;

/**
 * 系统用户控制器
 * @author  ILSunshine
 */
class Config extends Common
{
    /**
     * 系统配置
     */
    public function edit()
    {
          
        if(Request::instance()->isPost()) {              
            $data         = input('post.');
            $collection   = "config.base" ;
            $uuid         = "default" ;
            $result       = update_key_value($collection,$data,$uuid); 

            if($result){
                return $this->success('保存成功');
            }else {
                return $this->error('请选择更新数据');
            }
        }else{
            $collection   = "config.base" ;
            $uuid         = "default" ;
            $list         = select_key_value($collection,$uuid);     
            $this->assign('list',$list);
            return $this->fetch();
        }
    }
    /**
     * 新增配置项
     */
    public function add(){
        if(Request::instance()->isPost()) {
            $data         = input('post.');
            $collection   = "config.base" ;
            $uuid         = "default" ;
            dump($data);die();
            $result       = insert_key_value($collection,$data,$uuid);
            if($result){
                return $this->success('添加成功！',url('edit'));
            }else {
                return $this->error('添加失败！');
            }
        }else{
            return $this->fetch();
        }        
    }
}
   

