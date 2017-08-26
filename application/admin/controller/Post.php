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
 * 文章管理控制器
 * @author  tangtanglove <dai_hang_love@126.com>
 */
class Post extends Common
{
     /**
     * 设置前置操作，检测权限
     * @author vaey 
     */
    protected $beforeActionList = [
        'authAdd'  =>  ['only'=>'add,draft'],
        'authEdit'  =>  ['only'=>'edit'],
    ];
    /**
     * 文章列表
     * @author tangtanglove
     */
    public function index()
    {
        // 搜索词
        $q = input('q');
        if (!empty($q)) {
            $map['a.title'] = ['like','%'.mb_convert_encoding($q, "UTF-8", "auto").'%'];
        }
        // 筛选文章状态
        $status = input('status');
        if (!empty($status)) {
            $map['a.status'] = $status;
        } else {
            $map['a.status'] = ['neq','trash'];
        }
        // 筛选文章分类
        $category = input('category');
        if (!empty($category)) {
            $map['b.term_taxonomy_id'] = $category;
        }
        // 只读取文章
        $map['type'] = 'post';
        // 文章列表
        $postsList = Db::name('Posts')
        ->alias('a')
        ->join('term_relationships b','b.object_id= a.id','LEFT')
        ->where($map)
        ->distinct(true)
        ->order('a.updatetime desc')
        ->field('a.*')
        ->paginate(10);

        // Select列表数据
        $termTaxonomySelectList = Db::name('TermTaxonomy')
        ->alias('a')
        ->join('terms b','b.id= a.term_id','LEFT')
        ->field('a.*,b.name,b.slug')
        ->select();
        // Select列表数据转换成树
        $termTaxonomySelectTree = list_to_tree($termTaxonomySelectList);
        // 把分页数据赋值给模板变量list
        $this->assign('postsList', $postsList);
        // 输出赋值
        $this->assign('status',$status);
        $this->assign('category',$category);
        $this->assign('termTaxonomySelectTree',$termTaxonomySelectTree);
        return $this->fetch();
    }

    /**
     * 添加文章
     * @author tangtanglove
     */
    public function add()
    {
        if (Request::instance()->isPost()) {
            // 接收post数据
            $title          = input('post.title');// 文章标题
            $name           = input('post.name');// 文章别名
           // $description      = input('post.description');// 文章描述
            $categoryIds    = input('post.category_ids/a');// 分类id,数组可为多个
            $content        = input('post.content');// 文章内容
            $coverPath      = input('post.cover_path');

            if (empty($categoryIds)) {
                return $this->error('请选择分类！');
            }
            $data['title']      = $title;
			$data['name']       = $name;
			//$data['description']= $description;
            $data['uid']        = UID;
            $data['uuid']       = create_uuid();
            $data['content']    = $content;
            $data['createtime'] = time();
            $data['updatetime'] = $data['createtime'];
            $data['type']       = 'post';
            $data['status']     = 'publish';
            // 添加数据
            $postid = $this->update($data);
            if ($postid) {
                // 添加keyvalue扩展字段
                $formName = $this->checkBindForm(implode(',',$categoryIds));
                $formBuilder = controller('admin/FormBuilder', 'controller');
                $formBuilder->addPostForm($formName,input('post.'),$data['uuid']); // 跨模块调用
                // 添加封面图
                if ($coverPath) {
                    $coverList = explode(",",$coverPath);
                    foreach ($coverList as $key => $value) {
                        if ($value) {
                            insert_key_value('posts.cover',['cover_path_'.$key=>$value],$data['uuid']);
                        }
                    }
                }
                // 遍历加入数据
                foreach ($categoryIds as $key => $value) {
                    // 添加文章-分类表
                    $TermRelationshipsStatus = Db::name('TermRelationships')->insert(['object_id' => $postid,'term_taxonomy_id' => $value]);
                    //每个分类下多少篇文章进行统计
                    $numPost = Db::name('TermTaxonomy')->where('term_id' ,$value)->setInc('count');
                    if ((!$TermRelationshipsStatus)&&(!$numPost)) {
                        return $this->error('发布失败！');
                    }
                }
                return $this->success('发布成功！',url('index'));
            } else {
                return $this->error('发布失败！');
            }
        } else {
            // 列表数据
            $termTaxonomyList = Db::name('TermTaxonomy')
            ->alias('a')
            ->join('terms b','b.id= a.term_id','LEFT')
            ->field('a.*,b.name,b.slug')
            ->select();
            // 列表数据转换成树
            $termTaxonomyTree = list_to_tree($termTaxonomyList);
            // 输出赋值
            $this->assign('termTaxonomyTree',$termTaxonomyTree);
            return $this->fetch();
        }
    }

