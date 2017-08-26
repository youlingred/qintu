<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: vaey
// +----------------------------------------------------------------------

namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Request;

/**
 * 商品控制器
 * @author  vaey
 */
class Goods extends Base
{

    public function index()
    {
        $this->redirect('lists');
    }
    //商品列表，
    public function lists()
    {
        $str_category     = input('get.category');
		$categorys 	  	  = explode("|", $str_category);
		$str_filter       = input('get.filter');
		$filters 	      = explode("|", $str_filter);
		$search			  = input('get.search');
//		if(empty($categorys)){
//			$value = Db::name('GoodsCate')->where(['pid'=>0])->order('id asc')->value('slug');
//			array_push($categorys,$value);
//		}
//		foreach($categorys as $k=>$value){
//			if(empty($value)){
//				$categorys[$k] = Db::name('GoodsCate')->where(['pid'=>0])->order('id asc')->value('slug');
//			}
//		}
        $type          = input('get.type');
        if(empty($type)){
            $type = 1;
        }
        
        //获取排序
        $sort = input('get.sort','default');
        $order = "";
        switch ($sort) {
            case 'default':
                break;
			case 'areaup':
           		 $order = "label_area asc,cate_id asc";
            break;
			case 'areadown':
           		 $order = "label_area desc,cate_id asc";
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
		$map=array();
		$goods_ids=array();
		$selfCates=array();
		$categoryInfos=array();
		$goods_cate_ids=array();
		foreach($categorys as $value){
			if(is_numeric($value)){
	            $map['id'] = $value;
	        }else{
	            $map['slug'] = $value;
	        }
			$categoryInfo = Db::name('GoodsCate')->where($map)->find();
			if(!$categoryInfo){
	          array_push($selfCates,null);
			  array_push($categoryInfos,null);
	        }else{
	      	  $selfCate = Db::name('GoodsCate')->where(['pid'=>$categoryInfo['pid']])->order('id asc')->select();
			  array_push($selfCates,$selfCate);
			  array_push($categoryInfos,$categoryInfo);
			  $ids = Db::name('GoodsCateRelationships')->where(['cate_id'=>$categoryInfo['id']])->column('goods_id');
	          array_push($goods_cate_ids,$ids);
			}
		}
		$filterInfos=array();
		$goods_filter_ids=array();
		if(!empty($filters)){
			foreach($filters as $value){
				$map_filter['slug'] = $value;
				$filterInfo = Db::name('GoodsFilter')->where($map_filter)->find();
				if($filterInfo){
					$ids = Db::name('GoodsFilterRelationships')->where(['filter_id'=>$filterInfo['id']])->column('goods_id');
					array_push($goods_filter_ids,$ids);
					array_push($filterInfos,$filterInfo);
				}
			}
		}
		$ids_result=array();
		if(count($goods_cate_ids)>1){
			$ids_result=array_pop($goods_cate_ids);
			foreach($goods_cate_ids as $value){
				$ids_result=array_intersect($ids_result, $value);
			}
		}else{
			$ids_result=array_pop($goods_cate_ids);
		}
		if(!empty($goods_filter_ids)){
			foreach($goods_filter_ids as $value){
				$ids_result=array_intersect($ids_result, $value);
			}
		}
		if($ids_result){
            $where['id'] = ['in',$ids_result];
            $where['status'] = 1;
			if($search){
				$where['name']=['like','%'.$search.'%'];
			}
            //当前分类下的数据
            $list = Db::name('Goods')->where($where)->alias('a')->join('view_goods_and_cates b','a.id=b.goods_id')->order($order)->paginate($categoryInfo['page_num']?$categoryInfo['page_num']:10,false,[
                'query'    => ['category'=>$str_category,'filter'=>$str_filter,'search'=>$search,'type'=>$type,'sort'=>$sort],
            ]);

            // 获取分页显示
            $page = $list->render();
        }else{
            $list = "";
            $page = "";
        }
        $this->assign('categoryInfos',$categoryInfos);
		$this->assign('category',$str_category);
		$this->assign('filterInfos',$filterInfos);
		$this->assign('filter',$str_filter);
		$this->assign('search',$search);
        $this->assign('list',$list);
        $this->assign('selfCates',$selfCates);
        $this->assign('page',$page);
        $this->assign('sort',$sort);
        $this->assign('type',$type);
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
        //总评论数
        $map['status'] =1;
        $map['goods_id'] = $id;
        $total_comment = Db::name('GoodsComment')->where($map)->count();
        //获取评论列表
        $comment = Db::name('GoodsComment')->where($map)->paginate(10);
        if($total_comment==0){
            $average = 0;
            $this->assign('star_1',0);
            $this->assign('star_2',0);
            $this->assign('star_3',0);
            $this->assign('star_4',0);
            $this->assign('star_5',0);
        }else{
            $star_1 = Db::name('GoodsComment')->where($map)->where(['score'=>1])->count();
            $star_2 = Db::name('GoodsComment')->where($map)->where(['score'=>2])->count();
            $star_3 = Db::name('GoodsComment')->where($map)->where(['score'=>3])->count();
            $star_4 = Db::name('GoodsComment')->where($map)->where(['score'=>4])->count();
            $star_5 = Db::name('GoodsComment')->where($map)->where(['score'=>5])->count();
            $average = ($star_5*5+$star_4*4+$star_3*3+$star_2*2+$star_1)/$total_comment;
            $average = ceil($average);
            $this->assign('star_1',round(($star_1/$total_comment)*100 ,2));
            $this->assign('star_2',round(($star_2/$total_comment)*100 ,2));
            $this->assign('star_3',round(($star_3/$total_comment)*100 ,2));
            $this->assign('star_4',round(($star_4/$total_comment)*100 ,2));
            $this->assign('star_5',round(($star_5/$total_comment)*100 ,2));
        }

        $this->assign('data',$data);
        $this->assign('categoryInfo',$categoryInfo);
        $this->assign('comment',$comment);
        $this->assign('total_comment',$total_comment);
        $this->assign('average',$average);
        $this->assign('page',$comment->render());
		$this->assign('exchange_rate',get_exchange_rate());
        return $this->themeFetch($categoryInfo['detail_tpl']);
    }

    //收藏
    public function Collection(){
        $id     = input('post.id');
        $num    = (int)input('post.num');
        $uid = session('index_user_auth.uid');
        $info = Db::name('GoodsCollection')->where(['goods_id'=>$id,'uid'=>$uid])->find();
        if($info){
            if(Db::name('GoodsCollection')->where(['id'=>$info['id']])->delete()){
                $num--;
                $num = $num<0?0:$num;
                return $this->success('取消收藏成功','',['img'=>'collectionone.png','num'=>$num]);
               
            }else{
                return $this->error('取消收藏失败');
            }
        }else{
            if(Db::name('GoodsCollection')->insert(['uid'=>$uid,'goods_id'=>$id,'createtime'=>time()])){
                $num++;
                return $this->success('收藏成功','',['img'=>'collection_big.png','num'=>$num]);
                
            }else{
                return $this->success('收藏失败');
            }
        }
        
    }

    /**
     * 弹窗登录
     * @return [type] [description]
     */
    public function layerLogin(){
        if(Request::instance()->isPost()) {

        }else{
            return $this->themeFetch('layer_login');
        }
    }
}
