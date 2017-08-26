<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: tangtanglove <dai_hang_love@126.com> <http://www.ixiaoquan.com>
// +----------------------------------------------------------------------

namespace app\api\controller;

use think\Db;
use think\Request;
use think\controller\Rest;

/**
 * 商品控制器
 * @author  tangtanglove <dai_hang_love@126.com>
 */
class Goods extends Base
{
    /**
    * 商品列表控制器
    * @author  tangtanglove <dai_hang_love@126.com>
    */
    public function lists_get_json()
    {
        // 当前页码
        $page       = input('page',1);
        // 分页数量
        $num        = input('num',10);
        // 栏目缩略名
        $category   = input('category');
        // 栏目缩略名
        $order      = input('order','id desc');
        // 推荐位
        $position   = input('position');
        // 条件
        $where['a.status'] = 1;

        switch ($position) {
            case 'is_best':
                $where['a.is_best'] = 1;
                break;
            case 'is_new':
                $where['a.is_new'] = 1;
                break;
            case 'is_hot':
                $where['a.is_hot'] = 1;
                break;
            default:
                # code...
                break;
        }

        if (!empty($category)) {
            if (!is_numeric($category)) {
                // 读取数据
                $catid = Db::name('GoodsCate')
                ->where(['slug'=>$category])
                ->value('id');
                if (empty($catid)) {
                    return $this->restError('分类不存在！');
                }
            } else {
                $catid = $category;
            }
            $children = model('GoodsCategory')->getAllChildrenId($catid);
            if (!empty($children)) {
                //如果有子分类
                //分割分类
                $children = explode(',', $children);
                //将当前分类的文章和子分类的文章混合到一起
                $cates = $children;
                //合并分类
                array_push($cates, $catid);
                //组合条件
                $where['b.cate_id'] = array('in',$cates);
            }else{
                $where['b.cate_id'] = array('eq',$catid);
            }
        }
        $list = Db::name('Goods')
    	->alias('a')
    	->join('goods_cate_relationships b','b.goods_id = a.id','LEFT')
        ->where($where)
        ->order($order)
        ->page($page,$num)
        ->field('a.*')
        ->select();

        foreach ($list as $key => $value) {
            $list[$key]['cover_path'] = str_replace('/uploads', 'http://'.$_SERVER['HTTP_HOST'].__ROOT__.'/uploads', $value['cover_path']);
            $list[$key]['photo_path_1'] = str_replace('/uploads', 'http://'.$_SERVER['HTTP_HOST'].__ROOT__.'/uploads', $value['photo_path_1']);
            $list[$key]['photo_path_2'] = str_replace('/uploads', 'http://'.$_SERVER['HTTP_HOST'].__ROOT__.'/uploads', $value['photo_path_2']);
            $list[$key]['photo_path_3'] = str_replace('/uploads', 'http://'.$_SERVER['HTTP_HOST'].__ROOT__.'/uploads', $value['photo_path_3']);
            $list[$key]['createtime'] = date('Y-m-d H:i:s',$value['createtime']);
        }

        if(!empty($list)) {
            return $this->restSuccess('获取成功！',$list);
        } else {
            return $this->restError('没有数据了！');
        }
    }

    /**
    * 商品详情控制器
    * @author  tangtanglove <dai_hang_love@126.com>
    */
    public function detail_get_json()
    {
        $id = input('id');
        if (empty($id)) {
            return $this->restError('参数错误');
        }
        // 读取数据
        $goodsInfo = Db::name('Goods')->where(['id'=>$id,'status'=>1])->find();
        if (empty($goodsInfo)) {
            return $this->restError('商品不存在！');
        }
        $goodsInfo['cover_path'] = str_replace('/uploads', 'http://'.$_SERVER['HTTP_HOST'].__ROOT__.'/uploads', $goodsInfo['cover_path']);
        $goodsInfo['photo_path_1'] = str_replace('/uploads', 'http://'.$_SERVER['HTTP_HOST'].__ROOT__.'/uploads', $goodsInfo['photo_path_1']);
        $goodsInfo['photo_path_2'] = str_replace('/uploads', 'http://'.$_SERVER['HTTP_HOST'].__ROOT__.'/uploads', $goodsInfo['photo_path_2']);
        $goodsInfo['photo_path_3'] = str_replace('/uploads', 'http://'.$_SERVER['HTTP_HOST'].__ROOT__.'/uploads', $goodsInfo['photo_path_3']);

        return $this->restSuccess('获取成功！',wap_detail_adapter($goodsInfo));
    }

    /**
    * 商品分类控制器
    * @author  tangtanglove <dai_hang_love@126.com>
    */
    public function cate_get_json()
    {
        $pid = input('pid',0);
        $list = Db::name('GoodsCate')->where(['pid'=>$pid,'status'=>1])->select();

        foreach ($list as $key => $value) {
            $list[$key]['cover_path'] = str_replace('/uploads', 'http://'.$_SERVER['HTTP_HOST'].__ROOT__.'/uploads', $value['cover_path']);
        }

        if(!empty($list)) {
            return $this->restSuccess('获取成功！',$list);
        } else {
            return $this->restError('没有数据了！');
        }
    }

    /**
    * 商品评论列表
    * @author  tangtanglove <dai_hang_love@126.com>
    */
    public function commentList_get_json()
    {
        $goods_id   = input('goods_id',0);
        $page  = input('page',1);
        $num   = input('num',10);

        $commentLists = Db::name('GoodsComment')
        ->where(['goods_id'=>$goods_id,'status'=>1])
        ->order('id desc')
        ->page($page,$num)
        ->select();

        foreach ($commentLists as $key => $value) {
            $commentLists[$key]['nickname'] = get_userinfo($value['uid'],'nickname');
        }

        if(!empty($commentLists)) {
            return $this->restSuccess('获取成功！',$commentLists);
        } else {
            return $this->restError('没有数据了！');
        }
    }

}
