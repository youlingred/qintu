<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: tangtanglove <dai_hang_love@126.com> <http://www.ixiaoquan.com>
// +----------------------------------------------------------------------

namespace app\index\controller;

use think\Controller;
use think\Request;
use think\Db;

/**
 * 网站首页控制器
 * @author  tangtnglove <dai_hang_love@126.com>
 */
class Trace extends Base
{
    public function index()
    {
    	// 输出主题
        return $this->themeFetch('trace');
    }

    /*
	 * 查询溯源信息
    **/
    public function search($code){
    	if(empty($code)){
    		return $this->error('追溯码不存在');
    	}
    	$model = Db::name('source_goods_data');
    	$map['batch_number'] = $code;

        // 基础信息
    	$info = $model->where($map)->find();
        if(!$info){
            
        }else{
            $info['data'] = json_decode($info['data'],true);
            // 基地信息
            $baseInfo = Db::name('source_goodsbase')->where('id',$info['goods_base_id'])->find();
            if(!$baseInfo){

            }
            $baseInfo['content'] = mb_substr($baseInfo['content'],0,200,'utf-8');
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
        }
        
    	// 输出主题
        return $this->themeFetch('trace_detail');
    }
}
