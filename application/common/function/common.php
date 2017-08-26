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
 * 系统根目录
 */
function root_path()
{
    return __ROOT__;
}   

/**
 * 创建盐
 * @author tangtanglove <dai_hang_love@126.com>
 */
function create_salt($length=-6)
{
    return $salt = substr(uniqid(rand()), $length);
}

/**
 * 创建uuid,系统内唯一标识符
 * @author tangtanglove <dai_hang_love@126.com>
 */
function create_uuid()
{
    mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
    $charid = strtolower(md5(uniqid(rand(), true)));
    $hyphen = chr(45);// "-"
    $uuid = substr($charid, 0, 8).$hyphen
            .substr($charid, 8, 4).$hyphen
            .substr($charid,12, 4).$hyphen
            .substr($charid,16, 4).$hyphen
            .substr($charid,20,12);
    return $uuid;
}

/**
 * 获取uuid,系统内唯一标识符
 * @author tangtanglove <dai_hang_love@126.com>
 */
function get_uuid($model,$map)
{
    return Db::name($model)->where($map)->value('uuid');
}

/**
 * minishop md5加密方法
 * @author tangtanglove <dai_hang_love@126.com>
 */
function minishop_md5($string,$salt)
{
	return md5(md5($string).$salt);
}

/**
 * 获取用户信息
 * @author  tangtanglove
 */
function get_userinfo($uid = '',$field = '')
{
    if (empty($uid)) {
        $uid = session('user_auth.uid');
    }
    // 查询用户信息
    $userInfo = Db::name('Users')->where(['id'=>$uid,'status'=>1])->cache(true)->find();
    if ($field) {
        return $userInfo[$field];
    } else {
        return $userInfo;
    }
}

/**
 * 获取分类信息
 * @author  tangtanglove
 */
function get_termsinfo($id = '',$field = 'name')
{
    return Db::name('Terms')->where(['id'=>$id])->cache(false)->value($field);
}
/**
 * 获取商品顶级分类信息
 * @author  边缘
 */
function get_top_cate_info($id = '')
{
    $cate_info = Db::name('goods_cate')->where(['id'=>$id])->cache(false)->find();
	while($cate_info['pid']>0){
		$cate_info=Db::name('goods_cate')->where(['id'=>$cate_info['pid']])->cache(false)->find();
	}
	return $cate_info;
}
/**
 * 根据导航名称获取前端导航信息
 * @author  边缘
 */
function get_nav_info($name = '')
{
    $nav_info = Db::name('navigation')->where(['name'=>$name])->cache(false)->find();
	return $nav_info;
}
/**
 * 获取文章所属分类或tags
 * @author  tangtanglove
 */
function get_posts_terms($postid = '',$type = 'category')
{
    // 列表数据
    $list = Db::name('TermRelationships')
    ->alias('a')
    ->join('term_taxonomy b','b.id = a.term_taxonomy_id','LEFT')
    ->join('terms c','c.id = b.term_id','LEFT')
    ->where(['a.object_id'=>$postid,'b.taxonomy'=>$type])
    ->field('b.id,c.name')
    ->cache(true)
    ->select();
    $text = '';
    if (!empty($list)) {
        foreach ($list as $key => $value) {
            $text = $text.$value['name'].',';
        }
    } else {
        $text = '—';
    }
    return trim($text,',');
}

/**
 * 字符串截取，支持中文和其他编码
 * @static
 * @access public
 * @param string $str 需要转换的字符串
 * @param string $start 开始位置
 * @param string $length 截取长度
 * @param string $charset 编码格式
 * @param string $suffix 截断显示字符
 * @return string
 */
