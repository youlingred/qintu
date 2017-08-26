<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 天行健 <whjfordream@163.com> 
// +----------------------------------------------------------------------

namespace app\wap\controller;

use think\Controller;
use think\Db;
use think\Request;

/**
 * 溯源码查询控制器
 * @author  tangtnglove <dai_hang_love@126.com>
 */
class Trace extends Base
{
	/**
	 * 输出主题
	 * @author  天行健 <whjfordream@163.com>
	 */
    public function index()
    {
    	// 输出主题
        return $this->themeFetch('trace');
    }

    /**
     * 溯源码查询控制器
     * 输入溯源码，查询相关数据
     * @author  天行健 <whjfordream@163.com>
     */
    public function traceList()
    {
        // 获取数据
        $code   = input('get.code');
        // 为空赋值
        // if(empty($code)) {
        //     return $this->error('参数错误');
        // }
        // 验证追溯码是否有效
        $checkcode = Db::name('source_goods_data')->where('batch_number',$code)->find();
        if($checkcode){
            $model = Db::name('source_goods_data');
            $map['batch_number'] = $code;
            // 基础信息
            $info = $model->where($map)->find();
            $info['data'] = json_decode($info['data'],true);
            // 基地信息
            $baseInfo = Db::name('source_goodsbase')->where('id',$info['goods_base_id'])->find();
            // 加工信息
            $list = Db::table('mini_source_goods_form_cate')            
                ->where('goods_cate_id',$info['goods_cate_id'])
                ->select();
            foreach ($list as $key => $value) {
                $list[$key]['lists'] = Db::name('SourceGoodsForm')->where(['goods_form_cate_id'=>$value['id']])->select();
            }
            //dump($info['data']);die();        
            $this->assign('info',$info);
            $this->assign('baseInfo',$baseInfo);
            $this->assign('list',$list);
            // 输出主题
            return $this->themeFetch('trace_detail');
        }else{
             return $this->themeFetch('trace_error');
        }
    }
}