    /**
     * 编辑文章
     * @author tangtanglove
     */
    public function edit()
    {
        if (Request::instance()->isPost()) {
            // 接收post数据
            $id             = input('post.id');
            $uuid           = input('post.uuid');
            $title          = input('post.title');// 文章标题
            $name           = input('post.name');// 文章别名
            $description    = input('post.description');// 文章描述
            $categoryIds    = input('post.category_ids/a');// 分类id,数组可为多个
            $content        = input('post.content');// 文章内容
            $coverPath      = input('post.cover_path');

            if (empty($categoryIds)) {
                return $this->error('请选择分类！');
            }
            $data['title']      = $title;
			$data['name']       = $name;
			$data['description']= $description;
            $data['uid']        = UID;
            $data['uuid']       = $uuid;
            $data['content']    = $content;
            $data['updatetime'] = time();
            $data['type']       = 'post';
            $data['status']     = 'publish';
            // 添加数据
            $postid = $this->update($data,['id'=>$id]);
            if ($postid) {
                // 清除扩展字段
                delete_key_value('posts.form',$data['uuid']);
                // 编辑keyvalue扩展字段
                $formName = $this->checkBindForm(implode(',',$categoryIds));
                $formBuilder = controller('admin/FormBuilder', 'controller');
                $formBuilder->addPostForm($formName,input('post.'),$data['uuid']); // 跨模块调用
                // 清除历史封面
                delete_key_value('posts.cover',$data['uuid']);
                // 清除历史分类
                Db::name('TermRelationships')->where(['object_id' => $postid])->delete();
                // 添加封面图
                if ($coverPath) {
                    $coverList = explode(",",$coverPath);
                    foreach ($coverList as $key => $value) {
                        if ($value) {
                            insert_key_value('posts.cover',['cover_path_'.$key=>$value],$data['uuid']);
                        }
                    }
                }
                // 遍历加入数据
                foreach ($categoryIds as $key => $value) {
                    // 添加文章-分类表
                    $termRelationshipsStatus = Db::name('TermRelationships')->insert(['object_id' => $postid,'term_taxonomy_id' => $value]);
                    if (!$termRelationshipsStatus) {
                        return $this->error('编辑失败1！');
                    }
                }
                return $this->success('编辑成功！',url('index'));
            } else {
                return $this->error('编辑失败2！');
            }
        } else {
            // 更新数据
            $id = input('id');
            if (empty($id)) {
                return $this->error('请选择数据！');
            }
            // 文章信息
            $postsInfo        = Db::name('Posts')->where('id',$id)->find();
            // 文章封面图
            $coverList        = select_key_value('posts.cover',$postsInfo['uuid']);
            // 分类选中
            $categoryList     = Db::name('TermRelationships')->where('object_id',$id)->select();
            // 列表数据
            $termTaxonomyList = Db::name('TermTaxonomy')
            ->alias('a')
            ->join('terms b','b.id= a.term_id','LEFT')
            ->field('a.*,b.name,b.slug')
            ->select();
            // 列表数据转换成树
            $termTaxonomyTree = list_to_tree($termTaxonomyList);
            // 输出赋值
            $this->assign('postsInfo',$postsInfo);
            $this->assign('coverList',$coverList);
            $this->assign('categoryList',$categoryList);
            $this->assign('termTaxonomyTree',$termTaxonomyTree);
            return $this->fetch();
        }
    }

