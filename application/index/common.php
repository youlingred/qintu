<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: tangtanglove <dai_hang_love@126.com> <http://www.ixiaoquan.com>
// +----------------------------------------------------------------------

use think\Db;
use think\config;


/**
 * 公共库文件
 * 主要定义系统公共函数库
 */
/**
 * 系统邮件发送函数
 * @param string $to 接收邮件者邮箱
 * @param string $subject 邮件主题
 * @param string $body 邮件内容
 * @param string $attachment 附件列表
 * @return boolean
 */
function SendMail($title,$username,$time,$email,$url)
{
    $config = config('email');
    import('org.util.phpmailer.PHPMailer');
    $mail = new \PHPMailer;
    $mail->CharSet = 'utf-8';//设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码，
    $mail->IsSMTP();//设定使用SMTP服务
    $mail->SMTPSecure = 'ssl'; 
    $mail->SMTPDebug = 1;//关闭SMTP调试功能//1=errors and messages//2=messages only
    $mail->SMTPAuth  = true;//启用SMTP验证功能
    $mail->Port      = $config['mail_port'];  // SMTP服务器的端口号
    $mail->Host      = $config['mail_smtp'];
    $mail->AddAddress($email);//添加收件人地址，
    $mail->Body      = "亲爱的" . $username . "：<br/>您在" . $time . "提交了通过邮箱".$email."找回密码请求。请点击下面的链接重置密码（按钮24小时内有效）。<br/><a href='" . $url . "' target='_blank'>" . $url . "</a><br/>如果以上链接无法点击，请将它复制到你的浏览器地址栏中进入访问。<br/>如果您没有提交找回密码请求，请忽略此邮件。"; //设置邮件正文
    $mail->From      = $config['mail_address'];//设置发件人名字
    $mail->FromName  = '管理员团队';//设置发件人名字
    $mail->Subject   = $title;//设置邮件标题
    $mail->Username  = $config['mail_loginname'];//设置用户名和密码
    $mail->Password  = $config['mail_password'];
    return($mail->Send());
} 
//获取产品列表
function _get_goods_list($cate_slug,$limit=3,$sort='default'){
	$map['slug'] = $cate_slug;
	$categoryInfo = Db::name('GoodsCate')->where($map)->find();
        $order = "";
        switch ($sort) {
            case 'default':
                break;
			case 'sortup':
                $order = "sort asc";
                break;
			case 'sortdown':
	            $order = "sort desc";
	            break;
            case 'sellup':
                $order = "sell_num asc";
                break;
            case 'selldowm':
                $order = "sell_num desc";
                break;
            case 'scoreup':
                $order = "score_num asc";
                break;
            case 'scoredown':
                $order = "score_num desc";
                break;
            case 'priceup':
                $order = "price asc";
                break;
            case 'pricedown':
                $order = "price desc";
                break;
            default:
                break;
        }
	$goods_ids=[];
	if(!$categoryInfo){
		$goods_ids=null;
	}else{
	 $ids = Db::name('GoodsCateRelationships')->where(['cate_id'=>$categoryInfo['id']])->column('goods_id');
	 $goods_ids=array_merge($ids,$goods_ids);
	}
	
	if($goods_ids){
        $where['id'] = ['in',$goods_ids];
        $where['status'] = 1;
        //当前分类下的数据
        $list = Db::name('Goods')->where($where)->order($order)->limit($limit)->select();
    }else{
        $list = "";
    }
    return $list;
}
//获取精品列表
function _get_goods_best_list($cate_slug,$limit=3,$sort='default'){
	$map['slug'] = $cate_slug;
	$categoryInfo = Db::name('GoodsCate')->where($map)->find();
        $order = "";
        switch ($sort) {
            case 'default':
                break;
			case 'sortup':
                $order = "sort asc";
                break;
			case 'sortdown':
	            $order = "sort desc";
	            break;
            case 'sellup':
                $order = "sell_num asc";
                break;
            case 'selldowm':
                $order = "sell_num desc";
                break;
            case 'scoreup':
                $order = "score_num asc";
                break;
            case 'scoredown':
                $order = "score_num desc";
                break;
            case 'priceup':
                $order = "price asc";
                break;
            case 'pricedown':
                $order = "price desc";
                break;
            default:
                break;
        }
	$goods_ids=[];
	if(!$categoryInfo){
		$goods_ids=null;
	}else{
	 $ids = Db::name('GoodsCateRelationships')->where(['cate_id'=>$categoryInfo['id']])->column('goods_id');
	 $goods_ids=array_merge($ids,$goods_ids);
	}
	
	if($goods_ids){
        $where['id'] = ['in',$goods_ids];
        $where['status'] = 1;
        $where['is_best'] = 1;
        //当前分类下的数据
        $list = Db::name('Goods')->where($where)->order($order)->limit($limit)->select();
    }else{
        $list = "";
    }
    return $list;
}
//获取热销列表
function _get_goods_hot_list($cate_slug,$limit=5,$sort='default'){
	$map['slug'] = $cate_slug;
	$categoryInfo = Db::name('GoodsCate')->where($map)->find();
        $order = "";
        switch ($sort) {
            case 'default':
                break;
			case 'sortup':
                $order = "sort asc";
                break;
			case 'sortdown':
	            $order = "sort desc";
	            break;
            case 'sellup':
                $order = "sell_num asc";
                break;
            case 'selldowm':
                $order = "sell_num desc";
                break;
            case 'scoreup':
                $order = "score_num asc";
                break;
            case 'scoredown':
                $order = "score_num desc";
                break;
            case 'priceup':
                $order = "price asc";
                break;
            case 'pricedown':
                $order = "price desc";
                break;
            default:
                break;
        }
	$goods_ids=[];
	if(!$categoryInfo){
		$goods_ids=null;
	}else{
	 $ids = Db::name('GoodsCateRelationships')->where(['cate_id'=>$categoryInfo['id']])->column('goods_id');
	 $goods_ids=array_merge($ids,$goods_ids);
	}
	
	if($goods_ids){
        $where['id'] = ['in',$goods_ids];
        $where['status'] = 1;
        $where['is_hot'] = 1;
        //当前分类下的数据
        $list = Db::name('Goods')->where($where)->order($order)->limit($limit)->select();
    }else{
        $list = "";
    }
    return $list;
}
//获取周边推荐
//function _get_goods_nearby_list($area,$cate_slug="",$limit=2,$sort='rand'){
//	$map['slug'] = $cate_slug;
//	$categoryInfo = Db::name('GoodsCate')->where($map)->find();
//      $order = "";
//      switch ($sort) {
//          case 'default':
//              break;
//			 case 'rand':
//              $order = "rand()";
//              break;	
//          case 'sellup':
//              $order = "sell_num asc";
//              break;
//          case 'selldowm':
//              $order = "sell_num desc";
//              break;
//          case 'scoreup':
//              $order = "score_num asc";
//              break;
//          case 'scoredown':
//              $order = "score_num desc";
//              break;
//          case 'priceup':
//              $order = "price asc";
//              break;
//          case 'pricedown':
//              $order = "price desc";
//              break;
//          default:
//              break;
//      }
//		$where['status'] = 1;
//		if($area){
//			$where['label_area']=$area;
//		}
//		$goods_ids=[];
//	if(!$categoryInfo){
//		$list = Db::name('Goods')->where($where)->order($order)->limit($limit)->select();
//		return $list;
//	}else{
//	 $ids = Db::name('GoodsCateRelationships')->where(['cate_id'=>$categoryInfo['id']])->column('goods_id');
//	 $goods_ids=array_merge($ids,$goods_ids);
//	}
//	if($goods_ids){
//      $where['id'] = ['in',$goods_ids];
//      //当前分类下的数据
//      $list = Db::name('Goods')->where($where)->order($order)->limit($limit)->select();
//  }else{
//      $list = "";
//  }
//  return $list;
//}
//获取周边推荐修改
function _get_goods_nearby_list($goods_data,$cate_slug="",$limit=2,$sort='rand'){
	//return $goods_data['label_area'];
	$map['slug'] = $cate_slug;
	$categoryInfo1 = Db::name('GoodsCate')->where($map)->find();
	$map['slug'] = "qdz";
	$categoryInfo2 = Db::name('GoodsCate')->where($map)->find();
        $order = "";
        switch ($sort) {
            case 'default':
                break;
			 case 'rand':
                $order = "rand()";
                break;	
            default:
                break;
        }
		$goods_ids1=[];
		$goods_ids2=[];
		
		$goods_ids1 = Db::name('GoodsCateRelationships')->where(['cate_id'=>$categoryInfo1['id']])->column('goods_id');
		$goods_ids2 = Db::name('GoodsCateRelationships')->where(['cate_id'=>$categoryInfo2['id']])->column('goods_id');
		
//		$key = array_search($goods_data['id'], $goods_ids1);
//		if ($key !== false){
//			array_splice($goods_ids1, $key, 1);
//		}
//		$key = array_search($goods_data['id'], $goods_ids2);
//		if ($key !== false){
//			array_splice($goods_ids2, $key, 1);
//		}
		$goods_ids1=array_diff($goods_ids1,[$goods_data['id']]);
		$goods_ids2=array_diff($goods_ids2,[$goods_data['id']]);
		$goods_ids2=array_diff($goods_ids2, $goods_ids1);
		$list=[];
        //当前分类下的数据
    	if(!empty($goods_data['label_match_1'])){
    		$where1['id'] = ['<>',$goods_data['id']];
			$where1['status'] = 1;
			$where1['label_match_1']=$goods_data['label_match_1'];
			$list=Db::name('Goods')->where($where1)->order($order)->limit($limit)->select();
    	}
		$length=count($list);
		
		if($length<2){
			if($goods_ids1){
				$where2['id'] = ['in',$goods_ids1];
				$where2['status'] = 1;
				$where2['label_area']=$goods_data['label_area'];
				$list_more=Db::name('Goods')->where($where2)->order($order)->limit($limit-$length)->select();
				$list=array_merge($list,$list_more);
			}
			$length=count($list);
			$test=[];
			if($length<2){
				foreach ($list as $value) {
				    array_push($test,$value['id']);
				}
				$goods_ids2=array_diff($goods_ids2, $test);
				if($goods_ids2){
					$where3['id'] = ['in',$goods_ids2];
					$where3['status'] = 1;
					$where3['label_area']=$goods_data['label_area'];
					$list_more=Db::name('Goods')->where($where3)->order($order)->limit($limit-$length)->select();
					$list=array_merge($list,$list_more);
				}
			}
		}
    	return $list;
}
/**
 * 根据别名获取文章信息
 * @author  边缘
 * @param string $post_name 文章的别名
 * @param string $field 需要查询的字段名
 */
