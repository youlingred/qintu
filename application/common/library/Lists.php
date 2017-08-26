<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: vaey
// +----------------------------------------------------------------------

namespace common\library;

use think\Controller;
use think\Request;

/**
 * 列表控制器
 * @author  vaey
 */
class Lists extends Controller
{

    // 列表头
    protected $header           = "";
    // 列表标题
    protected $title            = "";
    // list列表定义
    protected $list             = "";
    // list列表操作
    protected $operate          = "";
    // list列表操作(底部)
    protected $footer_operate   = "";
    // 定义脚本
    protected $script           = "";
    // 列表底部
    protected $footer           = "";
   

    // list列表属性默认配置
    protected $listConf = [
        'all'             => true,       //是否需要全选属性，默认为true
        'url'             => '',         //跳转地址，默认为空，无跳转
        'arg'             => 'id',       //跳转参数,默认为id(url为空时不起作用)
        'pk'              => 'id',       //主键。(全选时传递的参数)默认为id
        'fun'             => [           //函数配置
                                         //默认为空
        ],         
    ];


    /**
     * 设置列表标题
     * @author vaey
     * @param [type] $title [列表标题]
     */
    public function setListTitle($title)
    {
        $this->title = $title;
        return $this;
    }


    /**
     * 列表解析方法
     * @author vaey
     * @param  array  $listTitle   [列表解析的标题数组]
     * @param  array  $listContent [列表解析的内容数组]
     * @param  array  $array       [列表的配置文件，可选]
     * @param  string $listName    [调用的列表名称，可选]
     * @return [type]              [当前对象]
     * listTitle 参数：
     * [    'nickname'=>'昵称',  // 数据库字段 => 显示名称
     *      'email'=>'邮箱',
     *      'status'=>'状态'
     * ]
     */
    public function parseList($listTitle,$listContent,$array=[],$listName="simpleList")
    {
        if(is_array($array)){
            //合并配置
            $this->listConf = array_merge($this->listConf,$array);
        }
        if(method_exists('Lists',$listName)){
            $list = $this->$listName($listTitle,$listContent,$this->listConf);
        }else{
            $list = $this->simpleList($listTitle,$listContent,$this->listConf);
        }
        $this->list = $list;
        return $this;

    }


    /**
     * 简单列表控制器
     * @author vaey
     */
    public function simpleList($listTitle,$listContent,$config)
    {
        //是否使用函数
        $fun = $config['fun'];
        $funKeys = array_keys($fun);
        
        //标题个数
        $count = count($listTitle); 

        //获取数组的Key，value值
        $arrayKeys = array_keys($listTitle);
        $listTitle = array_values($listTitle);

        $this->assign('count',$count);
        //是否需要单选框
        $this->assign('select_all',$config['all']);
        //列表标题
        $this->assign('listTitle',$listTitle);
        //列表要查询的字段
        $this->assign('arrayKeys',$arrayKeys);
        //配置
        $this->assign('config',$config);
        //主键
        $this->assign('pk',$config['pk']);
        //跳转地址
        $this->assign('url',$config['url']);
        $this->assign('arg',$config['arg']);
        //函数配置
        $this->assign('fun',$fun);
        $this->assign('funKeys',$funKeys);
        //列表内容
        $this->assign('listContent',$listContent);

        return $this->fetch('common@lists/simplelist');
    }


    /**
     * 解析下拉操作
     * @author vaey
     * @param  [type]  $operate            [下拉选项数组参数]
     * @param  [type]  $class              [class属性]
     * @param  boolean $has_footer_operate [是否在底部也显示]
     * @return [type]                      [当前对象]
     * $operate 参数格式：
     *  [         
     *      'start' => '启用',        //下拉项
     *      'forbidden'=>'禁用',      //下拉项
     *  ],
     * 
     */
    public function parseSelect($operate,$class,$has_footer_operate=false)
    {
        //循环个数
        $count = count($operate); 

        //获取数组的Key值
        $operateKeys = array_keys($operate);
        $operateValues = array_values($operate);

        $this->assign('count',$count);
        $this->assign('operateKeys',$operateKeys);
        $this->assign('operateValues',$operateValues);
        $this->assign('class',$class);

        $this->operate = $this->operate.$this->fetch('common@operate/select');
        //底部添加下拉选项框
        if($has_footer_operate){
            $this->footer_operate = $this->footer_operate.$this->fetch('common@operate/select');
        }
        return $this;
    }

    /**
     * [parseButton 解析普通按钮]
     * @author vaey
     * @param  array  $operate [按钮数组参数]
     * @param  [type] $url     [按钮跳转地址]
     * @return [type]          [当前对象]
     * $operate 参数格式：
     * [
     *     'name' => '添加',              //按钮名称
     *     'class'=>['class1','class2'],  //附加class属性，可不填
     * ]
     */
    public function parseButton($operate=[],$url)
    {

        if(is_array($operate['class'])){
            $classes = implode(' ',$operate['class']);
        }else{
            $classes = $operate['class'];
        }
        //普通按钮
        $type = true;
        $this->assign('name',$operate['name']);
        $this->assign('url',$url);
        $this->assign('classes',$classes);
        $this->assign('type',$type);

        $this->operate = $this->operate.$this->fetch('common@operate/button');
        return $this;

    }

