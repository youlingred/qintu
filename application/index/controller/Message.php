<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: wangjingjing<1064868847@qq.com> <http://www.ixiaoquan.com>
// +----------------------------------------------------------------------

namespace app\index\controller;

use think\Controller;
use think\Request;
use think\Loader;
use think\Db;

/**
 * 留言控制器
 * @author 矢志bu渝
 */
class Message extends Base
{
	public function index(){

		if (Request::instance()->isPost()) {

			$data['mobile']  	= input('post.mobile');
			$data['email']   	= input('post.email');
			$data['content'] 	= input('post.content');
			$data['nickname']	= input('post.nickname');
			$data['createtime'] = time();
			$data['updatetime'] = $data['createtime'];

			$validate = Loader::validate('Message'); 
			// 验证
	        if (!$validate->scene('message')->check($data)) {
	            return $this->error($validate->getError());                 
	        }
	        
	        $result = Db::name('message')->insert($data);

	        if ($result) {
	        	return $this->success('留言成功，感谢您对我们的支持！');
	        } else {
	        	return $this->error('留言君走丢了，请稍后重试！');
	        }
		}else{

			$map['status'] = 1;// 只显示已答复的留言
			$list = Db::name('message')->where($map)->order('createtime desc')->field(true)->paginate(10);

			$this->assign('list',$list);
			return $this->themeFetch('message');
		}
		
	}
}