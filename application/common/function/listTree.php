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
 * 系统公共库文件
 * 主要定义系统公共函数库
 */

/**
* 对查询结果集进行排序
* @access public
* @param array $list 查询结果
* @param string $field 排序的字段名
* @param array $sortby 排序类型
* asc正向排序 desc逆向排序 nat自然排序
* @return array
*/
function list_sort_by($list,$field, $sortby='asc') {
   if(is_array($list)){
       $refer = $resultSet = array();
       foreach ($list as $i => $data)
           $refer[$i] = &$data[$field];
       switch ($sortby) {
           case 'asc': // 正向排序
                asort($refer);
                break;
           case 'desc':// 逆向排序
                arsort($refer);
                break;
           case 'nat': // 自然排序
                natcasesort($refer);
                break;
       }
       foreach ( $refer as $key=> $val)
           $resultSet[] = &$list[$key];
       return $resultSet;
   }
   return false;
}

/**
 * 把返回的数据集转换成Tree
 * @param array $list 要转换的数据集
 * @param string $pid parent标记字段
 * @param string $level level标记字段
 * @return array
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function list_to_tree($list, $pk='id', $pid = 'pid', $child = '_child', $root = 0) {
    // 创建Tree
    $tree = array();
    if(is_array($list)) {
        // 创建基于主键的数组引用
        $refer = array();
        foreach ($list as $key => $data) {
            $refer[$data[$pk]] =& $list[$key];
        }
        foreach ($list as $key => $data) {
            // 判断是否存在parent
            $parentId =  $data[$pid];
            if ($root == $parentId) {
                $tree[] =& $list[$key];
            }else{
                if (isset($refer[$parentId])) {
                    $parent =& $refer[$parentId];
                    $parent[$child][] =& $list[$key];
                }
            }
        }
    }
    return $tree;
}

/**
 * 将list_to_tree的树还原成列表
 * @param  array $tree  原来的树
 * @param  string $child 孩子节点的键
 * @param  string $order 排序显示的键，一般是主键 升序排列
 * @param  array  $list  过渡用的中间数组，
 * @return array        返回排过序的列表数组
 * @author yangweijie <yangweijiester@gmail.com>
 */
function tree_to_list($tree, $child = '_child', $order='id', &$list = array()){

    if(is_array($tree)) {
        foreach ($tree as $key => $value) {
            $reffer = $value;
            if(isset($reffer[$child])){
                unset($reffer[$child]);
                tree_to_list($value[$child], $child, $order, $list);
            }
            $list[] = $reffer;
        }
        $list = list_sort_by($list, $order, $sortby='asc');
    }
    return $list;
}

/**
 * tree转换为select
 * @author  tangtanglove
 */
function tree_to_select($list,$level = 0,$repeat = "&nbsp;&nbsp;")
{
    $data = '';
    foreach ($list as $key => $value) {
        $data = $data."<option value='".$value['id']."'>".str_repeat($repeat, $level).get_termsinfo($value['term_id'])."</option>";
        if (!empty($value['_child'])) {
            $data = $data.tree_to_select($value['_child'],$level+1);
        }
    }
    return $data;
}

/**
 * tree转换为checkbox
 * @author  tangtanglove
 */
function tree_to_checkbox($list,$level = 0,$repeat = "&nbsp;&nbsp;&nbsp;&nbsp;")
{
    $data = '';
    foreach ($list as $key => $value) {
        $data = $data."<div class='checkbox'>".str_repeat($repeat, $level)."<label><input type='checkbox'  name='category_ids[]' value='".$value['id']."'>".$value['name']."</label></div>";
        if (!empty($value['_child'])) {
            $data = $data.tree_to_checkbox($value['_child'],$level+1);
        }
    }
    return $data;
}
function tree_to_checkbox_filter($list,$level = 0,$repeat = "&nbsp;&nbsp;&nbsp;&nbsp;")
{
    $data = '';
    foreach ($list as $key => $value) {
        $data = $data."<div class='checkbox'>".str_repeat($repeat, $level)."<label><input type='checkbox'  name='filter_ids[]' value='".$value['id']."'>".$value['name']."</label></div>";
        if (!empty($value['_child'])) {
            $data = $data.tree_to_checkbox_filter($value['_child'],$level+1);
        }
    }
    return $data;
}
/**
 * tree转换为view
 * @author  tangtanglove
 */
function tree_to_view($list,$level = 0,$repeat = "—&nbsp;")
{
    $data = '';
    foreach ($list as $key => $value) {
        $data = $data."<tr><td><input type='checkbox'  name='ids' ".get_checkbox_status($value['id'])." value='".$value['id']."'></td><td>".$value['id']."</td><td><a href='".url('edit',['id'=>$value['term_id']])."'>".str_repeat($repeat, $level).$value['name']."</a></td><td>".$value['slug']."</td><td>".$value['count']."</td></tr>";
        if (!empty($value['_child'])) {
            $data = $data.tree_to_view($value['_child'],$level+1);
        }
    }
    return $data;
}