    /**
     * 保存草稿
     * @author tangtanglove
     */
    public function draft()
    {
        if (Request::instance()->isPost()) {
            // 接收post数据
            $title          = input('post.title');// 文章标题
            $name           = input('post.name');// 文章别名
            $categoryIds    = input('post.category_ids/a');// 分类id,数组可为多个
            $content        = input('post.content');// 文章内容
            $coverPath      = input('post.cover_path');

            if (empty($categoryIds)) {
                return $this->error('请选择分类！');
            }
            $data['title']      = $title;
			$data['name']       = $name;
            $data['uid']        = UID;
            $data['uuid']       = create_uuid();
            $data['content']    = $content;
            $data['createtime'] = time();
            $data['updatetime'] = $data['createtime'];
            $data['type']       = 'post';
            $data['status']     = 'draft';
            // 添加数据
            $postid = $this->update($data);
            if ($postid) {
                // 添加keyvalue扩展字段
                $formName = $this->checkBindForm(implode(',',$categoryIds));
                $formBuilder = controller('admin/FormBuilder', 'controller');
                $formBuilder->addPostForm($formName,input('post.'),$data['uuid']); // 跨模块调用
                // 添加封面图
                if ($coverPath) {
                    $coverList = explode(",",$coverPath);
                    foreach ($coverList as $key => $value) {
                        if ($value) {
                            insert_key_value('posts.cover',['cover_path_'.$key=>$value],$data['uuid']);
                        }
                    }
                }
                // 遍历加入数据
                foreach ($categoryIds as $key => $value) {
                    // 添加文章-分类表
                    $TermRelationshipsStatus = Db::name('TermRelationships')->insert(['object_id' => $postid,'term_taxonomy_id' => $value]);
                    if (!$TermRelationshipsStatus) {
                        return $this->error('保存草稿失败！');
                    }
                }
                return $this->success('保存成功！');
            } else {
                return $this->error('保存失败！');
            }
        }
    }

    /**
     * 更新文章
     * @author tangtanglove
     */
    private function update($data,$map = '')
    {
        // 实例化验证器
        $validate = Loader::validate('Posts');
        // 验证
        if(!$validate->check($data)){
            return $this->error($validate->getError());
        }
        if (empty($map)) {
            // 新增数据
            $postsStatus = Db::name('Posts')->insert($data);
            // 执行成功，返回文章id
            return $postsStatus ? Db::getLastInsID() : false;
        } else {
            // 更新数据
            $postsStatus = Db::name('Posts')->where($map)->update($data);
            // 执行成功，返回文章id
            return $postsStatus ? $map['id'] : false;
        }
    }

    /**
     * 设置文章状态
	 * pending：待审
	 * draft：草稿
	 * auto-draft：自动保存的草稿
	 * inherit：修订版本
	 * trash：回收站
	 * publish：已发布
	 * future：定时
	 * private：私有
	 * delete：真实删除
     * emptytrash:清空回收站
     * @author tangtanglove
     */
    public function setstatus()
    {
        $status  = input('status');
        $postids = input('ids/a');
        if (!in_array($status,['publish','pending','draft','trash','emptytrash','delete'])) {
            return $this->error('参数错误！');
        }
        if ($status == 'emptytrash') {
            $ids = Db::name('Posts')->where('status','trash')->column('id');
            // 获取uuids
            $uuids = Db::name('Posts')->where('status','trash')->column('uuid');
            if( is_array($ids) ){
                foreach ($ids as $key => $value) {
                    //
                    $value_id = Db::name('TermRelationships')->where('object_id' ,$value)->value('term_taxonomy_id');
                    //对删除文章进行统计
                    $numPost = Db::name('TermTaxonomy')->where('term_id' ,$value_id)->setDec('count');
                }
            }
            // 清空posts表
            $postsResult = Db::name('Posts')->where('id','in',implode(',', $ids))->delete();           
            // 清空TermRelationships表
            Db::name('TermRelationships')->where('object_id','in',implode(',', $ids))->delete();
            // 清空keyvalue表
            Db::name('KeyValue')->where('uuid','in',implode(',', $uuids))->delete();
        }else if($status == 'delete'){
            // $ids = Db::name('Posts')->where('status','trash')->column('id');
            // 获取uuids
            $uuids = Db::name('Posts')->where('id',$postids['0'])->value('uuid');
            $value_id = Db::name('TermRelationships')->where('object_id' ,$postids['0'])->value('term_taxonomy_id');
            //对删除文章进行统计
            $numPost = Db::name('TermTaxonomy')->where('term_id' ,$value_id)->setDec('count');
            // 清空posts表
            $postsResult = Db::name('Posts')->where('id',$postids['0'])->delete();           
            // 清空TermRelationships表
            Db::name('TermRelationships')->where('object_id', $postids['0'])->delete();
            // 清空keyvalue表
            Db::name('KeyValue')->where('uuid', $uuids)->delete();
        }else {
            $postsResult = Db::name('Posts')->where('id','in',implode(',', $postids))->update(['status' => $status]);
        }
        if ($postsResult) {
            return $this->success('操作成功！');
        } else {
            return $this->error('操作失败！');
        }
    }

