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

/**
 * 系统分类系统
 * @author  tangtanglove <dai_hang_love@126.com>
 */
class Taxonomy extends Common
{
    /**
     * 分类列表
 	 * @author  tangtanglove <dai_hang_love@126.com>
     */
    public function index()
    {
    	$name = input('name');
    	if (!empty($name)) {
    		$map['b.name'] = ['like','%'.mb_convert_encoding($name, "UTF-8", "auto").'%'];
    	} else {
    		$map = 1;
    	}
    	// 列表数据
    	$termTaxonomyList = Db::name('TermTaxonomy')
    	->alias('a')
    	->join('terms b','b.id= a.term_id','LEFT')
    	->where($map)
    	->field('a.*,b.name,b.slug,b.sort')
    	->order('sort asc')
    	->select();
    	// 列表数据转换成树
		$termTaxonomyTree 		= list_to_tree($termTaxonomyList);
    	// Select列表数据
    	$termTaxonomySelectList = Db::name('TermTaxonomy')
    	->alias('a')
    	->join('terms b','b.id= a.term_id','LEFT')
    	->field('a.*,b.name,b.slug')
    	->order('sort asc')
    	->select();
    	// Select列表数据转换成树
		$termTaxonomySelectTree = list_to_tree($termTaxonomySelectList);
		// 输出赋值
    	$this->assign('termTaxonomyList',$termTaxonomyList);
    	$this->assign('termTaxonomyTree',$termTaxonomyTree);
    	$this->assign('termTaxonomySelectTree',$termTaxonomySelectTree);
        return $this->fetch();
    }

    /**
     * 添加或修改分类
 	 * @author  tangtanglove <dai_hang_love@126.com>
     */
    public function edit()
    {
		if (Request::instance()->isPost()) {
			// 接收post数据
			$data = input('');			
            // 实例化验证器
            $validate = Loader::validate('Taxonomy');
            // 验证
            if(!$validate->check($data)){
                return $this->error($validate->getError());
            }
            
            // 更新或添加数据
			if (!empty($data['id'])) {
				$data['sort'] = (int)$data['sort'];
				if ($data['id'] === $data['pid']) {
					return $this->error('不可将自己节点设为父节点！');
				}
				// 更新数据
				$termsResult = Db::name('Terms')
				->where(['id'=>$data['id']])
				->update(['name' => $data['name'], 'slug' => $data['slug'],'sort' => $data['sort']]);
				// 更新TermTaxonomy表
				$termTaxonomyResult = Db::name('TermTaxonomy')
				->where(['term_id'=>$data['id']])
				->update(['pid' => $data['pid']]);
				// 组合keyvalue数据
				$keyValueData['page_num']	= $data['page_num'];
				$keyValueData['lists_tpl']	= $data['lists_tpl'];
				$keyValueData['detail_tpl']	= $data['detail_tpl'];
				$keyValueData['bind_form']	= $data['bind_form'];
				// 更新key-value表
				$result = update_key_value('term.taxonomy',$keyValueData,$data['uuid']);
				// ajax返回
				if ((false !== $termsResult) && (false !== $termTaxonomyResult) && (false !== $result)) {
					return $this->success('操作成功！' ,url('taxonomy/index'));
				} else {
					return $this->error('操作失败！');
				}
			} else {
	            // 添加数据
				$termsStatus = Db::name('Terms')->insert(['name' => $data['name'], 'slug' => $data['slug']]);
				if ($termsStatus) {
					$uuid = create_uuid();
					Db::name('TermTaxonomy')
					->insert(['term_id' => Db::getLastInsID(), 'uuid' => $uuid, 'taxonomy' => 'category', 'pid' => $data['pid']]);
					// 组合keyvalue数据
					$keyValueData['page_num']	= $data['page_num'];
					$keyValueData['lists_tpl']	= $data['lists_tpl'];
					$keyValueData['detail_tpl']	= $data['detail_tpl'];
					$keyValueData['bind_form']	= $data['bind_form'];
					// 写入keyvalue表
					$result = insert_key_value('term.taxonomy',$keyValueData,$uuid);
				}
				// ajax返回
				if ($result) {
					return $this->success('操作成功！');
				} else {
					return $this->error('操作失败！');
				}
			}

		} else {
			$id = input('id');
			if (!empty($id)) {
				$termsInfo 				= Db::name('Terms')->where('id',$id)->find();
				$termTaxonomyInfo 		= Db::name('TermTaxonomy')->where('term_id',$id)->find();
				$taxonomyKeyValueInfo 	= select_key_value('term.taxonomy',$termTaxonomyInfo['uuid']);
				$termTaxonomyList 		= Db::name('TermTaxonomy')->select();
				$termTaxonomyTree		= list_to_tree($termTaxonomyList);
				$this->assign([
					'termsInfo' 			=> $termsInfo,
					'termTaxonomyInfo' 		=> $termTaxonomyInfo,
					'taxonomyKeyValueInfo' 	=> $taxonomyKeyValueInfo,
					'termTaxonomyTree' 		=> $termTaxonomyTree,
					]);
			}
        	return $this->fetch();
		}
    }

    /**
     * 修改设置状态
 	 * @author  tangtanglove <dai_hang_love@126.com>
     */
    public function setStatus()
    {
		// 更新状态
		$status = input('post.status');
		$checkids = $ids 	= input('post.ids/a');
		if (empty($ids)) {
			return $this->error('请选择数据！');
		}
		if ($status === 'delete') {
	        // 判断该分类下有没有内容
			foreach ($checkids as $key => $value) {
		        $postList = Db::name('TermRelationships')->where(array('term_taxonomy_id'=>$value))->field('object_id')->select();
		        if(!empty($postList)){
		            return $this->error('请先删除分类下的文章（包含回收站）');
		        }
			}
			// 删除key-value键值对
			$keyValueResult 	= 1;
			$termsResult		= 1;
			foreach ($ids as $key => $value) {
				$keyValueStatus = delete_key_value('term.taxonomy',get_uuid('TermTaxonomy',['id' => $value]));
				if ($keyValueStatus == 0) {
					$keyValueResult = 0;
				}
				// 重新获得term_id
				$term_id = Db::name('TermTaxonomy')->where('id',$value)->value('term_id');
				// 删除Terms表
				$termsStatus = Db::name('Terms')->where('id',$term_id)->delete();
				if ($termsStatus == 0) {
					$termsResult = 0;
				}
			}
			// 删除TermTaxonomy表
			$termTaxonomyResult = Db::name('TermTaxonomy')->where('id','in',implode(',', $ids))->delete();
			if ($termsResult && $keyValueResult && $termTaxonomyResult) {
				return $this->success('操作成功！');
			} else {
				return $this->error('操作失败！');
			}
		}
    }

}