/**
 * 获取checkbox是否可选
 * @author  tangtanglove
 */
function get_checkbox_status($id)
{
    $hasChild = Db::name('TermTaxonomy')->where(['pid'=>$id])->find();
    if ($hasChild) {
        return 'disabled';
    } else {
        return "class='categoryCheck'";
    }
}

/**
 * tree转换为menu_view
 * @author  tangtanglove
 */
function tree_to_menu_view($list,$level = 0,$repeat = "—&nbsp;")
{
    $data = '';
    foreach ($list as $key => $value) {
        $value['hide'] ? $hide = '是' : $hide = '否';
        $data = $data."<tr><td><input type='checkbox'  name='ids' ".get_checkbox_menu_status($value['id'])." value='".$value['id']."'></td><td><a href='".url('edit',['id'=>$value['id']])."'>".str_repeat($repeat, $level).$value['name']."</a></td><td>".$value['url']."</td><td>".$value['icon']."</td><td>".$value['sort']."</td><td>".$hide."</td></tr>";
        if (!empty($value['_child'])) {
            $data = $data.tree_to_menu_view($value['_child'],$level+1);
        }
    }
    return $data;
}

/**
 * 获取checkbox_menu是否可选
 * @author  tangtanglove
 */
function get_checkbox_menu_status($id)
{
    $hasChild = Db::name('Menu')->where(['pid'=>$id])->find();
    if ($hasChild) {
        return 'disabled';
    } else {
        return "class='menuCheck'";
    }
}

/**
 * tree转换为menu_select
 * @author  tangtanglove
 */
function tree_to_menu_select($list,$level = 0,$repeat = "&nbsp;&nbsp;")
{
    $data = '';
    foreach ($list as $key => $value) {
        $data = $data."<option value='".$value['id']."'>".str_repeat($repeat, $level).$value['name']."</option>";
        if (!empty($value['_child'])) {
            $data = $data.tree_to_menu_select($value['_child'],$level+1);
        }
    }
    return $data;
}


/**
 * tree转换为nav_view
 * @author  tangtanglove
 */
function tree_to_nav_view($list,$level = 0,$repeat = "—&nbsp;")
{
    $data = '';
    foreach ($list as $key => $value) {
        $value['hide'] ? $hide = '是' : $hide = '否';
        $data = $data."<tr><td><input type='checkbox'  name='ids' ".get_checkbox_nav_status($value['id'])." value='".$value['id']."'></td><td><a href='".url('edit',['id'=>$value['id']])."'>".str_repeat($repeat, $level).$value['name']."</a></td><td>".$value['url']."</td><td>".$value['icon']."</td><td>".$value['sort']."</td><td>".$hide."</td></tr>";
        if (!empty($value['_child'])) {
            $data = $data.tree_to_nav_view($value['_child'],$level+1);
        }
    }
    return $data;
}

/**
 * 获取checkbox_nav是否可选
 * @author  tangtanglove
 */
function get_checkbox_nav_status($id)
{
    $hasChild = Db::name('Navigation')->where(['pid'=>$id])->find();
    if ($hasChild) {
        return 'disabled';
    } else {
        return "class='menuCheck'";
    }
}

/**
 * tree转换为nav_select
 * @author  tangtanglove
 */
function tree_to_nav_select($list,$level = 0,$repeat = "&nbsp;&nbsp;")
{
    $data = '';
    foreach ($list as $key => $value) {
        $data = $data."<option value='".$value['id']."'>".str_repeat($repeat, $level).$value['name']."</option>";
        if (!empty($value['_child'])) {
            $data = $data.tree_to_nav_select($value['_child'],$level+1);
        }
    }
    return $data;
}

/**
 * 获取checkbox是否可选
 * @author  tangtanglove
 */
function get_checkbox_page_status($id)
{
    $hasChild = Db::name('Posts')->where(['pid'=>$id])->find();
    if ($hasChild) {
        return 'disabled';
    } else {
        return "class='categoryCheck'";
    }
}

/**
 * tree转换为page_view
 * @author  tangtanglove
 */
