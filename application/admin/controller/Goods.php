<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: tangtanglove <dai_hang_love@126.com> <http://www.ixiaoquan.com>
// +----------------------------------------------------------------------

namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\Loader;
use think\Request;
use common\builder\Form;

/**
 * 商品管理控制器
 * @author  tangtanglove <dai_hang_love@126.com>
 */
class Goods extends Common
{
    /**
     * 商品列表
     * @author tangtanglove
     */
    public function index()
    {
        // 搜索词
        $q = input('q');
        if (!empty($q)) {
            $map['a.name'] = ['like','%'.mb_convert_encoding($q, "UTF-8", "auto").'%'];
        }
        // 筛选文章状态
        $status = input('status');
		$is_best = intval(input('is_best'));
		$is_hot = intval(input('is_hot'));
        if (!empty($status)) {
            $map['a.status'] = $status;
        }
		if ($is_best>0) {
            $map['a.is_best'] = $is_best;
        }
		if ($is_hot>0) {
            $map['a.is_hot'] = $is_hot;
        }
        // 筛选文章分类
        $category = input('category');
        if (!empty($category)) {
            $map['b.cate_id'] = $category;
        }
        // 为空赋值
        if(empty($map)) {
            $map = 1;
        }
        // 商品列表
        $goodsList = Db::name('Goods')
        ->alias('a')
        ->join('goods_cate_relationships b','b.goods_id= a.id','LEFT')
        ->join('goods_cate c','c.id= b.cate_id','LEFT')
        ->where($map)
        ->distinct(true)
        ->order('a.createtime desc')
        ->field('a.*,c.name as catename')
        ->paginate(10);

        // 列表数据
        $goodsCateList = Db::name('GoodsCate')->select();
        // 列表数据转换成树
        $goodsCateTree = list_to_tree($goodsCateList);
        // 输出赋值

        $this->assign('status',$status);
		$this->assign('is_best',$is_best);
		$this->assign('is_hot',$is_hot);
        $this->assign('category',$category);
        $this->assign('goodsCateTree',$goodsCateTree);
        $this->assign('goodsList',$goodsList);

        return $this->fetch();
    }

