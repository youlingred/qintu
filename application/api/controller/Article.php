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
 * 文章控制器
 * @author  tangtanglove <dai_hang_love@126.com>
 */
class Article extends Base
{
    /**
    * 文章列表控制器
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
        // 条件
        $where['a.status'] = 'publish';
        $where['a.type']   = 'post';
        if (!empty($category)) {
            if (!is_numeric($category)) {
                // 读取数据
                $catid = Db::name('TermTaxonomy')
                ->alias('a')
                ->join('terms b','b.id= a.term_id','LEFT')
                ->where(['b.slug'=>$category])
                ->value('a.id');
                if (empty($catid)) {
                    return $this->error('分类不存在！');
                }
            } else {
                $catid = $category;
            }
            $children = model('Category')->getAllChildrenId($catid);
            if (!empty($children)) {
                //如果有子分类
                //分割分类
                $children = explode(',', $children);
                //将当前分类的文章和子分类的文章混合到一起
                $cates = $children;
                //合并分类
                array_push($cates, $catid);
                //组合条件
                $where['b.term_taxonomy_id'] = array('in',$cates);
            }else{
                $where['b.term_taxonomy_id'] = array('eq',$catid);
            }
        }
        $list = Db::name('Posts')
    	->alias('a')
    	->join('term_relationships b','b.object_id = a.id','LEFT')
        ->where($where)
        ->order('id desc')
        ->page($page,$num)
        ->field('a.*')
        ->select();

        foreach ($list as $key => $value) {
            // 获取封面列表
            $coverList=select_key_value('posts.cover',$value['uuid']);
            if(!empty($coverList)) {
                foreach ($coverList as $coverKey => $coverValue) {
                    $list[$key][$coverKey] = str_replace('/uploads', 'http://'.$_SERVER['HTTP_HOST'].__ROOT__.'/uploads', $coverValue);
                }
            }
            // 获取扩展字段
            $formList=select_key_value('posts.form',$value['uuid']);
            if(!empty($formList)) {
                    $list[$key]['form'] = $formList;
            }
            $list[$key]['createtime'] = date('Y-m-d H:i:s',$value['createtime']);
            $list[$key]['updatetime'] = date('Y-m-d H:i:s',$value['updatetime']);
        }

        if(!empty($list)) {
            return $this->restSuccess('获取成功！',$list);
        } else {
            return $this->restError('没有数据了！');
        }
    }

    /**
    * 文章详情控制器
    * @author  tangtanglove <dai_hang_love@126.com>
    */
    public function detail_get_json()
    {
        $id = input('id');
        if (empty($id)) {
            return $this->error('参数错误');
        }
        // 读取数据
        $postInfo = Db::name('Posts')->where(['id'=>$id,'status'=>'publish','type'=>'post'])->find();
        if (empty($postInfo)) {
            return $this->restError('内容不存在！');
        }
        // 获取封面列表
        $coverList=select_key_value('posts.cover',$postInfo['uuid']);
        if(!empty($coverList)) {
            foreach ($coverList as $coverKey => $coverValue) {
                $postInfo[$coverKey] = str_replace('/uploads', 'http://'.$_SERVER['HTTP_HOST'].__ROOT__.'/uploads', $coverValue);
            }
        }
        //$postInfo['createtime'] = date('Y-m-d H:i:s',$postInfo['createtime']);
        $postInfo['updatetime'] = date('Y-m-d H:i:s',$postInfo['updatetime']);
        return $this->restSuccess('获取成功！',wap_detail_adapter($postInfo));
    }

    /**
    * 单页详情控制器
    * @author  tangtanglove <dai_hang_love@126.com>
    */
    public function page_get_json()
    {
        $id = input('id');
        if (empty($id)) {
            return $this->error('参数错误');
        }
        // 读取数据
        $postInfo = Db::name('Posts')->where(['id'=>$id,'status'=>'publish','type'=>'page'])->find();
        if (empty($postInfo)) {
            return $this->restError('内容不存在！');
        }
        // 获取封面列表
        $coverList=select_key_value('posts.cover',$postInfo['uuid']);
        if(!empty($coverList)) {
            foreach ($coverList as $coverKey => $coverValue) {
                $postInfo['cover_path_'.$coverKey+1] = str_replace('/uploads', 'http://'.$_SERVER['HTTP_HOST'].__ROOT__.'/uploads', $coverValue['cover_path_'.$coverKey+1]);
            }
        }
        return $this->restSuccess('获取成功！',wap_detail_adapter($postInfo));
    }

    /**
    * 单页子分类页面控制器
    * @author  tangtanglove <dai_hang_love@126.com>
    */
    public function pageChildrenCate_get_json()
    {
        $pname = input('pname',0);
        if(!empty($pname)) {
            $pid = Db::name('Posts')->where(['name'=>$pname,'status'=>'publish','type'=>'page'])->value('id');
        } else {
            $pid = input('pid',0);
        }

        // 读取数据
        $lists = Db::name('Posts')->where(['pid'=>$pid,'status'=>'publish','type'=>'page'])->select();
        if (empty($lists)) {
            return $this->restError('内容不存在！');
        }

        foreach ($lists as $key => $value) {
            $lists[$key] = wap_detail_adapter($value);
        }

        return $this->restSuccess('获取成功！',$lists);
    }

    /**
    * 单页同级分类页面控制器
    * @author  tangtanglove <dai_hang_love@126.com>
    */
    public function pageSameCate_get_json()
    {
        $name = input('name',0);
        if(!empty($name)) {
            $pid = Db::name('Posts')->where(['name'=>$name,'status'=>'publish','type'=>'page'])->value('pid');
        }

        // 读取数据
        $lists = Db::name('Posts')->where(['pid'=>$pid,'status'=>'publish','type'=>'page'])->select();
        if (empty($lists)) {
            return $this->restError('内容不存在！');
        }

        foreach ($lists as $key => $value) {
            $lists[$key] = wap_detail_adapter($value);
        }

        return $this->restSuccess('获取成功！',$lists);
    }

}