function _get_post_by_name($post_name="",$field="")
{
	$postInfo = Db::name('Posts')->where(['name'=>$post_name])->cache(FALSE)->find();
	
	if ($field) {
        return $postInfo[$field];
    } else {
        return $postInfo;
    }
}
//获取一类文章信息

function _get_posts_by_term($term_slug){
	$slug=$term_slug;
	if(empty($slug)){
		return "";
	}
	$map['slug']=$slug;
	$term_id=Db::name('Terms')->where($map)->column('id');
	if(empty($term_id)){
		return "";
	}
	$where['term_taxonomy_id'] = ['in',$term_id];
	$ids=Db::name('TermRelationships')->where($where)->column('object_id');
	if(empty($ids)){
		return "";
	}
	$where_id['id'] = ['in',$ids];
	$list=Db::name('Posts')->where($where_id)->select();
	return $list;
}
///获取筛选标签信息
function _get_filters($type='filter_qdz'){
	$p_filter = Db::name('GoodsFilter')->where(['slug'=>$type])->find();
	$map['pid']=$p_filter['id'];
	$filters=Db::name('GoodsFilter')->where($map)->select();
	return $filters;
}
///获取日元的汇率
function get_exchange_rate(){
	return config('exchange_rate');
//	$now=getdate()['mday'];
//	$rage_update_date=config('rate_update_date');
//	return config('rate_update_date');
//	if($now!=config('rate_update_date')){
//		config('exchange_rate',convertCurrency("CNY","JPY","1"));
//		config('rate_update_date',$now);
//		return config('rate_update_date');
//		return $rage_update_date;
//	}
//	return config('exchange_rate');
}
///汇率换算
//function convertCurrency($from, $to, $amount){
//$data = file_get_contents("http://www.baidu.com/s?wd={$from}%20{$to}&rsv_spt={$amount}");
//preg_match("/<div>1\D*=(\d*\.\d*)\D*<\/div>/",$data, $converted);
//$converted = preg_replace("/[^0-9.]/", "", $converted[1]);
//return number_format(round($converted, 3), 1);
//}
/**
*获取亲途达人分享体验产品列表
* @param string $parend_id 达人主题标识ID
**/
function _get_qtdr_share_list($parend_id){
	$map['share_child_id'] = $parend_id;
	$list = Db::name('Goods')->where($map)->select();
	return $list;
}
function _get_qtdr_person($child_id){
	if($child_id==0){
		$data=null;
	}else{
		$map['share_master_id'] = $child_id;
		$data= Db::name('Goods')->where($map)->find();
	}
	return $data;
}
function deleteAll($path) {
    $op = dir($path);
    while(false != ($item = $op->read())) {
        if($item == '.' || $item == '..') {
            continue;
        }
        if(is_dir($op->path.'/'.$item)) {
            deleteAll($op->path.'/'.$item);
            rmdir($op->path.'/'.$item);
        } else {
            unlink($op->path.'/'.$item);
        }
    
    }   
}
function get_total_comment($goods_id){
	$map['status'] =1;
    $map['goods_id'] = $goods_id;
	$total_comment = Db::name('GoodsComment')->where($map)->count();
	return $total_comment;
}
function get_no_comment_list(){
	$map['a.uid']        = UID;
    $map['b.is_comment'] = -1;
    $orders = Db::name('Orders')
            ->alias('a')
            ->join('orders_goods b','b.order_id= a.id','LEFT')
            ->where($map)
            ->field('b.price*b.num as total_money,a.*,b.goods_id,b.num,b.is_comment,b.name,b.price,b.standard')
            ->order('a.createtime desc')->select();
    return $orders;
}
function get_product_cover_path($goods_id){
	$map['id'] = $goods_id;
	$cover_path = Db::name('Goods')->where($map)->column('cover_path');
	return $cover_path;
}
