<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: tangtanglove <dai_hang_love@126.com> <http://www.ixiaoquan.com>
// +----------------------------------------------------------------------

use think\Db;

/**
 * 主题公共库文件
 * 主要定义系统公共函数库，为防止重名所有方法前加theme_前缀
 */
function theme_demo()
{
    
}

/**
 * 首页产品列表
 * @author tangtanglove
 */
function theme_get_product_list($cateid)
{
    // 读取数据
    $subcates = Db::name('GoodsCate')->where(['pid'=>$cateid])->column('id');
    $list = Db::name('GoodsCateRelationships')
    ->alias('a')
    ->join('goods b','b.id= a.goods_id','LEFT')
    ->field('b.*,a.cate_id as category')
    ->where('a.cate_id','in',implode(',', $subcates))
    ->where('b.status','1')
    ->order("id desc")
    ->limit(6)
    ->select();
    $str = '';
    foreach ($list as $key => $value) {

        if(empty($value['cover_path'])) {
            $value['cover_path'] = config('theme_path').'/index/images/irc_defaut.png';
        } else {
            $value['cover_path'] = __ROOT__.$value['cover_path'];
        }

        $str = $str."<div class='col-md-4'><div class='product-item'><span id='line0'><a href='"
        .url('index/goods/detail','id='.$value['id']).
        "'><img class='img' width='100%' height='167' src='"
        .$value['cover_path'].
        "'></a></span><span id='line1'><span class='price'>￥"
        .$value['price'];
        if(!empty($value['score'])){
            $str .= " / 赠积分".$value['score'];
        }
        $str.="</span><span class='title'>"
        .$value['name'].
        "</span></span><span id='line2'><span class='standard'>规格："
        .$value['standard'].
        "</span><a id='more' class='more-off' href='"
        .url('index/goods/detail','id='.$value['id']).
        "'></a></span><div style='clear:both;'></div></div></div>";
    }
    return $str;
}