    /**
     * [parseFilter 解析筛选按钮]
     * @author vaey
     * @param  array  $operate [筛选按钮数组参数]
     * @param  [type] $class   [筛选按钮自身class属性]
     * @return [type]          [当前对象]
     * $operate 参数格式：
     * [
     *        'name' => '筛选',                   //按钮名称
     *        'class'=>['class1','class2'],       //附加class属性，可不填
     *        'select'=>['select1','select2'],    //关联的下拉框class属性，可关联多个
     * ]
     */
    public function parseFilter($operate=[],$class)
    {

        if(is_array($operate['class'])){
            $classes = implode(' ',$operate['class']);
        }else{
            $classes = $operate['class'];
        }
        //非普通按钮
        $type = false;
        $this->assign('name',$operate['name']);
        $this->assign('class',$class);
        $this->assign('classes',$classes);
        $this->assign('type',$type);

        $this->operate = $this->operate.$this->fetch('common@operate/button');
        //筛选按钮操作的js方法
        $this->script = $this->script.$this->getFilterScript($class,$operate['select']);
        return $this;

    }

    /**
     * [parseApp 解析应用按钮]
     * @author vaey
     * @param  array  $operate [应用按钮数组参数]
     * @param  [type] $class   [应用按钮自身属性]
     * @return [type]          [当前对象]
     * $operate 参数格式：
     * [
     *        'name' => '筛选',                   //按钮名称
     *        'class'=>['class1','class2'],       //附加class属性，可不填
     *        'select'=>['select1','select2'],    //关联的下拉框class属性，可关联多个
     * ]
     */
    public function parseApp($operate=[],$class,$has_footer_operate=false)
    {
        if(is_array($operate['class'])){
            $classes = implode(' ',$operate['class']);
        }else{
            $classes = $operate['class'];
        }
        //非普通按钮
        $type = false;
        $this->assign('name',$operate['name']);
        $this->assign('class',$class);
        $this->assign('classes',$classes);
        $this->assign('type',$type);

        $this->operate = $this->operate.$this->fetch('common@operate/button');
        //底部添加下拉选项框
        if($has_footer_operate){
            $this->footer_operate = $this->footer_operate.$this->fetch('common@operate/button');
        }
        //筛选按钮操作的js方法
        $this->script = $this->script.$this->getAppScript($class,$operate['select']);
        return $this;
    }

    /**
     * [parseSearch 解析搜索]
     * @author vaey
     * @param  [type] $operate    [搜索数组参数]
     * @param  [type] $class      [搜索自身class属性]
     * @return [type]             [当前对象]
     * [
     *       'name' => '搜索用户名',         //搜索占位符
     *       'class'=>['test1','test2'],     //附加class属性，可不填
     * ]
     * 
     */
    public function parseSearch($operate=[],$class)
    {
        if(is_array($operate['class'])){
            $classes = implode(' ',$operate['class']);
        }else{
            $classes = $operate['class'];
        }

        $this->assign('name',$operate['name']);
        $this->assign('class',$class);
        $this->assign('classes',$classes);

        $this->operate = $this->operate.$this->fetch('common@operate/search');
        //筛选按钮操作的js方法
        $this->script = $this->script.$this->getSearchScript($class);

        return $this;
    }


    /**
     * 获取应用操作的js
     * @return [type] [description]
     */
    public function getAppScript($class,$select_class)
    {
        $str = "$('.".$class."').click(function () {";
        $str.= $select_class."= $(this).parent().parent().children().children('.".$select_class."').val();";
        $str.= "var ids = new Array();";
        $map = '"'."[name='ids']:checked".'"';
        $str.= "$(".$map.").each(function(){";
        $str.= "ids.push($(this).val());";
        $str.= "});";
        $str.= "$.ajax({";
        $str.= "cache: true,";
        $str.= "type: 'POST',";
        $str.= "url : '".url($select_class)."',";
        $str.= "data: {status:".$select_class.",ids:ids},";
        $str.= "async: false,";
        $str.= "success: function(data) {";
        $str.= "if (data.code) {";
        $str.= "alert(data.msg);";
        $str.= "setTimeout(function () {";
        $str.= "location.href = data.url;";
        $str.= "}, 1000);";
        $str.= "} else {";
        $str.= "alert(data.msg);";
        $str.= "}},";
        $str.= "error: function(request) {";
        $str.= "alert('页面错误');";
        $str.= "}";
        $str.= "});});";
        return $str;
    }



    /**
     * 获取筛选操作的js
     * @return [type] [description]
     */
    public function getFilterScript($class,$select_class)
    {
        $count = count($select_class);
        $map = "[";
        for ($i=0; $i<$count; $i++) {
            $map.="'".$select_class[$i]."'=>'".$select_class[$i]."_',";
        }
        $map.="]";
        $str = "$('.".$class."').click(function (event) {";
        $str.= "getUrl = '{:url('',".$map.")}';";
        for ($i=0; $i<$count; $i++) {
            $str.= "getUrl = getUrl.replace('".$select_class[$i]."_', $('.".$select_class[$i]."').val());";
        }
        $str.= "location.href = getUrl;";
        $str.="});";
        return $str;
    }

    /**
     * 获取搜索操作的js
     * @param  [type] $class [description]
     * @return [type]        [description]
     */
    public function getSearchScript($class)
    {
        $str = "$('.".$class."').keyup(function (event) {";
        $str.= "if (event.keyCode == '13') {";
        $str.= "getUrl = '".url('',['q'=>'qstring'])."';";
        $str.= "location.href = getUrl.replace('qstring', $('.".$class."').val());";
        $str.= "}";
        $str.= "});"; 
        return $str;
    }

    /**
     * [renderhtml 返回解析后的页面]
     * @author vaey
     * @return [type] [html]
     */
    public function renderhtml()
    {
        //设置列表标题
        $this->assign('title',$this->title);
        //操作方法
        $this->assign('operate',$this->operate);
        $this->header = $this->fetch('common@lists/header');
        //设置底部操作
        $this->assign('footer_operate',$this->footer_operate);
        //设置脚本文件
        $this->assign('script',$this->script);
        $this->footer = $this->fetch('common@lists/footer');
        $html = $this->header.$this->list.$this->footer;
        return $html;
    }

    
}


