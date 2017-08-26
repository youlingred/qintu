<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: tangtanglove <dai_hang_love@126.com> <http://www.ixiaoquan.com>
// +----------------------------------------------------------------------

namespace app\wap\controller;

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
///////亲途添加
    public function isLogin(){
    	if(empty($this->users)){
    		 return false;
    	}else{
    		return true;
    	}
	}
	//提交私人定制需求单
	public function postPerson(){
		$name         = input('post.name');
        $mobile        = input('post.mobile');
        $email        = input('post.email');
        $reached       = input('post.reached');
        $out_date      = input('post.out_date');
		$out_days     = input('post.out_days');
		$man      = input('post.man');
		$children      = input('post.children');
		$cost     = input('post.cost');
		$description      = input('post.description');
		$createtime     = time();

        
        $data['name']      		= $name;
		$data['mobile']       	= $mobile;
        $data['email']    		= $email;
        $data['reached'] 		= $reached;
        $data['out_date'] 		= $out_date;
        $data['out_days']       = $out_days;
        $data['man']     		= $man;
		$data['children']     	= $children ;
		$data['cost']     		= $cost;
		$data['description']    = $description;
		$data['createtime']    = $createtime;
		$postsStatus = Db::name('Person_need')->insert($data);
		return $postsStatus ? Db::getLastInsID() : false;
	}
	//提交商业合作需求单
	public function postBusiness(){
		$name         = input('post.name');
        $mobile        = input('post.mobile');
        $wx      		= input('post.weixin');
		$description      = input('post.description');

        
        $data['name']      		= $name;
		$data['mobile']       	= $mobile;
        $data['wx']    		= $wx;
		$data['description']    = $description;
		$postsStatus = Db::name('Business_need')->insert($data);
		return $postsStatus ? Db::getLastInsID() : false;
	}
	//提交婚拍需求单
	public function postHunpai(){
		$name         = input('post.name');
        $mobile        = input('post.mobile');
        $wx      		= input('post.weixin');
		$description      = input('post.description');

        
        $data['name']      		= $name;
		$data['mobile']       	= $mobile;
        $data['wx']    		= $wx;
		$data['description']    = $description;
		$postsStatus = Db::name('Hunpai_need')->insert($data);
		return $postsStatus ? Db::getLastInsID() : false;
	}
	//提交旅拍需求单
	public function postLvpai(){
		$name         = input('post.name');
        $mobile        = input('post.mobile');
        $wx      		= input('post.weixin');
		$description      = input('post.description');

        
        $data['name']      		= $name;
		$data['mobile']       	= $mobile;
        $data['wx']    		= $wx;
		$data['description']    = $description;
		$postsStatus = Db::name('Lvpai_need')->insert($data);
		return $postsStatus ? Db::getLastInsID() : false;
	}
	//提交医疗需求单
	public function postYliao(){
		$name         = input('post.name');
        $mobile        = input('post.mobile');
        $wx      		= input('post.weixin');
		$description      = input('post.description');

        
        $data['name']      		= $name;
		$data['mobile']       	= $mobile;
        $data['wx']    			= $wx;
		$data['description']    = $description;
		$postsStatus = Db::name('Yiliao_need')->insert($data);
		return $postsStatus ? Db::getLastInsID() : false;
	}
}
