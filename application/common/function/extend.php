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
 * 获取商品价格
 * @author 完美°ぜ界丶
 */
function get_product_value($uuid,$type='')
{
    // 查询数据
    $map['uuid'] = $uuid;
    $map['name'] = $type;
    $value  = Db::name('KeyValue')->where($map)->value('value');
    return $value;
}
/**
 * 获取订单下的商品列表
 * @author ILSunshine
 */
function get_orders_goods($id)
{
    // 查询数据
    $map['order_id'] = $id;
    $goodsList  = Db::name('OrdersGoods')
                ->where($map)                
                ->field('*,price*num as total_money')
                ->select();
    return $goodsList;
}

/**
 * 获取订单支付状态
 * @author ILSunshine
 */
function get_goods_status($order_no_id)
{
    // 查询数据
    $map['order_no'] = $order_no_id;
    $orderstatus     = Db::name('Orders')->where($map)->value('status');
    return $orderstatus;
}
function get_orders_status($order_id)
{
    // 查询数据
    $map['id'] = $order_id;
    $orderstatus     = Db::name('Orders')->where($map)->value('status');
    return $orderstatus;
}

/**
 * 获取商品封面图
 * @author ILSunshine
 */
function get_goods_cover($id)
{
   $goods_cover  = Db::name('Goods')->where('id',$id)->value('cover_path');         
   return $goods_cover;
}
/**
 * 获取订单配送时间
 * @author ILSunshine
 */
function get_delivery_time($id)
{
   $delivery_time  = Db::name('OrdersStatus')->where(array('order_id'=>$id,'status'=>'shipped'))->value('createtime');         
   $delivery_time=$delivery_time?date("Y-m-d G:i:s", $delivery_time):"暂无";
   return $delivery_time;
}

function get_trade_no($id,$num=0){

  $trade  = Db::name('OrdersStatus')->where(array('order_id'=>$id))->value('trade_no');         
  $trade=$trade?$trade:"暂无";
  if($num==0){
    return $trade;
  }else{
    if(mb_strlen($trade,'utf8')>$num){
      $trade = mb_substr($trade,0,$num,'utf-8')."...";
    }else{
      return $trade;
    }
  }
  return $trade;
}


