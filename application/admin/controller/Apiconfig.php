<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 矢志bu渝 <745152620@qq.com> <http://www.ixiaoquan.com>
// +----------------------------------------------------------------------

namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Db;

/**
 * 接口配置控制器
 * @author  矢志bu渝
 */
class Apiconfig extends Common
{
    /**
     * 各个配置设置
     */
    public function edit()
    {
       
        if( Request::instance()->isPost() ) {              
            $data     = input('post.');
            foreach ($data as $key => $value) {
                $map['key'] = $key;
                
                $result = Db::name('Apiconfig')->where($map)->setField('value', $value);
                      
                if( $result === false ) {
                    return $this->error('操作异常！');
                }
            }
            return $this->success('修改成功！',url('admin/apiconfig/edit'));
        } else {    
            $list   =  Db::name('Apiconfig')->select(); 
            $this->assign('list',$list);          
            return $this->fetch();
        }
    }
    
}
   

