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
 * MiniShop标签库解析类
 * @author  tangtnglove <dai_hang_love@126.com>
 */
class MiniShop extends Taglib
{
    // 标签定义
    protected $tags = [
        // 标签定义： attr 属性列表 close 是否闭合（0 或者1 默认1） alias 标签别名 level 嵌套层次
        'template'  =>  ['attr' => 'file,theme', 'close' => 0], // 前台模板标签
        'nav'       =>  ['attr' => 'field,name', 'close' => 1], // 获取导航
        'banner'    =>  ['attr' => 'field,pos,name', 'close' => 1], // 前台banner
        'link'      =>  ['attr' => 'field,name', 'close' => 1], // 前台友情链接
    ];

    /**
     * 加载前台模板
     * 格式：<template file="Content/footer.php" theme="主题"/>
     * @staticvar array $_templateParseCache
     * @param type $attr file，theme
     * @param type $content
     * @return string|array 返回模板解析后的内容
     */
    public function tagTemplate($tag, $content) {
        $theme = config('theme_name');
        $templateFile = './'.config('theme_dir').'/'.$theme.'/'.$tag['file'];
        //判断模板是否存在
        if (!is_file($templateFile)) {
            return '模板不存在：'.$templateFile;
        }
        //读取内容
        $tmplContent = file_get_contents($templateFile);
        //解析模板
        $this->tpl->parse($tmplContent);
        return $tmplContent;
    }

    /**
     * 导航列表
     * @author  tangtnglove <dai_hang_love@126.com>
     */
    public function tagNav($tag, $content) {
        $field     = empty($tag['field']) ? 'true' : $tag['field'];
        $tree      = empty($tag['tree'])? false : true;
        $parseStr  = $parseStr   = '<?php ';
        $parseStr .= '$__NAV__ = db(\'navigation\')->field('.$field.')->where("hide",0)->order("sort")->select();';
        if($tree){
            $parseStr .= '$__NAV__ = list_to_tree($__NAV__, "id", "pid", "_");';
        }
        $parseStr .= '?>{volist name="__NAV__" id="'. $tag['name'] .'"}';
        $parseStr .= $content;
        $parseStr .= '{/volist}';
        //解析模板
        $this->tpl->parse($parseStr);
        return $parseStr;
    }

    /**
     * banner注意：需要安装广告位插件
     * 格式：<banner name="vo" pos="6" >{$vo.title}</banner> 
     * @param type $attr name，pos
     * @param type $content
     * @return string|array 返回模板解析后的内容
     */
    public function tagBanner($tag, $content){
        
        $pos       = empty($tag['pos']) ? 'true' : $tag['pos'];        
        $parseStr  = $parseStr   = '<?php ';       
        $parseStr .= '$__BANNER__ = db("banner")
        ->alias("a")
        ->join("banner_position b","b.id= a.position","LEFT")        
        ->where("a.status",1)->where("a.position",'.$pos.')
        ->order("a.createtime")->select();';
        $parseStr .= '?>{foreach name="__BANNER__" id="'. $tag['name'] .'"}';
        $parseStr .= $content;
        $parseStr .= '{/foreach}';
        //解析模板
        $this->tpl->parse($parseStr);
        return $parseStr;
    }

    /**
     * link注意：需要安装友情链接插件
     * 格式：<link name="vo"  >{$vo.title}</link> 
     * @param type $attr name
     * @param type $content
     * @return string|array 返回模板解析后的内容
     */
    public function tagLink($tag, $content) {
        $field     = empty($tag['field']) ? 'true' : $tag['field'];        
        $parseStr  = $parseStr   = '<?php ';
        $parseStr .= '$__LINK__ = db(\'links\')->field('.$field.')->where("visible","Y")->order("createtime")->select();';
       
        $parseStr .= '?>{volist name="__LINK__" id="'. $tag['name'] .'"}';
        $parseStr .= $content;
        $parseStr .= '{/volist}';
        //解析模板
        $this->tpl->parse($parseStr);
        return $parseStr;
    }
}