function tree_to_page_view($list,$level = 0,$repeat = "—&nbsp;")
{
    $data = '';
    foreach ($list as $key => $value) {
        $url = url('page/setstatus?ids='.$value['id'].'&status=delete');
        $data = $data."<tr><td><input type='checkbox'  name='ids' ".get_checkbox_page_status($value['id'])." value='".$value['id']."'></td><td><a href='".url('edit',['id'=>$value['id']])."'>".str_repeat($repeat, $level).$value['title']."</a></td><td>".$value['name']."</td><td>".get_userinfo($value['uid'],'username')."</td><td>".date('Y-m-d H:i:s',$value['createtime'])."</td><td><a type='button' class='btn btn-danger ajax-get confirm' href=".$url.">删除</a></td></tr>";
        if (!empty($value['_child'])) {
            $data = $data.tree_to_page_view($value['_child'],$level+1);
        }
    }
    return $data;
}

/**
 * tree转换为page_select
 * @author  tangtanglove
 */
function tree_to_page_select($list,$level = 0,$repeat = "&nbsp;&nbsp;")
{
    $data = '';
    foreach ($list as $key => $value) {
        $data = $data."<option value='".$value['id']."'>".str_repeat($repeat, $level).$value['title']."</option>";
        if (!empty($value['_child'])) {
            $data = $data.tree_to_page_select($value['_child'],$level+1);
        }
    }
    return $data;
}

/**
 * tree转换为position_select
 * @author  完美°ぜ界丶
 */
function tree_to_pos_select($list,$level = 0,$repeat = "&nbsp;&nbsp;")
{
    $data = '';
    foreach ($list as $key => $value) {
        $data = $data."<option value='".$value['id']."'>".$value['title']."</option>";
       
    }
    return $data;
}


/**
 * 返回权限是否被选中
 * @author vaey
 * @param  [type]  $id [description]
 * @return boolean     [description]
 */
function is_checked($id,$rules)
{
    $rules = explode(',',$rules);
    if(is_array($rules)){
        if(in_array($id,$rules)){
            return "checked";
        }else{
            return "";
        }
    }else{
        return "";
    }
}

/**
 * tree转换为auth_view
 * @author  vaey
 */
function tree_to_auth_access($list,$rules,$level = 0,$repeat = "&nbsp;&nbsp;&nbsp;&nbsp;")
{
    $data = '';
    if($level>=2){
        $data = '<dd>';
    }
    foreach ($list as $key => $value) {
        if($level>=2){
            $data = $data.str_repeat($repeat, $level)."<label><input type='checkbox' name='ids' value='".$value['id']."'" .is_checked($value['id'],$rules)."> ".$value['name']."</label>";
            if (!empty($value['_child'])) {
                $data = $data.tree_to_auth_access($value['_child'],$rules,$level+1);
            }
        }else{
            if($level == 0){
                $str = "<dd class='dd1'>";
            }else{
                $str = "<dd>";
            }
            $data = $data.$str.str_repeat($repeat, $level)."<label><input type='checkbox' name='ids' value='".$value['id']."'" .is_checked($value['id'],$rules)."> ".$value['name']."</label></dd>";
            if (!empty($value['_child'])) {
                $data = $data.tree_to_auth_access($value['_child'],$rules,$level+1);
            }
        }
    }
    if($level>=2){
        return $data.'</dd>';
    }else{
        return $data;
    }
}

/**
 * 根据用户id获取所有信息(用户组下展示用户使用)
 * @author vaey
 * @param  [type] $user [description]
 * @return [type]       [description]
 */
function form_id_to_user($user)
{
    $str = "";
    if($user){
        foreach ($user as $v) {
            $data = Db::name('Users')->where('id',$v['uid'])->find();
            $str = $str.'<tr><td ><input type="checkbox" name="ids" class="check" value="'.$data['id'].'" /></td><td>'.$data['id'].'</td><td>'.$data['username'].'</td><td>'.$data['nickname'].'</td><td>'.$data['email'].'</td><td>'.$data['mobile'].'</a></td><td>'.get_user_status($data['status']).'</td></tr>';
        }
    }
    return $str;
}

/**
 * tree转换为checkbox(分类访问权限使用)
 * @author  vaey
 */
function tree_to_auth_category($list,$rules,$level = 0,$repeat = "&nbsp;&nbsp;&nbsp;&nbsp;")
{
    $data = '';
    foreach ($list as $value) {
        if($level == 0){
            $str = "<dd class='dd1'>";
        }else{
            $str = "<dd>";
        }
        $data = $data.$str.str_repeat($repeat, $level)."<label><input type='checkbox'  name='ids'" .is_checked($value['id'],$rules). " value='".$value['id']."' > ".$value['name']."</label></dd>";
        if (!empty($value['_child'])) {
            $data = $data.tree_to_auth_category($value['_child'],$rules,$level+1);
        }
    }
    return $data;
}

/**
 * tree转换成微信菜单显示
 * @author  vaey
 * @param  [type]  $list   [description]
 * @param  integer $level  [description]
 * @param  string  $repeat [description]
 * @return [type]          [description]
 */
