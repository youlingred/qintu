<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: vaey
// +----------------------------------------------------------------------

namespace app\wx\controller;

use think\Controller;
use think\Db;
use think\Request;

/**
 * 商品
 * @author  tangtanglove <dai_hang_love@126.com>
 */
class Goods extends Base
{

	// 商品分类
	public function index(){
		$category     = input('get.category');
        if (empty($category)) {
            //分类为空，查找第一个为默认分类
            $category = Db::name('GoodsCate')->where(['pid'=>0])->order('id asc')->value('slug');
        }
        if(is_numeric($category)){
            $map['id'] = $category;
        }else{
            $map['slug'] = $category;
        }

        //当前分类信息
        $categoryInfo = Db::name('GoodsCate')->where($map)->find();
        if(!$categoryInfo){
            return $this->error('分类不存在');
        }

        //如果当前分类为顶级分类
        if($categoryInfo['pid']==0){ //顶级分类
            //当前分类父级信息
            $parent = $categoryInfo;
            //重新获取分类信息(顶级分类的下一级默认分类)
            $categoryInfo = Db::name('GoodsCate')->where(['pid'=>$categoryInfo['id']])->order('id asc')->find();
            if(!$categoryInfo){
                return $this->error('分类不存在');
            }
        }else{
            //当前分类父级信息
            $parent = Db::name('GoodsCate')->where(['id'=>$categoryInfo['pid']])->find();
        }
        

        //所有同级别分类信息
        $selfCate = Db::name('GoodsCate')->where(['pid'=>$categoryInfo['pid']])->order('id asc')->select();
        //所有顶级分类信息
        $parentCate = Db::name('GoodsCate')->where(['pid'=>0])->order('id asc')->select();

        $this->assign('categoryInfo',$categoryInfo);
        // $this->assign('list',$list);
        $this->assign('selfCate',$selfCate);
        $this->assign('parentCate',$parentCate);
        $this->assign('parent',$parent);

        return $this->themeFetch('goods_index');
	}

	/**
	 * 商品列表页
	 * @return [type] [description]
	 */
	public function lists(){
		$category     = input('get.category');

        
        //获取排序
        $sort = input('get.sort','default');
        $order = "";
        switch ($sort) {
            case 'default':
                break;
            case 'sellup':
                $order = "sell_num asc";
                break;
            case 'selldowm':
                $order = "sell_num desc";
                break;
            case 'scoreup':
                $order = "score_num asc";
                break;
            case 'scoredown':
                $order = "score_num desc";
                break;
            case 'priceup':
                $order = "price asc";
                break;
            case 'pricedown':
                $order = "price desc";
                break;
            default:
                break;
        }

        if(is_numeric($category)){
            $map['id'] = $category;
        }else{
            $map['slug'] = $category;
        }

        // //当前分类信息
        $categoryInfo = Db::name('GoodsCate')->where($map)->find();
        if(!$categoryInfo){
            return $this->error('分类不存在');
        }
       
        
        //获取当前分类下的所有商品列表
        $ids = Db::name('GoodsCateRelationships')->where(['cate_id'=>$categoryInfo['id']])->column('goods_id');
        if($ids){
            $where['id'] = ['in',$ids];
            $where['status'] = 1;
            // 当前分类下的数据
            $list = Db::name('Goods')->where($where)->order($order)->paginate($categoryInfo['page_num']?$categoryInfo['page_num']:10,false,[
               'query'    => ['category'=>$category,'sort'=>$sort],
            ]);

            // 获取分页显示
            $page = $list->render();
        }else{
            $list= "";
            $page= "";
        }


        $this->assign('categoryInfo',$categoryInfo);
        $this->assign('list',$list);
        $this->assign('page',$page);
        $this->assign('sort',$sort);
        // $this->assign('type',$type);
        return $this->themeFetch($categoryInfo['lists_tpl']);
	}

	//商品详情页面
    public function detail(){
        $id = input('get.id');
        if(empty($id)||!is_numeric($id)){
            return $this->error('参数错误');
        }

        $categoryInfo = Db::name('GoodsCate')
        ->alias('a')
        ->join('goods_cate_relationships b','b.cate_id= a.id','LEFT')
        ->where(['b.goods_id'=>$id])
        ->field('a.*')
        ->find();

        if(empty($categoryInfo)){
            return $this->error('分类不存在');
        }

        $data = Db::name('Goods')->where(['id'=>$id])->find();
        // dump($data);die();
        $data = wap_detail_adapter($data);
        //总评论数
        $map['status'] =1;
        $map['goods_id'] = $id;
        // $total_comment = Db::name('GoodsComment')->where($map)->count();
        //获取评论列表
        $comment = Db::name('GoodsComment')->where($map)->paginate(10);

        $this->assign('data',$data);
        $this->assign('comment',$comment);
        $this->assign('page',$comment->render());

        return $this->themeFetch($categoryInfo['detail_tpl']);
    }

    //收藏
    public function collection(){
        $id     = input('post.id');
        $uid = session('wx_user_auth.uid');
        $info = Db::name('GoodsCollection')->where(['goods_id'=>$id,'uid'=>$uid])->find();
        if($info){
            if(Db::name('GoodsCollection')->where(['id'=>$info['id']])->delete()){
                return $this->success('取消收藏成功','',['img'=>'collectionone.png']);
               
            }else{
                return $this->error('取消收藏失败');
            }
        }else{
            if(Db::name('GoodsCollection')->insert(['uid'=>$uid,'goods_id'=>$id,'createtime'=>time()])){
                return $this->success('收藏成功','',['img'=>'collection_big.png']);
                
            }else{
                return $this->success('收藏失败');
            }
        }
        
    }
	
}