    /**
     * 添加商品
     * @author tangtanglove
     */
    public function goodsadd()
    {
        if (Request::instance()->isPost()) {
            // 接收post数据
            $sort			= input('post.sort');// 排序
            $name           = input('post.name');// 文章名称
            $description    = input('post.description');// 描述
            $categoryIds    = input('post.category_ids/a');// 分类id,数组可为多个
            $filterIds    	= input('post.filter_ids/a');// 筛选id,数组可为多个
            $content        = input('post.content');// 文章内容
            $coverPath      = input('post.cover_path');
            $photo_path_1   = input('post.photo_path_1');
            $photo_path_2   = input('post.photo_path_2');
            $photo_path_3   = input('post.photo_path_3');
            $clickCount     = input('post.click_count');// 商品点击数
            $isBest         = input('post.is_best');// 是否为精品
            $isNew          = input('post.is_new');// 是否为新品
            $isHot          = input('post.is_hot');// 是否为热销
            $num            = input('post.num');// 库存数量
            $sellNum        = input('post.sell_num');// 已经出售的数量
            $price          = input('post.price');// 是否为热销
            $share_master_id= input('post.share_master_id');// 分享主ID
            $share_child_id = input('post.share_child_id');// 分享子ID
           	$discover 		= input('post.discover');// 发现内容
            $standard       = input('post.standard');// 规格型号
            $score          = input('post.score');// 酒精度
            $label_tese     = input('post.label_tese');// 特色标签
            $label_quan     = input('post.label_quan');// 券代标签
            $label_match_1  = input('post.label_match_1');// 地区+类型匹配
            $label_area     = input('post.label_area');// 地区匹配
            $man_profiles   = input('post.man_profiles');// 个人简介
            $goods_profiles = input('post.goods_profiles');// 体验简介

            if($price<=0) {
                return $this->error('请输入正确的价格！');
            }

            if (empty($categoryIds)) {
                return $this->error('请选择分类！');
            }
            $data['name']           = $name;
            $data['uid']            = UID;
            $data['uuid']           = create_uuid();
			$data['sort']           = $sort;
            $data['description']    = $description;
            $data['content']        = $content;
            $data['cover_path']     = $coverPath;
            $data['photo_path_1']   = $photo_path_1;
            $data['photo_path_2']   = $photo_path_2;
            $data['photo_path_3']   = $photo_path_3;
            $data['click_count']    = $clickCount;
            $data['is_best']        = $isBest;
            $data['is_new']         = $isNew;
            $data['is_hot']         = $isHot;
            $data['num']            = $num;
            $data['sell_num']       = $sellNum;
            $data['price']          = $price;
            $data['share_master_id']= $share_master_id;
            $data['share_child_id'] = $share_child_id;
            $data['discover'] 		= $discover;
            $data['standard']       = $standard;
            $data['score']          = $score;
            $data['createtime']     = time();
			$data['label_tese']     = $label_tese;
			$data['label_quan']     = $label_quan;
			$data['label_match_1']  = $label_match_1;
			$data['label_area']     = $label_area;
			$data['man_profiles']   = $man_profiles;
			$data['goods_profiles'] = $goods_profiles;

            // 添加数据
            $goodsid = $this->update($data);
            if ($goodsid) {
                // 遍历加入数据
                foreach ($categoryIds as $key => $value) {
                    // 添加文章-分类表
                    $GoodsCateRelationshipsStatus = Db::name('GoodsCateRelationships')->insert(['goods_id' => $goodsid,'cate_id' => $value]);
                    if (!$GoodsCateRelationshipsStatus) {
                        return $this->error('发布失败！');
                    }
                }
				if (!empty($filterIds)) {
					foreach ($filterIds as $key => $value) {
	                    // 添加文章-分类表
	                    $GoodsFilterRelationshipsStatus = Db::name('GoodsFilterRelationships')->insert(['goods_id' => $goodsid,'filter_id' => $value]);
	                    if (!$GoodsFilterRelationshipsStatus) {
	                        return $this->error('发布失败！');
	                    }
	                }
				}
                return $this->success('发布成功！',url('index'));
            } else {
                return $this->error('发布失败！');
            }
        } else {
            // 列表数据
            $goodsCateList = Db::name('GoodsCate')->select();
            // 列表数据转换成树
            $goodsCateTree = list_to_tree($goodsCateList);
			 // 列表数据
            $goodsFilterList = Db::name('GoodsFilter')->select();
            // 列表数据转换成树
            $goodsFilterTree = list_to_tree($goodsFilterList);
            // 输出赋值
            $this->assign('goodsCateTree',$goodsCateTree);
			$this->assign('goodsFilterTree',$goodsFilterTree);
            return $this->fetch();
        }
    }

