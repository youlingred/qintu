<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: wangjingjing<1064868847@qq.com> <http://www.ixiaoquan.com>
// +----------------------------------------------------------------------

namespace app\index\controller;

use think\Db;
use think\Log;
use think\Loader;
use think\Request;

/**
 *  收货地址管理
 * @author  ILsunshine
 */
class Address extends Common
{
/**
     * 收货地址
     * @author  ILsunshine
     */
    public function userAddress() {

        if (Request::instance()->isPost()) {
            // 接收post数据
            $address           = input('post.address');//地址
            $province          = input('post.province');//详细地址
            $city              = input('post.city');//详细地址
            $county            = input('post.county');//详细地址
            $mobile            = input('post.mobile');//手机号
            $consignee_name    = input('post.consignee_name');//收货人
            $checkvalue        = input('post.checkvalue');//设为默认          
            // 实例化验证器
            $validate = Loader::validate('Address'); 

            // 验证数据
            $data['address']         = $address;
            $data['consignee_name']  = $consignee_name;
            $data['province']        = $province;
            $data['city']            = $city;
            $data['county']          = $county;
            $data['mobile']          = $mobile; 
            if (!$validate->scene('address')->check($data)) {
                return $this->error($validate->getError());
            }

            // 保存地址
            $map['uid']     = UID;
            $map['status']  = 1;             
            $count          = Db::name('OrdersAddress')->where($map)->count();
            if($count <11){                
                // 存在默认地址
                if($checkvalue==2){
                    $where['uid']      = UID;
                    $where['default']  = 1;
                    if(Db::name('OrdersAddress')->where($where)->find()){
                        Db::name('OrdersAddress')->where($where)->setField('default',-1);
                    }
                    $data['uid']       = UID;
                    $data['default']   = 1;
                    $getStatus         = Db::name('OrdersAddress')->insert($data);                   
                }else{
                    if($count == 0){
                        $data['uid']       = UID;
                        $data['default']   = 1;
                        $getStatus         = Db::name('OrdersAddress')->insert($data);
                    }else{
                        $data['uid']       = UID;
                        $where['default']  = 0;
                        $getStatus         = Db::name('OrdersAddress')->insert($data);  
                    }                    
                } 
                if($getStatus != false){
                        return $this->success('保存地址成功');
                    } else {
                        return $this->error('保存失败');
                    }           
            }else{
                return $this->error('最多可保存10条数据');
            }
        } else { 
            $map['uid']     = UID;
            $map['status']  = 1;  
            $addressList    = Db::name('OrdersAddress')->where($map)->select(); 
            $count          = Db::name('OrdersAddress')->where($map)->count();
            $lastcount      = 10-$count;
            $this->assign('count',$count);
            $this->assign('lastcount',$lastcount);
            $this->assign('addressList',$addressList);
            return $this->themeFetch('user_address');
        }
    }

    /**
     * 删除收货地址
     * @author  ILsunshine
     */
    public function delAddress(){
        $id     = input('post.address_id');
        $result = Db::name('OrdersAddress')->where('id',$id)->setField('status',-1);
        if($result) {
            return $this->success('删除成功！',url('index/address/userAddress'));
        } else {
            return $this->error('删除失败！');
        } 
    }
}    