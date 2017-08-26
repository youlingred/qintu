<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: tangtnglove <dai_hang_love@126.com> <http://www.ixiaoquan.com>
// +----------------------------------------------------------------------

namespace common\taglib;

use think\template\TagLib;

/**
 * Article标签库解析类
 * @author  tangtnglove <dai_hang_love@126.com>
 */
class Article extends Taglib
{
    // 标签定义
    protected $tags = [
        // 标签定义： attr 属性列表 close 是否闭合（0 或者1 默认1） alias 标签别名 level 嵌套层次
        'pages'          =>  ['attr' => 'field,map,name', 'close' => 1], // 获取单页列表
        'categorys'      =>  ['attr' => 'field,map,name', 'close' => 1], // 获取分类列表
        'subcateposts'   =>  ['attr' => 'field,cateid,num,name', 'close' => 1], // 获取子分类文章列表
        'cateposts'      =>  ['attr' => 'field,cateid,num,name', 'close' => 1], // 获取分类文章列表
    ];

    /**
     * 获取单页列表
     * @author  tangtnglove <dai_hang_love@126.com>
     */
    public function tagPages($tag, $content) {
        $field     = empty($tag['field']) ? 'true' : $tag['field'];
        $tree      = empty($tag['tree'])? false : true;
        $map       = $tag['map'];
        $parseStr  = $parseStr   = '<?php ';
        $parseStr .= '$__PAGES__ = db(\'posts\')->field('.$field.')->where("'.$map.'")->where(\'type\',\'page\')->order("level")->select();';
        if($tree){
            $parseStr .= '$__PAGES__ = list_to_tree($__PAGES__, "id", "pid", "_");';
        }
        $parseStr .= '?>{volist name="__PAGES__" id="'. $tag['name'] .'"}';
        $parseStr .= $content;
        $parseStr .= '{/volist}';
        //解析模板
        $this->tpl->parse($parseStr);
        return $parseStr;
    }

    /**
     * 获取分类列表
     * @author  tangtanglove <dai_hang_love@126.com>
     */
    public function tagCategorys($tag, $content) {
        $field      = empty($tag['field']) ? 'true' : $tag['field'];
        $tree       = empty($tag['tree'])? false : true;
        $map        = $tag['map'];
        $parseStr   = $parseStr   = '<?php ';
        $parseStr  .= '$__CATEGORY__ = db(\'TermTaxonomy\')->alias(\'a\')->join(\'terms b\',\'b.id= a.term_id\',\'LEFT\')->field(\'a.*,b.name,b.slug\')->where("'.$map.'")->order("id desc")->select();';
        if($tree){
            $parseStr .= '$__CATEGORY__ = list_to_tree($__CATEGORY__, "id", "pid", "_");';
        }
        $parseStr  .= '?>{volist name="__CATEGORY__" id="'. $tag['name'] .'"}';
        $parseStr  .= $content;
        $parseStr  .= '{/volist}';
        //解析模板
        $this->tpl->parse($parseStr);
        return $parseStr;
    }

    /**
     * 获取子分类文章列表
     * @author  tangtnglove <dai_hang_love@126.com>
     */
    public function tagSubcateposts($tag, $content) {
        $field      = empty($tag['field']) ? 'true' : $tag['field'];
        $tree       = empty($tag['tree'])? false : true;
        $cateid     = $tag['cateid'];
        $num        = $tag['num'];
        $subcates   = db('TermTaxonomy')->where(['pid'=>$cateid])->column('id');
        $parseStr   = $parseStr   = '<?php ';
        $parseStr  .= '$__POSTS__ = db(\'TermRelationships\')->alias(\'a\')->join(\'posts b\',\'b.id= a.object_id\',\'LEFT\')->field(\'b.*,a.term_taxonomy_id as category\')->where(\'a.term_taxonomy_id\',\'in\',"'.implode(',', $subcates).'")->where(\'b.status\',\'publish\')->order("id desc")->limit('.$num.')->select();';
        if($tree){
            $parseStr .= '$__POSTS__ = list_to_tree($__POSTS__, "id", "pid", "_");';
        }
        $parseStr  .= '?>{volist name="__POSTS__" id="'. $tag['name'] .'"}';
        $parseStr  .= $content;
        $parseStr  .= '{/volist}';
        //解析模板
        $this->tpl->parse($parseStr);
        return $parseStr;
    }

    /**
     * 获取分类文章列表
     * @author  tangtnglove <dai_hang_love@126.com>
     */
    public function tagCateposts($tag, $content) {
        $field      = empty($tag['field']) ? 'true' : $tag['field'];
        $tree       = empty($tag['tree'])? false : true;
        $cateid     = $tag['cateid'];
        $num        = $tag['num'];
        $parseStr   = $parseStr   = '<?php ';
        $parseStr  .= '$__POSTS__ = db(\'TermRelationships\')->alias(\'a\')->join(\'posts b\',\'b.id= a.object_id\',\'LEFT\')->field(\'b.*,a.term_taxonomy_id as category\')->where(\'a.term_taxonomy_id\',\'in\','.$cateid.')->where(\'b.status\',\'publish\')->order("id desc")->limit('.$num.')->select();';
        if($tree){
            $parseStr .= '$__POSTS__ = list_to_tree($__POSTS__, "id", "pid", "_");';
        }
        $parseStr  .= '?>{volist name="__POSTS__" id="'. $tag['name'] .'"}';
        $parseStr  .= $content;
        $parseStr  .= '{/volist}';
        //解析模板
        $this->tpl->parse($parseStr);
        return $parseStr;
    }
}