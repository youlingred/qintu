<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: wangjingjing<1064868847@qq.com> <http://www.ixiaoquan.com>
// +----------------------------------------------------------------------

namespace app\api\controller;

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
    public function userAddress_get_json()
    {
        $page       = input('page',1);
        $num        = input('num',10);
        $map['uid']     = UID;
        $map['status']  = 1;
        $addressList    = Db::name('OrdersAddress')
                        ->where($map)
                        ->field('concat(province,city,county,address) as user_address')
                        ->field(true)
                        ->page($page,$num)
                        ->select();            
        // 获取分页显示
        if(!empty($addressList)) {
            return $this->restSuccess('获取成功！',$addressList);
        } else {
            return $this->restError('没有数据了！');
        }
    }

    /**
     * 收货地址详情
     * @author  ILsunshine
     */
    public function addressDetail_get_json()
    {
        $id           = input('get.id');   
        $addressInfo  = Db::name('OrdersAddress')->where('id',$id)->find();
        if(!empty($addressInfo)) {
            return $this->restSuccess('获取成功！',$addressInfo);
        } else {
            return $this->restError('没有数据了！');
        }
    }

    /**
     * 编辑收货地址
     * @author  ILsunshine
     */
    public function editAddress_post_json()
    {
        // 接收post数据
        $id                = input('post.id');
        $address           = input('post.address');//地址
        $province          = input('post.province');//省
        $city              = input('post.city');//市
        $county            = input('post.county');//县
        $mobile            = input('post.mobile');//手机号
        $consignee_name    = input('post.consignee_name');//收货人
    
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
            return $this->restError($validate->getError());
        }

        // 更新地址
        $map['uid']     = UID;
        $map['id']      = $id;             
        $getStatus      = Db::name('OrdersAddress')->where($map)->update($data);                   
        if($getStatus) {
            return $this->restSuccess('编辑成功');
        }else{
            return $this->restError('编辑失败');
        }
    }

    /**
     * 新增收货地址
     * @author  ILsunshine
     */
    public function addAddress_post_json()
    {
        // 接收post数据
        $address           = input('post.address');//地址
        $province          = input('post.province');//详细地址
        $city              = input('post.city');//详细地址
        $county            = input('post.county');//详细地址
        $mobile            = input('post.mobile');//手机号
        $consignee_name    = input('post.consignee_name');//收货人          
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
            return $this->restError($validate->getError());
        }

        // 保存地址
        $map['uid']     = UID;
        $map['status']  = 1;             
        $count          = Db::name('OrdersAddress')->where($map)->count();
        if($count <11){
            $data['uid']       = UID;
            $data['default']   = 0;
            $getStatus         = Db::name('OrdersAddress')->insert($data);
            $id = Db::getLastInsID();
            if($getStatus != false){
			        return $this->restSuccess('保存成功',['id'=>$id]);
                } else {
                    return $this->restError('保存失败');
                }           
        }else{
            return $this->restError('最多可保存10条数据');
        }
    }

    /**
     * 删除收货地址
     * @author  ILsunshine
     */
    public function delAddress_post_json()
    {
        $id     = input('post.address_id');
        $result = Db::name('OrdersAddress')->where('id',$id)->setField('status',-1);
        if($result) {
            return $this->restSuccess('删除成功！');
        } else {
            return $this->restError('删除失败！');
        } 
    }
    /**
     * 设置收货地址
     * @author  ILsunshine
     */
    public function setDefault_post_json()
    {
        $id        = input('post.address_id');
        $getStatus = Db::name('OrdersAddress')->where('default',1)->setField('default',-1);
        $result    = Db::name('OrdersAddress')->where('id',$id)->setField('default',1);
        if($result&&$getStatus) {
            return $this->restSuccess('设置成功！');
        } else {
            return $this->restError('设置失败');
        } 
    }
}    