    /**
     * 编辑商品
     * @author tangtanglove
     */
    public function goodsedit()
    {
        if (Request::instance()->isPost()) {
            // 接收post数据
            $id             = input('post.id');
			$sort			= input('post.sort');// 排序
            $name           = input('post.name');// 文章名称
            $description    = input('post.description');// 描述
            $categoryIds    = input('post.category_ids/a');// 分类id,数组可为多个
            $filterIds    	= input('post.filter_ids/a');// 筛选id,数组可为多个
            $content        = input('post.content');// 文章内容
            $coverPath      = input('post.cover_path');
            $photo_path_1   = input('post.photo_path_1');
            $photo_path_2   = input('post.photo_path_2');
            $photo_path_3   = input('post.photo_path_3');
            $clickCount     = input('post.click_count');// 商品点击数
            $isBest         = input('post.is_best');// 是否为精品
            $isNew          = input('post.is_new');// 是否为新品
            $isHot          = input('post.is_hot');// 是否为热销
            $num            = input('post.num');// 库存数量
            $sellNum        = input('post.sell_num');// 已经出售的数量
            $price          = input('post.price');// 是否为热销
            $share_master_id= input('post.share_master_id');// 分享主ID
            $share_child_id = input('post.share_child_id');// 分享子ID
            $discover 		= input('post.discover');// 发现内容
            $standard       = input('post.standard');// 规格型号
            $score          = input('post.score');// 赠送积分
            $label_tese     = input('post.label_tese');// 特色标签
            $label_quan     = input('post.label_quan');// 券代标签
            $label_match_1  = input('post.label_match_1');// 地区+类型匹配
            $label_area     = input('post.label_area');// 地区匹配
            $man_profiles   = input('post.man_profiles');// 个人简介
            $goods_profiles = input('post.goods_profiles');// 体验简介

            if($price<=0) {
                return $this->error('请输入正确的价格！');
            }

            if (empty($categoryIds)) {
                return $this->error('请选择分类！');
            }
			if (empty($label_area)) {
                return $this->error('请填入地区匹配！');
            }

            $data['name']           = $name;
            $data['uid']            = UID;
            $data['uuid']           = create_uuid();
			$data['sort']           = $sort;
            $data['description']    = $description;
            $data['content']        = $content;
            $data['cover_path']     = $coverPath;
            $data['photo_path_1']   = $photo_path_1;
            $data['photo_path_2']   = $photo_path_2;
            $data['photo_path_3']   = $photo_path_3;
            $data['click_count']    = $clickCount;
            $data['is_best']        = $isBest;
            $data['is_new']         = $isNew;
            $data['is_hot']         = $isHot;
            $data['num']            = $num;
            $data['sell_num']       = $sellNum;
            $data['price']          = $price;
            $data['share_master_id']= $share_master_id;
            $data['share_child_id'] = $share_child_id;
            $data['discover'] 		= $discover;
            $data['standard']       = $standard;
            $data['score']          = $score;
            $data['createtime']     = time();
			$data['label_tese']     = $label_tese;
			$data['label_quan']     = $label_quan;
			$data['label_match_1']  = $label_match_1;
			$data['label_area']     = $label_area;
			$data['man_profiles']   = $man_profiles;
			$data['goods_profiles'] = $goods_profiles;
            // 添加数据
            $goodsid = $this->update($data,['id'=>$id]);
            if ($goodsid) {
                // 清除历史分类
                Db::name('GoodsCateRelationships')->where(['goods_id' => $goodsid])->delete();
                // 遍历加入数据
                foreach ($categoryIds as $key => $value) {
                    // 添加文章-分类表
                    // 添加文章-分类表
                    $GoodsCateRelationshipsStatus = Db::name('GoodsCateRelationships')->insert(['goods_id' => $goodsid,'cate_id' => $value]);
                    if (!$GoodsCateRelationshipsStatus) {
                        return $this->error('编辑失败！');
                    }
                }
				// 清除历史标签
				Db::name('GoodsFilterRelationships')->where(['goods_id' => $goodsid])->delete();
                // 遍历加入数据
                if (!empty($filterIds)) {
	                foreach ($filterIds as $key => $value) {
	                    // 添加文章-分类表
	                    // 添加文章-分类表
	                    $GoodsFilterRelationshipsStatus = Db::name('GoodsFilterRelationships')->insert(['goods_id' => $goodsid,'filter_id' => $value]);
	                    if (!$GoodsFilterRelationshipsStatus) {
	                        return $this->error('编辑失败！');
	                    }
	                }
				}
                return $this->success('编辑成功！',url('index'));
            } else {
                return $this->error('编辑失败！');
            }
        } else {
            // 更新数据
            $id = input('id');
            if (empty($id)) {
                return $this->error('请选择数据！');
            }
            // 文章信息
            $goodsInfo        = Db::name('Goods')->where('id',$id)->find();
            // 分类选中
            $categoryList     = Db::name('GoodsCateRelationships')->where('goods_id',$id)->select();
            // 列表数据
            $goodsCateList = Db::name('GoodsCate')->select();
            // 列表数据转换成树
            $goodsCateTree = list_to_tree($goodsCateList);
			// 筛选选中
            $filterList     = Db::name('GoodsFilterRelationships')->where('goods_id',$id)->select();
            // 列表数据
            $goodsFilterList = Db::name('GoodsFilter')->select();
            // 列表数据转换成树
            $goodsFilterTree = list_to_tree($goodsFilterList);
            // 输出赋值
            $this->assign('goodsInfo',$goodsInfo);
            $this->assign('categoryList',$categoryList);
            $this->assign('goodsCateTree',$goodsCateTree);
			$this->assign('filterList',$filterList);
            $this->assign('goodsFilterTree',$goodsFilterTree);
            return $this->fetch();
        }
    }

