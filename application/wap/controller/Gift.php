<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: vaey
// +----------------------------------------------------------------------

namespace app\wap\controller;

use think\Controller;
use think\Db;
use think\Request;

/**
 * 商品
 * @author  vaey 
 */
class Gift extends Base
{

	public function index()
    {
        $giftList = Db::name('Gift')->where(['status'=>1])->paginate(10);
        $page = $giftList->render();
        $this->assign('giftList',$giftList);
        $this->assign('page',$page);
        return $this->themeFetch('gift_index');
    }

    /**
     * 积分判断能否兑换
     * @return boolean [description]
     */
    public function hasScore(){
        $uid    = session('wap_user_auth.uid');
        $gid    = input('post.id');
        $user_score = Db::name('Users')->where(['id'=>$uid])->value('score');
        $gift = Db::name('Gift')->where(['id'=>$gid])->find();
        if($user_score>=$gift['score']){
            return $this->success('success','',['info'=>$gift]);
        }else{
            return $this->error('积分不足');
        }

    }

    /**
     * 积分兑换
     * @return [type] [description]
     */
    public function exchange(){

        if (Request::instance()->isPost()){
            $uid        = session('wap_user_auth.uid');
            $gid        = input('post.gid');
            $user       = input('post.user');
            $address    = input('post.address');
            $mobile     = input('post.mobile');
            $code       = input('post.code');
            $mark       = input('post.mark');
            if(!$uid || !$gid){
                return $this->error('错误');
            }
            if(!$user){
                return $this->error('收货人不能为空');
            }
            if(!$address){
                return $this->error('收货地址不能为空');
            }
            if(!$mobile){
                return $this->error('收货人手机不能为空');
            }
            if(!$code){
                return $this->error('邮政编码不能为空');
            }
            //积分查询
            $user_info = Db::name('Users')->where(['id'=>$uid])->find();
            $gift_info = Db::name('Gift')->where(['id'=>$gid])->find();
            if($user_info['score']<=$gift_info['score']){
                return $this->error('积分不足');
            }
            //数据
            $data['uid']        = $uid;
            $data['gift_id']    = $gid;
            $data['name']       = $user;
            $data['address']    = $address;
            $data['phone']      = $mobile;
            $data['code']       = $code;
            $data['mark']       = $mark;
            $data['createtime']       = time();
            //开启事务
            Db::startTrans();
            
            $score = $user_info['score']-$gift_info['score'];
                //更新用户积分
            $flg1 = Db::name('Users')->where(['id'=>$user_info['id']])->update(['score' => $score]);
            $flg2 = Db::name('GiftOrders')->insert($data);
            if($flg1 && $flg2){
                // 提交事务
                Db::commit();   
                return $this->success('兑换成功！'); 
            }else{
                // 回滚事务
                Db::rollback();
                return $this->error('出错了，请稍后再试');
            }
        }else{
            $gid = input('gid');
            if(empty($gid)){
                return $this->error('参数错误');
            }
            $this->assign('gid',$gid);
            return $this->themeFetch('gift_exchange');
        }

        

    }
	
}
