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
use think\Request;
use think\controller\Rest;

/**
 *  商品收藏管理
 *   
 */
class Collection extends Common
{
    /**
     * 我的收藏
     * @author ILsunshine
     */
    public function collection_get_json()
    {   
        // 当前页码
        $page       = input('page',1);
        // 分页数量
        $num        = input('num',10);

        $lists = Db::name('GoodsCollection')
        ->alias('a')
        ->join('goods b','b.id= a.goods_id','LEFT')
        ->where(array('a.uid'=>UID))
        ->field('a.*,b.name,b.price,b.standard,b.cover_path,b.sell_num')
        ->order('a.createtime desc')
        ->page($page,$num)
        ->select();

        foreach ($lists as $key => $value) {
            $lists[$key]['cover_path'] = str_replace('/uploads', 'http://'.$_SERVER['HTTP_HOST'].__ROOT__.'/uploads', $value['cover_path']);
        }

        // 获取分页显示
        if(!empty($lists)) {
            return $this->restSuccess('获取成功！',$lists);
        } else {
            return $this->restError('没有数据了！');
        }
    }

     /**
     * 删除收藏商品
     * @author  ILsunshine
     */
    public function delGoodsCollection_post_json()
    {
        $ids        = json_decode(input('post.ids'));
        $map['id']  = array('in',implode(',',$ids));
        $map['uid'] = UID;
        $result = Db::name('GoodsCollection')->where($map)->delete();
        if($result) {
            return $this->restSuccess('删除成功！');
        } else {
            return $this->restError('删除失败！');
        } 
    } 
    
    /**
     * 积分兑换
     * @return [type] [description]
     */
    public function exchange_post_json(){
        
        $gid        = input('post.gid');
        $user       = input('post.user');
        $address    = input('post.address');
        $mobile     = input('post.mobile');
        $code       = input('post.code');
        $mark       = input('post.mark');
        if(!UID || !$gid){
            return $this->restError('错误');
        }
        if(!$user){
            return $this->restError('收货人不能为空');
        }
        if(!$address){
            return $this->restError('收货地址不能为空');
        }
        if(!$mobile){
            return $this->restError('收货人手机不能为空');
        }
        if(!$code){
            return $this->restError('邮政编码不能为空');
        }
        //积分查询
        $user_info = Db::name('Users')->where(['id'=>UID])->find();
        $gift_info = Db::name('Gift')->where(['id'=>$gid])->find();
        if($user_info['score']<=$gift_info['score']){
            return $this->restError('积分不足');
        }
        //数据
        $data['uid']        = UID;
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
            return $this->restSuccess('兑换成功！',$score); 
        }else{
            // 回滚事务
            Db::rollback();
            return $this->restError('出错了，请稍后再试');
        }

    }

    /**
     * 积分判断能否兑换
     * @return boolean [description]
     */
    public function hasScore_post_json(){
        
        $gid    = input('post.gid');
        $user_score = Db::name('Users')->where(['id'=>UID])->value('score');
        $gift = Db::name('Gift')->where(['id'=>$gid])->value('score');
        if($user_score>=$gift){
            return $this->restSuccess('可以兑换');
        }else{
            return $this->restError('积分不足');
        }

    }

    /**
     * 兑换记录
     */
    public function lists_get_json()
    {   

        // 当前页码
        $page       = input('page',1);
        // 分页数量
        $num        = input('num',10);        
        $lists = Db::name('GiftOrders')
        ->alias('a')
        ->join('gift b','b.id= a.gift_id','LEFT')
        ->where(array('a.uid'=>UID))
        ->field('a.*,b.name as giftname,b.cover_path,b.score,b.standard')
        ->order('a.id desc')->page($page,$num)->select();

        if(!empty($lists)) {
            return $this->restSuccess('获取成功！',$lists);
        } else {
            return $this->restError('没有数据了！');
        }     
    }
}
