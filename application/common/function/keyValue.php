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
 * key-value键值对操作方法库
 */

/**
 * 插入key_value通用方法
 * $collection 关联表
 * $data keyvalud键值对
 * $uuid 系统唯一标示符
 * @author  tangtanglove
 */
function insert_key_value($collection,$data,$uuid = 'default')
{
    if (empty($collection) || empty($data)) {
        return false;
    }
    // 初始化结果
    $result = true;
    // 循环插入数据
    foreach ($data as $key => $value) {
        $getStatus = Db::name('KeyValue')
                    ->insert(['collection' => $collection,'uuid' => $uuid,'name' => $key,'value' =>  $value]);
        if (!$getStatus) {
            $result = false;
        }
    }
    // 返回插入结果
    return $result;
}

/**
 * 更新key_value通用方法
 * $collection 关联表
 * $data keyvalud键值对
 * $uuid 系统唯一标示符
 * @author  tangtanglove
 */
function update_key_value($collection,$data,$uuid = 'default')
{
    if (empty($collection) || empty($data)) {
        return false;
    }
    // 初始化结果
    $result = 0;
    // 组合条件
    $map['collection']  = $collection;
    $map['uuid']        = $uuid;
    // 循环更新数据
    foreach ($data as $key => $value) {
        $map['name']    = $key;
        $res            = Db::name('KeyValue')->where($map)->select();
        if ($res) {
            $getStatus  = Db::name('KeyValue')->where($map)->update(['value' => $value]);
        } else {
            $getStatus  = Db::name('KeyValue')->insert(['collection' => $collection,'uuid' => $uuid,'name' => $key,'value' =>  $value]);
        }
        if ($getStatus == 1) {
            $result += 1;
        }
    }
    // 返回插入结果
    return $result;
}

/**
 * 获取key_value数组通用方法
 * $collection 关联表
 * $uuid 系统唯一标示符
 * @author  tangtanglove
 */
function select_key_value($collection,$uuid = '')
{
    if (empty($collection)) {
        return false;
    }
    // 组合条件
    $map['collection']  = $collection;
    if (!empty($uuid)) {
        $map['uuid']        = $uuid;
    }
    // 查询数据
    $getKeyValueList    = Db::name('KeyValue')->where($map)->select();
    if (!empty($getKeyValueList)) {
        foreach ($getKeyValueList as $key => $value) {
            $data[$value['name']] = $value['value'];
        }
    } else {
        return false;
    }
    return $data;
}

/**
 * 获取一条key_value数组通用方法
 * $collection 关联表
 * $uuid 系统唯一标示符
 * @author  tangtanglove
 */
function find_key_value($collection,$uuid = 'default',$name='')
{
    if (empty($collection)) {
        return false;
    }
    // 组合条件
    $map['collection']  = $collection;
    $map['uuid']        = $uuid;
    if(!empty($name)){
    	$map['name']        = $name;
    }
    // 查询数据
    $getKeyValueInfo    = Db::name('KeyValue')->where($map)->find();
    if (!empty($getKeyValueInfo)) {
        // 返回结果
        return $data[$getKeyValueInfo['name']] = $getKeyValueInfo['value'];
    } else {
        return false;
    }
} 

/**
 * 删除key_value数组通用方法
 * $collection 关联表
 * $uuid 系统唯一标示符
 * @author  tangtanglove
 */
function delete_key_value($collection,$uuid = 'default')
{
    if (empty($collection)) {
        return false;
    }
    // 组合条件
    $map['collection']  = $collection;
    $map['uuid']        = $uuid;
    // 删除数据
    return  Db::name('KeyValue')->where($map)->delete();
}

/**
 * 通过UUID获取val值
 * $length 截取的长度，为0则不截取
 * @return [type] [description]
 */
function get_val($uuid,$name,$length=0){
    $map['uuid']    = $uuid;
    $map['name']    = $name;

    $value = Db::name('KeyValue')->where($map)->value('value');
    if($length>0){
        if(mb_strlen($value,'utf8')>$length){
            $value = mb_substr($value,0,$length,'utf-8')."...";
        }
    }
    return $value;
}