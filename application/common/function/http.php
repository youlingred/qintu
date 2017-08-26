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
* 模拟http请求
* @author  tangtanglove
*/
function httpMethod($url,$post = '',$cookie = '')
{
    if (empty($url)) {
        return '参数错误！';
    }
    //初始化
    $curl = curl_init();
    //设置抓取的url
    curl_setopt($curl, CURLOPT_URL, $url);
    //设置头文件的信息作为数据流输出
    curl_setopt($curl, CURLOPT_HEADER, 1);
    if(!empty($cookie)){
        curl_setopt($curl, CURLOPT_COOKIE, $cookie);
    }
    //设置获取的信息以文件流的形式返回，而不是直接输出。
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    // 传入post数据
    if (!empty($post)) {
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
    }
    //执行命令
    $data = curl_exec($curl);
    list($header, $body) = explode("\r\n\r\n", $data, 2);
    preg_match_all("/Set\-Cookie:([^;]*);/", $header, $matches);
    $result['status']  = curl_getinfo($curl,CURLINFO_HTTP_CODE);
    $result['cookie']  = substr($matches[1][0], 1);
    $result['content'] = $body;
    curl_close($curl);
    return $result;
}

/**
* 获取cookie
* @author  tangtanglove
*/
function getcookie()
{
    $cookie = config('mobile_api.cookie');
    $result = '';
    foreach ($cookie as $key => $value) {
        $result = $result.$key.'='.$value.';';
    }
    return $result;
}