    /**
     * 更新文章
     * @author tangtanglove
     */
    private function update($data,$map = '')
    {
        if (empty($map)) {
            // 新增数据
            $goodsStatus = Db::name('Goods')->insert($data);
            // 执行成功，返回文章id
            return $goodsStatus ? Db::getLastInsID() : false;
        } else {
            // 更新数据
            $goodsStatus = Db::name('Goods')->where($map)->update($data);
            // 执行成功，返回文章id
            return $goodsStatus ? $map['id'] : false;
        }
    }

    /**
     * 设置文章状态
     * @author tangtanglove
     */
    public function setstatus()
    {
        $status  = input('status');
        $goodsids = input('ids/a');
		switch ($status){
			case 'delete':
				// 清空Goods表
            	$goodsResult = Db::name('Goods')->where('id','in',implode(',', $goodsids))->delete();
			break;
			case 'best':
				$goodsResult = Db::name('Goods')->where('id','in',implode(',', $goodsids))->update(['is_best' => '1']);
			break;
			case 'nobest':
				$goodsResult = Db::name('Goods')->where('id','in',implode(',', $goodsids))->update(['is_best' => '0']);
			break;
			case 'hot':
				$goodsResult = Db::name('Goods')->where('id','in',implode(',', $goodsids))->update(['is_hot' => '1']);
			break;
			case 'nohot':
				$goodsResult = Db::name('Goods')->where('id','in',implode(',', $goodsids))->update(['is_hot' => '0']);
			break;
			default:
				$goodsResult = Db::name('Goods')->where('id','in',implode(',', $goodsids))->update(['status' => $status]);
			break;
		}
        if ($goodsResult) {
            return $this->success('操作成功！');
        } else {
            return $this->error('操作失败！');
        }
    }

    /**
     * 产品分类
     * @author tangtanglove
     */
    public function category()
    {
    	$name = input('name');
    	if (!empty($name)) {
    		$map['b.name'] = ['like','%'.mb_convert_encoding($name, "UTF-8", "auto").'%'];
    	} else {
    		$map = 1;
    	}
    	// 列表数据
    	$goodsCateList = Db::name('GoodsCate')
    	->where($map)
    	->select();
    	// 列表数据转换成树
		$goodsCateTree 		= list_to_tree($goodsCateList);
    	// Select列表数据
    	$goodsCateSelectList = Db::name('GoodsCate')
    	->select();
    	// Select列表数据转换成树
		$goodsCateSelectTree = list_to_tree($goodsCateSelectList);
		// 输出赋值
    	$this->assign('goodsCateList',$goodsCateList);
    	$this->assign('goodsCateTree',$goodsCateTree);
    	$this->assign('goodsCateSelectTree',$goodsCateSelectTree);
        return $this->fetch();
    }

    /**
     * 产品分类
     * @author tangtanglove
     */
    public function categoryEdit()
    {
        if (Request::instance()->isPost()) {
			// 接收post数据
			$data = input('');
            // 更新或添加数据
			if (!empty($data['id'])) {
				if ($data['id'] === $data['pid']) {
					return $this->error('不可将自己节点设为父节点！');
				}
				// 更新数据
				$goodsCateResult = Db::name('GoodsCate')
				->where(['id'=>$data['id']])
				->update([
                    'name' => $data['name'], 
                    'slug' => $data['slug'],
                    'cover_path' => $data['cover_path'],
                    'pid'  => $data['pid'],
                    'page_num'=>$data['page_num'],
                    'lists_tpl'=>$data['lists_tpl'],
                    'detail_tpl'=>$data['detail_tpl']
                ]);

				// ajax返回
				if (false !== $goodsCateResult) {
					return $this->success('操作成功！');
				} else {
					return $this->error('操作失败！');
				}
			} else {
	            // 添加数据
				$goodsCateStatus = Db::name('GoodsCate')->insert([
                    'name' => $data['name'], 
                    'slug' => $data['slug'],
                    'cover_path' => $data['cover_path'],
                    'pid'  => $data['pid'],
                    'page_num'=>$data['page_num'],
                    'lists_tpl'=>$data['lists_tpl'],
                    'detail_tpl'=>$data['detail_tpl']
                    ]);
				// ajax返回
				if ($goodsCateStatus) {
					return $this->success('操作成功！');
				} else {
					return $this->error('操作失败！');
				}
			}
        } else {
			$id = input('id');
			if (!empty($id)) {
				$goodsCateInfo 		= Db::name('GoodsCate')->where('id',$id)->find();
				$goodsCateList 		= Db::name('GoodsCate')->select();
				$goodsCateTree		= list_to_tree($goodsCateList);
				$this->assign([
					'goodsCateInfo' => $goodsCateInfo,
					'goodsCateTree' => $goodsCateTree,
					]);
			}

        	return $this->fetch();
        }

    }