    /**
     * 获取分类绑定的表单
     * @author tangtanglove
     */
    public function getBindForm()
    {
        $categoryIds = trim(input('categoryIds'),',');
        if(empty($categoryIds)) {
             return '';
        }
        // 检查并返回绑定的表单
        $bingForm = $this->checkBindForm($categoryIds);
        if ($bingForm) {
            return $this->success('获取成功','',$bingForm);
        } else {
            return $this->error('获取表单失败');
        }
    }

    /**
     * 检查分类绑定的表单是否合法
     * @author tangtanglove
     */
    protected function checkBindForm($categoryIds)
    {
        // 获取uuid数组
        $uuidList    = Db::name('TermTaxonomy')->where('id','in',$categoryIds)->field('uuid')->select();
        $bingForm    = '';
        foreach ($uuidList as $key => $value) {
            $data = select_key_value('term.taxonomy',$value['uuid']);
            // 绑定的信息不为空，赋值
            if(!empty($data['bind_form'])) {
                $bingForm = $data['bind_form'];
            }
            if(!empty($bingForm)) {
                if($bingForm != $data['bind_form']) {
                    return $this->error('内容只能属于相同类型的分类！');
                }
            }
        }

        // 返回结果
        return $bingForm;
    }

    /**
     * [authAdd 发布文章和保存草稿权限判断]
     * @author vaey
     * @return [type] [description]
     */
    protected function authAdd()
    {
        if (Request::instance()->isPost()) {
            $categoryIds    = input('post.category_ids/a');// 分类id,数组可为多个
            if (empty($categoryIds)) {
                return $this->error('请选择分类！');
            }
            $this->authAll($categoryIds);

        }
    }

    protected function authEdit()
    {
        //接受文章id
        $id = input('id');
        //根据文章id，查找文章所属分类id
        $category_id = Db::name('TermRelationships')->where('object_id',$id)->value('term_taxonomy_id');
        $this->authAll($category_id);
    }

    protected function authAll($cid)
    {
        //查询当前登录用户的uuid 判断是否是超级管理员
        $uuid           = Db::name('Users')->where('id',UID)->value('uuid');
        $keyValue       = Db::name('KeyValue')->where('uuid',$uuid)->find();
        if($keyValue && $keyValue['value']==1){
            //超级管理员，直接返回
            return true;
        }
        //获取当前登录用户所在的用户组(可以是多组)
        $group          = Db::name('UserGroupAccess')->where('uid',UID)->select();
        if(!$group){
            return $this->error("没有权限");
        }
        //所有权限数组
        $rules_array = [];
        $arr = [];
        foreach ($group as  $v) {
            $rules = Db::name('UserExtend')->where('group_id',$v['group_id'])->value('extend_id');
            if($rules){
                $arr = explode(',',$rules);
            }
            $rules_array = array_merge($rules_array, $arr);  
        }
        //去除重复值
        $rules_array = array_unique($rules_array);
        if(is_array($cid)){
            $flg = true;
            foreach ($cid as $key => $value) {
                if(!in_array($value,$rules_array)){
                    $flg = false;
                    break;
                }
            }
            if(!$flg){
                return $this->error("没有权限");
            }
        }else{
            if(!in_array($cid,$rules_array)){
                return $this->error("没有权限");
            }
        }
            
    }
}