function msubstr($str, $start, $length, $charset="utf-8", $suffix=true) {
    if(function_exists("mb_substr"))
        $slice = mb_substr($str, $start, $length, $charset);
    elseif(function_exists('iconv_substr')) {
        $slice = iconv_substr($str,$start,$length,$charset);
        if(false === $slice) {
            $slice = '';
        }
    }else{
        $re['utf-8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
        $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
        $re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
        $re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
        preg_match_all($re[$charset], $str, $match);
        $slice = join("",array_slice($match[0], $start, $length));
    }
    return $suffix ? $slice.'...' : $slice;
}

/**
 * 获取菜单分类信息
 * @author  tangtanglove
 */
function get_menusinfo($id = '',$field = 'title')
{
    return Db::name('Menu')->where(['id'=>$id])->cache(true)->value($field);
}

/**
 * 获取当前文章状态 'publish','pending','draft','trash'
 * @author  tangtanglove
 */
function get_posts_status($postStatus)
{
    switch ($postStatus) {
        case 'publish':
            $result = '已发布';
            break;
        case 'pending':
            $result = '待审';
            break;
        case 'draft':
            $result = '草稿';
            break;
        case 'trash':
            $result = '回收站';
            break;
        default:
            $result = '无';
            break;
    }
    return $result;
}

/**
 * 获取用户状态 'forbid','start','delete'
 * @author 完美°ぜ界丶
 */
function get_user_status($userStatus)
{
    switch ($userStatus) {
        case '2':
            $result = '禁用';
            break;
        case '1':
            $result = '正常';
            break;
        case '-1':
            $result = '删除';
            break;
        default:
            $result = '无';
            break;
    }
    return $result;
}

/**
 * 获取后台菜单选中状态
 * @author  tangtanglove
 */
function get_menu_navbar_active($menuid)
{
    // 查询信息
    $menuInfo = Db::name('Menu')->where(['id'=>$menuid])->cache(true)->find();
    if (empty($menuInfo['pid'])) {
        // 根节点
        $result = Db::name('Menu')->where(['pid'=>$menuid])->where('instr(\''.$_SERVER['REQUEST_URI'].'\',`url`)>0')->cache(true)->find();
        if ($result) {
            return 'active';
        }
    } else {
        if ($_SERVER['REQUEST_URI'] === url($menuInfo['url'])) {
            return 'active';
        }
    }
}

/**
 * 获取用户组的状态,1正常,-1禁用
 * @param  [int] $status [状态值]
 * @author vaey
 */
function get_group_status($status)
{
    if($status==1){
        return '<span class="label label-success">正常</span>';
    }elseif($status==-1){
        return '<span class="label label-danger">禁用</span>';
    }
}

/**
 * 获取文章单一封面
 * @author tangtanglove
 */
function get_posts_cover($uuid)
{
    // 查询数据
    $map['uuid'] = $uuid;
    $map['name'] = 'cover_path_1';
    $postsCover  = Db::name('KeyValue')->where($map)->value('value');
    if($postsCover){
        return __ROOT__.str_replace('./','/',$postsCover);
    }else{
        $path = config('theme_path').'/index/images/irc_defaut.png';
        return str_replace('./','/',$path);
    }
    
}

//裁剪图片
function resizeImage($im,$maxwidth,$maxheight,$name,$filetype)
{
    $pic_width = imagesx($im);
    $pic_height = imagesy($im);
     
    if(($maxwidth && $pic_width > $maxwidth) || ($maxheight && $pic_height > $maxheight))
    {
        if($maxwidth && $pic_width>$maxwidth)
        {
            $widthratio = $maxwidth/$pic_width;
            $resizewidth_tag = true;
        }
 
        if($maxheight && $pic_height>$maxheight)
        {
            $heightratio = $maxheight/$pic_height;
            $resizeheight_tag = true;
        }
 
        if($resizewidth_tag && $resizeheight_tag)
        {
            if($widthratio<$heightratio)
            $ratio = $widthratio;
            else
            $ratio = $heightratio;
        }
 
        if($resizewidth_tag && !$resizeheight_tag)
        $ratio = $widthratio;
        if($resizeheight_tag && !$resizewidth_tag)
        $ratio = $heightratio;
 
        $newwidth = $pic_width * $ratio;
        $newheight = $pic_height * $ratio;
 
        if(function_exists("imagecopyresampled"))
        {
            $newim = imagecreatetruecolor($newwidth,$newheight);//PHP系统函数
            imagecopyresampled($newim,$im,0,0,0,0,$newwidth,$newheight,$pic_width,$pic_height);//PHP系统函数
        }
        else
        {
            $newim = imagecreate($newwidth,$newheight);
            imagecopyresized($newim,$im,0,0,0,0,$newwidth,$newheight,$pic_width,$pic_height);
        }
     
        $name = $name.$filetype;
        imagejpeg($newim,$name);
        imagedestroy($newim);
    }
    else
    {
       $name = $name.$filetype;
       imagejpeg($im,$name);
    }
}

//获取缩略封面图
function get_thumb($uuid,$width='600',$height='400'){
    $map['uuid'] = $uuid;
    $map['name'] = 'cover_path_1';
    $img  = Db::name('KeyValue')->where($map)->value('value');  
    $img = ".".$img;     
    //截取
    $imgname = substr($img,27,32);
    
    $path = './uploads/thumb/'.$imgname;
    $filetype = substr($img,-4,4);;//图片类型
    
    if(is_file($path.$filetype)){ //存在
        return $path.$filetype;
    }else{ //不存在
        if($filetype=='.jpg'||$filetype=='.JPG'){
            $im = imagecreatefromjpeg($img);//参数是图片的存方路径
        }else if($filetype=='.png'||$filetype=='.PNG'){
            $im = imagecreatefrompng($img);//参数是图片的存方路径
        }else if($filetype=='.gif'||$filetype=='.GIF'){
            $im = imagecreatefromgif($img);//参数是图片的存方路径
        }   
        
        $maxwidth = $width;//设置图片的最大宽度
        $maxheight = $height;//设置图片的最大高度
        $name = $path;//图片的名称，随便取吧
        
        resizeImage($im,$maxwidth,$maxheight,$name,$filetype);//调用裁剪函数
        return $path.$filetype;
    }
}

/**
 * 权限判断，设置菜单对某个用户是否可见
 * @author vaey
 * @param  [type] $ruleId      [当前菜单id]
 * @param  [type] $rules       [权限id组]
 * @return [type]              [description]
 */
function check_menu_auth($ruleId,$rules)
{   
    //权限判断
    if(is_array($rules)){
        if(!in_array($ruleId,$rules)){
            return false;
        }else{
            return true;
        }
    }else{
        if($rules == 1){ //超级管理员，拥有所有权限
            return true;
        }else{
            return false;
        }
    }

}

/**
 * 获取当前用户权限，控制菜单对某个用户是否显示
 * @author vaey
 * @return [type] [description]
 */
function get_menu_auth()
{
    //查询当前登录用户的uuid
    $uuid           = Db::name('Users')->where('id',UID)->value('uuid');
    $keyValue       = Db::name('KeyValue')->where('uuid',$uuid)->find();
    if($keyValue && $keyValue['value']==1){
        //超级管理员，直接返回
        return 1; //拥有所有权限
    }
    //获取当前登录用户所在的用户组(可以是多组)
    $group          = Db::name('UserGroupAccess')->where('uid',UID)->select();
    if(!$group){
        return 2; //没有任何权限
    }
    //所有权限数组
    $rules_array = [];
    $arr = [];
    foreach ($group as  $v) {
        $rules = Db::name('UserGroup')->where('id',$v['group_id'])->where('status',1)->value('rules');
        if($rules){
            $arr = explode(',',$rules);
        }
        $rules_array = array_merge($rules_array, $arr);  
    }
    //去除重复值
    $rules_array = array_unique($rules_array);
    return $rules_array;
}    
	

/**
 * 手机列表页面适配器
 * @author tangtanglove
 */
function wap_list_adapter($data,$showType = 'one_cover')
{
    foreach ($data as $key => $value) {
        $data[$key]['updatetime'] = date('Y-m-d H:i:s',$value['updatetime']);
        $data[$key]['createtime'] = date('Y-m-d H:i:s',$value['createtime']);
        $data[$key]['nickname']   = get_userinfo($value['uid'],'nickname');
        $coverList = select_key_value('posts.cover',$value['uuid']);
        // 获取封面数量
        $coverNum = count($coverList);
        if($coverNum)
        {
            switch ($showType) {
                case 'one_cover':
                    // 单图模式
                    $data[$key]['cover_path_1'] = create_thumb('.'.$coverList['cover_path_1'],'',200,110,3);
                    $data[$key]['cover_path_1'] = str_replace('./', 'http://'.$_SERVER['HTTP_HOST'].__ROOT__.'/', $data[$key]['cover_path_1']);
                    break;
                
                default:
                    // 默认程序自动判断
                    if(3<=$coverNum) {
                        $data[$key]['cover_path_1'] = create_thumb('.'.$coverList['cover_path_1'],'',200,110,3);
                        $data[$key]['cover_path_1'] = str_replace('./', 'http://'.$_SERVER['HTTP_HOST'].__ROOT__.'/', $data[$key]['cover_path_1']);

                        $data[$key]['cover_path_2'] = create_thumb('.'.$coverList['cover_path_2'],'',200,110,3);
                        $data[$key]['cover_path_2'] = str_replace('./', 'http://'.$_SERVER['HTTP_HOST'].__ROOT__.'/', $data[$key]['cover_path_2']);

                        $data[$key]['cover_path_3'] = create_thumb('.'.$coverList['cover_path_3'],'',200,110,3);
                        $data[$key]['cover_path_3'] = str_replace('./', 'http://'.$_SERVER['HTTP_HOST'].__ROOT__.'/', $data[$key]['cover_path_3']);
                    } else {
                        $data[$key]['cover_path_1'] = create_thumb('.'.$coverList['cover_path_1'],'',200,110,3);
                        $data[$key]['cover_path_1'] = str_replace('./', 'http://'.$_SERVER['HTTP_HOST'].__ROOT__.'/', $data[$key]['cover_path_1']);
                    }
                    break;
            }
        }
    }
    return $data;
}

/**
 * 手机详情页面适配器
 * @author tangtanglove
 */
function wap_detail_adapter($data)
{
    $data['createtime'] = date('Y-m-d H:i:s',$data['createtime']);
    //内容图片生成适应手机图片
    $data['content']    = create_mobile_thumb($data['content'],350,'');
    //内容图片加域名
    $data['content']    = replace_image_url($data['content'],'http://'.$_SERVER['HTTP_HOST'].__ROOT__);
    return $data;
}


/**
 * 生成缩略图
 * @author tangtanglove
 * @param string $image_path 图片路径
 * @param string $thumb_path 缩略图路径
 */
function create_thumb($image_path,$thumb_path,$width,$height,$thumb_type = 1)
{
    if (empty($image_path)) {
        $this->error('图片路径不能为空！');
    }

    if (empty($thumb_path)) {
        //如果不定义缩略图路径，则以thumb_+原图片名命名
        $list = explode('/', $image_path);
        $key = count($list)-1;
        //定义缩略图名称
        $thumb_name = 'thumb_'.$list[$key];
        $thumb_path = str_replace($list[$key],'',$image_path).$thumb_name;
    }

    if (is_file($image_path)) {
        //不存在缩略图则创建
        if (!is_file($thumb_path)) {
            import('org.org.Image');
            $image = \org\Image::open($image_path);
            $image->thumb($width, $height,$thumb_type)->save($thumb_path);
        }
        return $thumb_path;
    }else{
        return $image_path;
    }

}

/**
 * 内容图片生成适应手机图片
 * @author tangtanglove
 * @param string $image_path 图片路径
 * @param string $thumb_path 缩略图路径
 */
function create_mobile_thumb($content,$width,$height)
{
    $preg_str = "/<[img|IMG].*?src=[\'|\"](.*?(?:[\.gif|\.jpg|\.png]))[\'|\"].*?[\/]?>/";
    preg_match_all($preg_str,$content,$match);
    foreach ($match[1] as $key => $value) {
        $content_mobile_thumb = create_thumb('.'.$value,'',$width,$height,1);
        $content = str_replace($value,trim($content_mobile_thumb,'.'),$content);
    }
    return $content;
}

/** 
 * 替换内容中的图片 添加域名 
 * @param  string $content 要替换的内容 
 * @param  string $strUrl 内容中图片要加的域名 
 * @return string   
 */  
function replace_image_url($content = null, $strUrl = null) {
    if ($strUrl) {  
        //提取图片路径的src的正则表达式 并把结果存入$matches中    
        preg_match_all("/<img(.*)src=\"([^\"]+)\"[^>]+>/isU",$content,$matches);  
        $img = "";    
        if(!empty($matches)) {    
        //注意，上面的正则表达式说明src的值是放在数组的第三个中    
        $img = $matches[2];    
        }else {    
            $img = "";    
        }  
        if (!empty($img)) {    
            $patterns= array();    
            $replacements = array();    
            foreach($img as $imgItem){
                $final_imgUrl = $strUrl.$imgItem;
                //如果不包含http://则认为为远程图片
                if (!(strpos($imgItem, 'http://') !== false)) {
                    $replacements[] = $final_imgUrl;
                    $img_new = "/".preg_replace("/\//i","\/",$imgItem)."/";
                    $patterns[] = $img_new;
                }
            }    

            //让数组按照key来排序
            ksort($patterns);    
            ksort($replacements);    

            //替换内容    
            $vote_content = preg_replace($patterns, $replacements, $content);  
        
            return $vote_content;  
        }else {  
            return $content;  
        }                     
    } else {  
        return $content;  
    }  
}

/**
 * 订单状态
 */
function get_order_status($order_id)
{
    if(empty($order_id)){
        return false;
    }
    $map['id'] = $order_id;
    $status = Db::name('orders')->where($map)->value('status');
  
    return $status;
}

/**
 * 获取用户订单数量
 * @param  $[status]  [string]  [<订单状态，不填则获取全部订单数量>]
 * @return $[number]  [num]     [<返回该状态的订单数量>]
 */
function get_user_order_num($status=null){
    if (!empty($status)) {
        $map['status'] = $status;
    }else{
        $map['status'] = array('not in',['cancel','delete']);
    }
    $map['uid'] = UID;
    $number = Db::name('Orders')->where($map)->count();
    if($number){
        return $number;
    }else{
        return null;
    }
}

/**
 * 获取用户未评价订单数量 
 * @return $[number]  [num]     [<返回该状态的订单数量>]
 */
function get_user_uncomment_order_num(){
    $map['a.uid']        = UID;
    $map['a.status']     = "completed";
    $map['b.is_comment'] = -1;
    $number = Db::name('Orders')->alias('a')->join('orders_goods b','b.order_id= a.id','LEFT')
                ->where($map)->count();
    if($number){
        return $number;
    }else{
        return null;
    }
}

/**
 * 支付类型
 */
function get_pay_type()
{
    $pay_type = array(
            'alipay' =>'支付宝',
            'wxpay'  =>'微信',
    );
    return $pay_type;
}


/** 
 * 加载接口配置
 * @param  string $name   配置接口名称 
 */
 function load_config(){
    
    $list = Db::name('Apiconfig')->select();
         
    foreach ($list as $key => $value) {
        // config('配置参数','配置值');
        config($value['key'],$value['value']);
    }    
} 


/**
 * 格式化字节大小
 * @param  number $size      字节数
 * @param  string $delimiter 数字和单位分隔符
 * @return string            格式化后的带单位的大小
 */
function format_bytes($size, $delimiter = '') {
    $units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
    for ($i = 0; $size >= 1024 && $i < 5; $i++) $size /= 1024;
    return round($size, 2) . $delimiter . $units[$i];
}

/**
 * 根据自己的分类pid，获取所有同级分类
 * @return [type] [description]
 */
function get_self_category($pid){
    $category = 
    Db::name('TermTaxonomy')
    ->alias('a')
    ->join('terms b','b.id= a.term_id','LEFT')
    ->where('pid',$pid)->select();
    return $category;
}

/**
 * 根据自己的分类pid，获取上级分类
 * @return [type] [description]
 */
function get_parent_category($pid,$item){
    $category = 
    Db::name('TermTaxonomy')
    ->alias('a')
    ->join('terms b','b.id= a.term_id','LEFT')
    ->where('a.id',$pid)->find();
    if($item){
        return $category[$item];
    }else{
        return $category;
    }    
}

//获取上一篇
function get_pre($id,$cid){
    $map['term_taxonomy_id'] = $cid;
    $map['object_id'] = array('lt',$id);
    $data = Db::name('TermRelationships')->where($map)->order('object_id desc')->find();
    if($data){
        $info = Db::name('Posts')->where('id',$data['object_id'])->find();
        if($info){
            $url = url('Article/detail?id='.$info['id'].'&category='.$cid);
            return "<a href='".$url."'>".$info['title']."</a>";
        }else{
            return "没有了!";
        }
    }else{
        return "没有了!";
    }
}
//获取下一篇
function get_next($id,$cid){
    $map['term_taxonomy_id'] = $cid;
    $map['object_id'] = array('gt',$id);
    $data = Db::name('TermRelationships')->where($map)->order('object_id asc')->find();
    if($data){
        $info = Db::name('Posts')->where('id',$data['object_id'])->find();
        if($info){
            $url = url('Article/detail?id='.$info['id'].'&category='.$cid);
            return "<a href='".$url."'>".$info['title']."</a>";
        }else{
            return "没有了!";
        }
    }else{
        return "没有了!";
    }
}

/**
 * 根据自身父id ，获取同级所有page
 * @return [type] [description]
 */
function get_self_page($pid){
    $map['type']    = "page";
    $map['pid']     = $pid;
    $data = Db::name('Posts')->where($map)->order('level asc')->select();
    return $data;
}

/**
 * 获取商品收藏总数
 * @return [type] [description]
 */
function get_collection_count($id){
    if($id){
        $count = Db::name('GoodsCollection')->where(['goods_id'=>$id])->count();
        return $count;
    }else{
        return 0;
    }
    
}

/**
 * 获取当前用户是否收藏了该商品，返回图标
 * @return [type] [description]
 */
function get_collection_ico($id){
    if($id){
        $uid = session('index_user_auth.uid');
        if($uid){
            $info = Db::name('GoodsCollection')->where(['goods_id'=>$id,'uid'=>$uid])->find();
            if($info){
                return 'collection_big.png';
            }else{
                return "collectionone.png";
            }
        }
        return "collectionone.png";
    }else{
        return "collectionone.png";
    }
    
}

/**
 * 获取key_value表中的扩展字段的值
 * @param  string   $uuid      uuid
 * @param  string   $name      字段的名称
 * @return $value   该字段的值
 */
function get_key_value($uuid,$name){
    if(empty($uuid)||empty($name)){
        return false;
    }
    $map['uuid'] = $uuid;
    $map['name'] = $name;
    $value = Db::name('key_value')->where($map)->value('value');
    return $value;
}

/**
 * 将时间转换为时间戳
 * @return int 时间戳
 * @author huajie <banhuajie@163.com>
 */
function getFormatTime($time){
    if(empty($time)){
        return 0;
    }
    return strtotime($time);
}

/**
 * 将时间戳格式化
 * @param int $time
 * @return string 完整的时间显示
 * @author huajie <banhuajie@163.com>
 */
function time_format($time = NULL,$format='Y-m-d H:i'){
    $time = $time === NULL ? NOW_TIME : intval($time);
    return date($format, $time);
}

/**
 * 生成二维码
 * @author tangtanglove
 */
function qrcode($data,$path = '')
{
    import('org.util.phpqrcode.phpqrcode');
    if(empty($data)) {
        return '参数错误';
    }
    if(empty($path)) {
        $path = './uploads/qrcode/qrcode.png';
    }
    \QRcode::png($data, $path ,'L' ,4);
    return $path;
}

/**
 * 获取产品生产基地信息
 * @param   int        $id      基地id
 * @param   string     $field   要获取的数据库字段名,默认为name
 * @return  string     $result  相应数据库字段的值
 * @author  矢志bu渝   <15176659527@163.com>
 */
function get_goods_base_info($id,$field="name"){
    if(empty($id)){
        return false;
    }
    $model = Db::name('source_goodsbase');
    $map['id'] = $id;
    $result = $model->where($map)->find();
    if($result){
        return $result[$field];
    }else{
        return false;
    }
}

/**
 * 获取产品分类信息
 * @param   int        $id      分类id
 * @param   string     $field   要获取的数据库字段名,默认为name
 * @return  string     $result  相应数据库字段的值
 * @author  矢志bu渝   <15176659527@163.com>
 */
function get_goods_cate_info($id,$field="name"){
    if(empty($id)){
        return false;
    }

    $model = Db::name('goods_cate');
    $map['id'] = $id;
    $result = $model->where($map)->find();
    
    if($result){
        return $result[$field];
    }else{
        return false;
    }
}

/**
 * 获取产品加工操作信息
 * @param   int        $id      加工列表id 
 * @return  array      $list    商品的加工操作列表
 * @author  矢志bu渝   <15176659527@163.com>
 */
function get_source_goods_form_list($id){
    if(empty($id)){
        return false;
    }

    $model = Db::name('source_goods_form');
    $map['goods_form_cate_id'] = $id;
    $result = $model->where($map)->select();
    
    if($result){
        return $result;
    }else{
        return false;
    }
}

// 乐丫单独定制解析select里value
function string_to_select($value,$select='')
{
    $arr = explode(",",$value);
    $string = '';
    foreach ($arr as $key => $value) {
        $arr1 = explode(":",$value);
        $selectString = '';
        if(!empty($select)) {
            if($select == $arr1[0]) {
                $selectString = 'selected=\"selected\"';
            }
        }
        $string = $string."<option ".$selectString." value='$arr1[0]'>$arr1[1]</option>";
    }
    return $string;
}

// 乐丫单独定制解析select里value
function string_to_select_index($value,$select='')
{
    $arr = explode(",",$value);    
    $selectString = '';  
    foreach ($arr as $key => $value) {
        $arr1 = explode(":",$value);
        
        if(!empty($select)) {
            if($select == $arr1[0]) {
                $selectString = $arr1[1];
            }
        }
    }    
    return $selectString;
}

/**
 * 获取产品信息
 * @param   int        $id      产品id 
 * @return  string     $string    产品信息
 * @author  矢志bu渝   <15176659527@163.com>
 */
function get_goods_info($id,$field="name"){
    if(empty($id)){
        return false;
    }
    $model = Db::name('goods');
    $map['id'] = $id;
    $info = $model->where($map)->find();
    
    if($info){
        return $info[$field];
    }else{
        return false;
    }
}


//生成微信code二维码

function get_wx_code($num){
        
    if($num){
        $appid = config('wechat_appid');
        $appsecret = config('wechat_appsecret');
        $access_token = getAccessToken($appid,$appsecret); //获取token

        //二维码参数
        $qrcode = '{"action_name": "QR_LIMIT_SCENE","action_info":{"scene":{"scene_id":'.$num.'}}}';
        $url = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.$access_token;
        $result = https_request($url,$qrcode);
        $jsoninfo = json_decode($result,true);
        $ticket = $jsoninfo['ticket'];

        $code_url = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.$ticket;

        return $code_url;

    }else{
        return "参数错误";
    }
}

/**
 * 获取通用accessToken
 * @author vaey
 * @param  [type] $appid     [appid]
 * @param  [type] $appsecret [appsecret]
 * @return [type]            [accessToken]
 */
function getAccessToken($appid,$appsecret)
{
    // access_token 应该全局存储与更新，以下代码以写入到文件中
    
    $data = json_decode(file_get_contents("access_token.json"));
    if($data->expire_time < time()){ //token过期，重获
            $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$appsecret;
            $res = json_decode(https_request($url));
            $access_token = $res->access_token;
            if($access_token){
                $data->expire_time = time() + 7000;
                $data->access_token = $access_token;
                $fp = fopen("access_token.json", "w");
                fwrite($fp, json_encode($data));
                fclose($fp);
            }
    }else{
        $access_token = $data->access_token;
    }
    return $access_token;
}

/**
 * 模拟提交数据，获得返回值
 * @author vaey
 * @param  [type] $url  [description]
 * @param  [type] $data [description]
 * @return [type]       [description]
 */
function https_request($url,$data = null)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    if (!empty($data)){
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    }
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($curl);
    curl_close($curl);
    return $output;
}


