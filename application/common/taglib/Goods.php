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
 * Goods标签库解析类
 * @author  tangtnglove <dai_hang_love@126.com>
 */
class Goods extends Taglib
{
    // 标签定义
    protected $tags = [
        // 标签定义： attr 属性列表 close 是否闭合（0 或者1 默认1） alias 标签别名 level 嵌套层次
        'goodscategorys'      =>  ['attr' => 'field,map,num,name', 'close' => 1], // 获取分类列表
        'subcategoods'        =>  ['attr' => 'field,cateid,num,name', 'close' => 1], // 获取子分类文章列表
        'categoods'           =>  ['attr' => 'field,cateid,num,name', 'close' => 1], // 获取分类文章列表
        'hotgoods'            =>  ['attr' => 'cateid,num,name', 'close' => 1], // 获取热销产品列表
        'newgoods'            =>  ['attr' => 'cateid,num,name', 'close' => 1], // 获取最新产品列表
        'bestgoods'           =>  ['attr' => 'cateid,num,name', 'close' => 1], // 获取精品产品列表
    ];

    /**
     * 获取分类列表
     * @author  tangtanglove <dai_hang_love@126.com>
     */
    public function tagGoodscategorys($tag, $content) {
        $field      = empty($tag['field']) ? 'true' : $tag['field'];
        $tree       = empty($tag['tree'])? false : true;
        $map        = empty($tag['map'])? true : $tag['map'];
        $num        = empty($tag['num'])? 20 : $tag['num'];
        $parseStr   = $parseStr   = '<?php ';
        $parseStr  .= '$__CATEGORY__ = db(\'GoodsCate\')->where("'.$map.'")->limit('.$num.')->order("id desc")->select();';
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
     * 获取子分类商品列表
     * @author  tangtnglove <dai_hang_love@126.com>
     */
    public function tagSubcategoods($tag, $content) {
        $field      = empty($tag['field']) ? 'true' : $tag['field'];
        $tree       = empty($tag['tree'])? false : true;
        $cateid     = $tag['cateid'];
        $num        = $tag['num'];
        $subcates   = db('GoodsCate')->where(['pid'=>$cateid])->column('id');
        $parseStr   = $parseStr   = '<?php ';
        $parseStr  .= '$__GOODS__ = db(\'GoodsCateRelationships\')->alias(\'a\')->join(\'goods b\',\'b.id= a.goods_id\',\'LEFT\')->field(\'b.*,a.cate_id as category\')->where(\'a.cate_id\',\'in\',"'.implode(',', $subcates).'")->where(\'b.status\',\'1\')->order("id desc")->limit('.$num.')->select();';
        if($tree){
            $parseStr .= '$__GOODS__ = list_to_tree($__GOODS__, "id", "pid", "_");';
        }
        $parseStr  .= '?>{volist name="__GOODS__" id="'. $tag['name'] .'"}';
        $parseStr  .= $content;
        $parseStr  .= '{/volist}';
        //解析模板
        $this->tpl->parse($parseStr);
        return $parseStr;
    }

    /**
     * 获取分类商品列表
     * @author  tangtnglove <dai_hang_love@126.com>
     */
    public function tagCategoods($tag, $content) {
        $field      = empty($tag['field']) ? 'true' : $tag['field'];
        $tree       = empty($tag['tree'])? false : true;
        $cateid     = $tag['cateid'];
        $num        = $tag['num'];
        $parseStr   = $parseStr   = '<?php ';
        $parseStr  .= '$__GOODS__ = db(\'GoodsCateRelationships\')->alias(\'a\')->join(\'goods b\',\'b.id= a.goods_id\',\'LEFT\')->field(\'b.*,a.cate_id as category\')->where(\'a.cate_id\',\'in\',"'.$cateid.'")->where(\'b.status\',\'1\')->order("id desc")->limit('.$num.')->select();';
        if($tree){
            $parseStr .= '$__GOODS__ = list_to_tree($__GOODS__, "id", "pid", "_");';
        }
        $parseStr  .= '?>{volist name="__GOODS__" id="'. $tag['name'] .'"}';
        $parseStr  .= $content;
        $parseStr  .= '{/volist}';
        //解析模板
        $this->tpl->parse($parseStr);
        return $parseStr;
    }

    /**
     * 获取热销商品列表
     * @author  tangtnglove <dai_hang_love@126.com>
     */
    public function tagHotgoods($tag, $content) {
        $cateid     = empty($tag['cateid']) ? false : $tag['field'];
        $num        = $tag['num'];
        if ($cateid) {
            $parseStr   = $parseStr   = '<?php ';
            $parseStr  .= '$__GOODS__ = db(\'GoodsCateRelationships\')->alias(\'a\')->join(\'goods b\',\'b.id= a.goods_id\',\'LEFT\')->field(\'b.*,a.cate_id as category\')->where(\'a.cate_id\',\'in\',"'
            .$cateid.
            '")->where(\'b.status\',\'1\')->where(\'b.is_hot\',\'1\')->order("sell_num desc,id desc")->limit('.$num.')->select();';
            $parseStr  .= '?>{volist name="__GOODS__" id="'. $tag['name'] .'"}';
            $parseStr  .= $content;
            $parseStr  .= '{/volist}';
        } else {
            $parseStr   = $parseStr   = '<?php ';
            $parseStr  .= '$__GOODS__ = db(\'GoodsCateRelationships\')->alias(\'a\')->join(\'goods b\',\'b.id= a.goods_id\',\'LEFT\')->field(\'b.*,a.cate_id as category\')->where(\'b.status\',\'1\')->where(\'b.is_hot\',\'1\')->order("sell_num desc,id desc")->limit('.$num.')->select();';
            $parseStr  .= '?>{volist name="__GOODS__" id="'. $tag['name'] .'"}';
            $parseStr  .= $content;
            $parseStr  .= '{/volist}';
        }

        //解析模板
        $this->tpl->parse($parseStr);
        return $parseStr;
    }

    /**
     * 获取精品商品列表
     * @author  tangtnglove <dai_hang_love@126.com>
     */
    public function tagBestgoods($tag, $content) {
        $cateid     = empty($tag['cateid']) ? false : $tag['field'];
        $num        = $tag['num'];
        if ($cateid) {
            $parseStr   = $parseStr   = '<?php ';
            $parseStr  .= '$__GOODS__ = db(\'GoodsCateRelationships\')->alias(\'a\')->join(\'goods b\',\'b.id= a.goods_id\',\'LEFT\')->field(\'b.*,a.cate_id as category\')->where(\'a.cate_id\',\'in\',"'
            .$cateid.
            '")->where(\'b.status\',\'1\')->where(\'b.is_best\',\'1\')->order("sell_num desc,id desc")->limit('.$num.')->select();';
            $parseStr  .= '?>{volist name="__GOODS__" id="'. $tag['name'] .'"}';
            $parseStr  .= $content;
            $parseStr  .= '{/volist}';
        } else {
            $parseStr   = $parseStr   = '<?php ';
            $parseStr  .= '$__GOODS__ = db(\'GoodsCateRelationships\')->alias(\'a\')->join(\'goods b\',\'b.id= a.goods_id\',\'LEFT\')->field(\'b.*,a.cate_id as category\')->where(\'b.status\',\'1\')->where(\'b.is_best\',\'1\')->order("sell_num desc,id desc")->limit('.$num.')->select();';
            $parseStr  .= '?>{volist name="__GOODS__" id="'. $tag['name'] .'"}';
            $parseStr  .= $content;
            $parseStr  .= '{/volist}';
        }

        //解析模板
        $this->tpl->parse($parseStr);
        return $parseStr;
    }


    /**
     * 获取最新商品列表
     * @author  tangtnglove <dai_hang_love@126.com>
     */
    public function tagNewgoods($tag, $content) {
        $cateid     = empty($tag['cateid']) ? false : $tag['field'];
        $num        = $tag['num'];
        if ($cateid) {
            $parseStr   = $parseStr   = '<?php ';
            $parseStr  .= '$__GOODS__ = db(\'GoodsCateRelationships\')->alias(\'a\')->join(\'goods b\',\'b.id= a.goods_id\',\'LEFT\')->field(\'b.*,a.cate_id as category\')->where(\'a.cate_id\',\'in\',"'
            .$cateid.
            '")->where(\'b.status\',\'1\')->where(\'b.is_new\',\'1\')->order("id desc")->limit('.$num.')->select();';
            $parseStr  .= '?>{volist name="__GOODS__" id="'. $tag['name'] .'"}';
            $parseStr  .= $content;
            $parseStr  .= '{/volist}';
        } else {
            $parseStr   = $parseStr   = '<?php ';
            $parseStr  .= '$__GOODS__ = db(\'GoodsCateRelationships\')->alias(\'a\')->join(\'goods b\',\'b.id= a.goods_id\',\'LEFT\')->field(\'b.*,a.cate_id as category\')->where(\'b.status\',\'1\')->where(\'b.is_new\',\'1\')->order("id desc")->limit('.$num.')->select();';
            $parseStr  .= '?>{volist name="__GOODS__" id="'. $tag['name'] .'"}';
            $parseStr  .= $content;
            $parseStr  .= '{/volist}';
        }

        //解析模板
        $this->tpl->parse($parseStr);
        return $parseStr;
    }
}