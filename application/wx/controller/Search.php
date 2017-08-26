<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: tangtanglove <dai_hang_love@126.com> <http://www.ixiaoquan.com>
// +----------------------------------------------------------------------

namespace app\wx\controller;

use think\Controller;
use think\Db;
use think\Request;

/**
 * 搜索控制器
 * @author  tangtnglove <dai_hang_love@126.com>
 */
class Search extends Base
{
	/**
	 * 搜索控制器
	 * @author  tangtnglove <dai_hang_love@126.com>
	 */
    public function index()
    {
        $module = input('get.module');
        $query  = input('get.query');
        switch ($module) {
            case 'posts':
                // 搜索文章
                $category     = input('get.category');
                if (!empty($category)) {
                    // 读取数据
                    if (!is_numeric($category)) {
                        $categoryInfo = Db::name('TermTaxonomy')
                        ->alias('a')
                        ->join('terms b','b.id= a.term_id','LEFT')
                        ->where(['b.slug'=>$category])
                        ->field('a.*,b.name,b.slug')
                        ->find();
                        if (empty($categoryInfo)) {
                            return $this->error('分类不存在！');
                        }
                        $cateid = $categoryInfo['id'];
                    } else {
                        $cateid = $category;
                    }
                    // 子分类
                    $subcates   = Db::name('TermTaxonomy')->where(['pid'=>$cateid])->column('id');
                    if ($subcates) {
                        // 分类条件
                        $map['b.term_taxonomy_id'] = implode(',', $subcates).','.$cateid;
                    } else {
                        // 分类条件
                        $map['b.term_taxonomy_id'] = $categoryInfo['id'];
                    }
                }
                // 条件
                $map['a.type']  = 'post';
                $map['a.title'] = ['like','%'.mb_convert_encoding($query, "UTF-8", "auto").'%'];
                // 文章列表
                $list = Db::name('Posts')
                ->alias('a')
                ->join('term_relationships b','b.object_id= a.id','LEFT')
                ->where($map)
                ->distinct(true)
                ->order('a.createtime desc')
                ->field('a.*,b.term_taxonomy_id as category')
                ->paginate(10);
                break;
            
            default:
                return $this->error('参数错误');
                break;
        }
        // 输出数据
        $this->assign('list',$list);
    	// 输出主题
        return $this->themeFetch('search');
    }
}