function tree_to_wx_menu($list,$level = 0,$repeat = "&nbsp;&nbsp;&nbsp;&nbsp;")
{
    $data = '';
    foreach ($list as $key => $value) {
        $data = $data."<tr><td>".str_repeat($repeat, $level)."<span class='editmenu' style='cursor:pointer' data='".$value['id']."'>".$value['name']." —— [ ".get_wx_type($value['type'])." ] —— ".get_wx_action($value)."</span>"."</td></tr>";
        if (!empty($value['_child'])) {
            $data = $data.tree_to_wx_menu($value['_child'],$level+1);
        }
    }
    return $data;
}

//获取微信菜单类别
function get_wx_type($type){
    if($type==1){
        return "链接";
    }else{
        return "消息";
    }
}
//获取微信跳转地址或回复消息
function get_wx_action($v){
    if($v['type']==1){
        return $v['url'];
    }else{
        return $v['msg'];
    }
}
/**
 * tree转换成微信json菜单
 * @param  [type]  $list   [description]
 * @param  integer $level  [description]
 * @param  string  $repeat [description]
 * @return [type]          [description]
 */
function tree_to_json_menu($list,$level = 0)
{   
    if($level==0){
        $data = '{"button":[';
    }else{
        $data = '';
    }
    foreach ($list as $key => $value) {
        // $data = $data."<tr><td>".str_repeat($repeat, $level).$value['name']."</td></tr>";
        if(!empty($value['_child'])){
            $data = $data.'{"name":"'.$value['name'].'","sub_button":[';
            $data = $data.tree_to_json_menu($value['_child'],$level+1);
        }else{
            if($level==1&&$key==(count($list)-1)){
                $data = $data.check_menu_type($value).']},';
            }else{
                $data = $data.check_menu_type($value).',';
            }
        }
    }
    if($level==0){
        $data = substr($data,0,strlen($data)-1); 
        return $data.']}';
    }else{
        return $data;
    }
}


function check_menu_type($value){
    if($value['type']==1){ //跳转
        return '{"type":"view","name":"'.$value['name'].'","url":"'.$value['url'].'"}';
    }else{ //点击回复
        return '{"type":"click","name":"'.$value['name'].'","key":"'.$value['key'].'"}';
    }
}

// 商品相关方法开始

/**
 * 获取checkbox是否可选
 * @author  tangtanglove
 */
function get_checkbox_goods_status($id)
{
    $hasChild = Db::name('GoodsCate')->where(['pid'=>$id])->find();
    if ($hasChild) {
        return 'disabled';
    } else {
        return "class='categoryCheck'";
    }
}

/**
 * tree转换为view
 * @author  tangtanglove
 */
function goods_category_tree_to_view($list,$level = 0,$repeat = "—&nbsp;")
{
    $data = '';
    foreach ($list as $key => $value) {
        if($value['status'] == 1) {
            $status = '正常';
        } else {
            $status = '禁用';
        }
        $data = $data."<tr><td><input type='checkbox'  name='ids' ".get_checkbox_goods_status($value['id'])." value='".$value['id']."'></td><td><a href='".url('categoryEdit',['id'=>$value['id']])."'>".str_repeat($repeat, $level).$value['name']."</a></td><td>".$value['slug']."</td><td>".$status."</td></tr>";
        if (!empty($value['_child'])) {
            $data = $data.goods_category_tree_to_view($value['_child'],$level+1);
        }
    }
    return $data;
}
function goods_filter_tree_to_view($list,$level = 0,$repeat = "—&nbsp;")
{
    $data = '';
    foreach ($list as $key => $value) {
        if($value['status'] == 1) {
            $status = '正常';
        } else {
            $status = '禁用';
        }
        $data = $data."<tr><td><input type='checkbox'  name='ids' ".get_checkbox_goods_status($value['id'])." value='".$value['id']."'></td><td><a href='".url('filterEdit',['id'=>$value['id']])."'>".str_repeat($repeat, $level).$value['name']."</a></td><td>".$value['slug']."</td><td>".$status."</td></tr>";
        if (!empty($value['_child'])) {
            $data = $data.goods_filter_tree_to_view($value['_child'],$level+1);
        }
    }
    return $data;
}      
                  
/**
 * tree转换为select
 * @author  tangtanglove
 */
function goods_category_tree_to_select($list,$level = 0,$repeat = "&nbsp;&nbsp;")
{
    $data = '';
    foreach ($list as $key => $value) {
        $data = $data."<option value='".$value['id']."'>".str_repeat($repeat, $level).$value['name']."</option>";
        if (!empty($value['_child'])) {
            $data = $data.goods_category_tree_to_select($value['_child'],$level+1);
        }
    }
    return $data;
}