    /**
     * 设置文章状态
     * @author tangtanglove
     */
    public function categorySetstatus()
    {
        $status  = input('post.status');
        $categoryids = input('post.ids/a');
        if ($status == 'delete') {
            // 清空Goods表
            $categoryResult = Db::name('GoodsCate')->where('id','in',implode(',', $categoryids))->delete();
        } else {
            $categoryResult = Db::name('GoodsCate')->where('id','in',implode(',', $categoryids))->update(['status' => $status]);
        }

        if ($categoryResult) {
            return $this->success('操作成功！');
        } else {
            return $this->error('操作失败！');
        }
    }
	/**
     * 筛选标签
     * @author xiehui
     */
    public function filter()
    {
    	$name = input('name');
    	if (!empty($name)) {
    		$map['b.name'] = ['like','%'.mb_convert_encoding($name, "UTF-8", "auto").'%'];
    	} else {
    		$map = 1;
    	}
    	// 列表数据
    	$goodsFilterList = Db::name('GoodsFilter')
    	->where($map)
    	->select();
    	// 列表数据转换成树
		$goodsFilterTree 		= list_to_tree($goodsFilterList);
    	// Select列表数据
    	$goodsFilterSelectList = Db::name('GoodsFilter')
    	->select();
    	// Select列表数据转换成树
		$goodsFilterSelectTree = list_to_tree($goodsFilterSelectList);
		// 输出赋值
    	$this->assign('goodsFilterList',$goodsFilterList);
    	$this->assign('goodsFilterTree',$goodsFilterTree);
    	$this->assign('goodsFilterSelectTree',$goodsFilterSelectTree);
        return $this->fetch();
    }
	/**
     * 筛选标签编辑
     * @author xiehui
     */
	 public function filterEdit()
    {
        if (Request::instance()->isPost()) {
			// 接收post数据
			$data = input('');
            // 更新或添加数据
			if (!empty($data['id'])) {
				if ($data['id'] === $data['pid']) {
					return $this->error('不可将自己节点设为父节点！');
				}
				// 更新数据
				$goodsFilterResult = Db::name('GoodsFilter')
				->where(['id'=>$data['id']])
				->update([
                    'name' => $data['name'], 
                    'slug' => $data['slug'],
                    'pid'  => $data['pid']
                ]);

				// ajax返回
				if (false !== $goodsFilterResult) {
					return $this->success('操作成功！');
				} else {
					return $this->error('操作失败！');
				}
			} else {
	            // 添加数据
				$goodsFilterStatus = Db::name('GoodsFilter')->insert([
                    'name' => $data['name'], 
                    'slug' => $data['slug'],
                    'pid'  => $data['pid']
                    ]);
				// ajax返回
				if ($goodsFilterStatus) {
					return $this->success('操作成功！');
				} else {
					return $this->error('操作失败！');
				}
			}
        } else {
			$id = input('id');
			if (!empty($id)) {
				$goodsFilterInfo 		= Db::name('GoodsFilter')->where('id',$id)->find();
				$goodsFilterList 		= Db::name('GoodsFilter')->select();
				$goodsFilterTree		= list_to_tree($goodsFilterList);
				$this->assign([
					'goodsFilterInfo' => $goodsFilterInfo,
					'goodsFilterTree' => $goodsFilterTree,
					]);
			}

        	return $this->fetch();
        }

    }
    /**
     * 设置筛选标签状态
     * @author xiehui
     */
    public function filterSetstatus()
    {
        $status  = input('post.status');
        $filterids = input('post.ids/a');
        if ($status == 'delete') {
            // 清空Goods表
            $filterResult = Db::name('GoodsFilter')->where('id','in',implode(',', $filterids))->delete();
        } else {
            $filterResult = Db::name('GoodsFilter')->where('id','in',implode(',', $filterids))->update(['status' => $status]);
        }

        if ($filterResult) {
            return $this->success('操作成功！');
        } else {
            return $this->error('操作失败！');
        }
    }
}
