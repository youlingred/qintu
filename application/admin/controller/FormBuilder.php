<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: tangtanglove <dai_hang_love@126.com> <http://www.ixiaoquan.com>
// +----------------------------------------------------------------------

namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\Loader;
use think\Request;
use common\library\Form;

/**
 * 智能表单控制器
 * @author  tangtanglove <dai_hang_love@126.com>
 */
class FormBuilder extends Common
{
    // 表单定义
    protected $forms = [
        // 文章表单
        'article' => [
            'title'     => '文章表单',
            'fields'    => [
                'description' => ['title' => '描述','name' => 'description','data' => '','placeholder' => '描述','type' => 'text','option' => ''],
            ]
        ],
        // 职位表单
        'job' => [
            'title'     => '职位表单',
            'fields'    => [
                'position'  => ['title' => '职位','name' => 'position','data' => '','placeholder' => '职位名称','type' => 'text','option' => ''],
                'deadline'  => ['title' => '截止时间','name' => 'deadline','data' => '','placeholder' => '截止时间','type' => 'time','option' => ''],
                'number'    => ['title' => '招聘人数','name' => 'number','data' => '','placeholder' => '招聘人数','type' => 'text','option' => ''],
            ],
        ],
        // 商品表单
        'product' => [
            'title'     => '商品表单',
            'fields'    => [
                    'price'     => ['title' => '价格','name' => 'price','data' => '','placeholder' => '价格','type' => 'text','option' => ''],
                    'stock_num' => ['title' => '库存','name' => 'stock_num','data' => '','placeholder' => '库存','type' => 'text','option' => ''],
                    'attribute' => ['title' => '属性','name' => 'attribute','data' => '','placeholder' => '属性','type' => 'text','option' => ''],
                    // checkbox  
                    'position'  => [
                            'title'         => '推荐位checkbox',// 大标题
                            'name'          => 'position',// 每个选项的name
                            'placeholder'   => '推荐位',// 用不到，保证参数完整
                            'type'          => 'checkbox',
                            'data'          => ['','channel','list'],// option默认值，可设置多个,可为空，但数量必须与option一致
                            'option'        => ['index'=>'首页推荐','channel'=>'频道页推荐','list'=>'列表页推荐'],                                         
                    ],
                    'integral' => ['title' => '积分','name' => 'integral','data' => '','placeholder' => '积分','type' => 'text','option' => ''],
            ],
        ],
        // 样例表单，供开发者参考如何扩展标签
        'sample' => [
            'title'     => '样例表单',
            'fields'    => [
                    'price'     => ['title' => '价格','name' => 'price','data' => '','placeholder' => '价格','type' => 'text','option' => ''],
                    'stock_num' => ['title' => '库存','name' => 'stock_num','data' => '','placeholder' => '库存','type' => 'text','option' => ''],
                    // time
                    'deadline'  => ['title' => '截止时间','name' => 'deadline','data' => '','placeholder' => '截止时间','type' => 'time','option' => ''],
                    // textarea
                    'address'   => ['title' => '地址textarea','name' => 'address','data' => '','placeholder' => '地址','type' => 'textarea','option' => ''],
                    // checkbox  
                    'position'  => [
                            'title'         => '推荐位checkbox',// 大标题
                            'name'          => 'position',// 每个选项的name
                            'placeholder'   => '推荐位',// 用不到，保证参数完整
                            'type'          => 'checkbox',
                            'data'          => ['','channel','list'],// option默认值，可设置多个,可为空，但数量必须与option一致
                            'option'        => ['index'=>'首页推荐','channel'=>'频道页推荐','list'=>'列表页推荐'],                                         
                    ],
                    // select
                    'position1'  => [
                            'title'         => '推荐位1select',// 大标题
                            'name'          => 'position1',// 每个选项的name
                            'placeholder'   => '推荐位1',// 用不到，保证参数完整
                            'type'          => 'select',
                            'data'          => 'channel',// option默认值,单选，只能指定一个
                            'option'        =>  ['index'=>'首页推荐','channel'=>'频道页推荐','list'=>'列表页推荐'],    
                    ],
                    // radio
                    'position2'  => [
                            'title'         => '推荐位2radio',// 大标题
                            'name'          => 'position2',// 每个选项的name
                            'placeholder'   => '推荐位2',// 用不到，保证参数完整
                            'type'          => 'radio',
                            'data'          => 'list',// option默认值,单选，只能指定一个
                            'option'        => ['index'=>'首页推荐','channel'=>'频道页推荐','list'=>'列表页推荐'],                                                           
                    ],                        
	                // file
                    'files'  => [
                            'title'         => '3file',// 文件前label的文字
                            'name'          => 'file',     
                            'placeholder'   => '推荐位3',// 用不到，保证参数完整
                            'type'          => 'file',
                            'data'          => '',
                            'option'        => '',                        
                    ],
	                // picture
                    'picture'  => [
                            'title'         => '4picture',// 图片前label的文字
                            'name'          => 'picture',// 未用
                            'placeholder'   => '推荐位3',// 用不到，保证参数完整
                            'type'          => 'picture',// 未用
                            'data'          => '',// 默认图片uuid
                            'option'        => '',// 选项，用不到            
                    ],
            ],
        ],
        // 升级表单
        'system' => [
            'title'     => '升级表单',
            'fields'    => [
                    'version' => ['title' => '版本号','name' => 'version','data' => '','placeholder' => '版本号','type' => 'text','option' => ''],
                    'address' => ['title' => '补丁包地址','name' => 'address','data' => '','placeholder' => '补丁包地址','type' => 'text','option' => ''],
            ]
        ],

    ];

    /**
     * 获取所有表单
     * @author tangtanglove
     */
    public function getLists()
    {
        $formLists = $this->forms;
        if (!empty($formLists)) {
            return $this->success('获取成功！','',$formLists);
        } else {
            return $this->error('获取表单失败！');
        }

    }

    /**
     * 解析表单
     * @author tangtanglove
     */
    public function parse()
    {
        // 获取表单名称
        $formName = input('formName');
        // 获取文章uuid
        $uuid     = input('uuid');
        // 表单扩展字段赋值
        if ($uuid) {
            $data  = select_key_value('posts.form',$uuid);
        } else {
            $data  = '';
        }
        // 智能表单对象
        $form     = new Form;
        // 表单属性
        $formLists = $this->forms;
        // 表单属性是否存在
        if (!empty($formLists[$formName])) {
            $result = '';
            $html = '';
            $fields = $formLists[$formName]['fields'];
            foreach ($fields as $key => $value) {                
                if ($data) {
                    if (isset($data[$value['name']])) {
                        $html = $html.call_user_func_array(array(new Form,$value['type']), array($value['title'],$value['option'],$data[$value['name']],$value['name'],$value['placeholder']));
                    } else {
                        $html = $html.call_user_func_array(array(new Form,$value['type']), array($value['title'],$value['option'],$value['data'],$value['name'],$value['placeholder'])); 
                    }
                } else {
                    $html = $html.call_user_func_array(array(new Form,$value['type']), array($value['title'],$value['option'],$value['data'],$value['name'],$value['placeholder']));
                }
            }
            // dump($data);die();
            // 渲染表单
             $result = $form->renderhtml($html);
        } else {
            $result = '无此表单！';
        }
        // post请求返回json数据
        if (Request::instance()->isPost()) {
            return $this->success('获取成功！','',$result);
        } else {
            return $result;
        }
    }

    /**
     * 提交表单
     * @author tangtanglove
     */
    public function addPostForm($formName,$data,$uuid)
    {
        // 表单属性
        $formLists = $this->forms;
        // 表单属性是否存在
        if (!empty($formLists[$formName])) {
            $result = '';
            $fields = $formLists[$formName]['fields'];

            foreach ($fields as $key => $value) {
                // 组合keyvalue数据
                if($value['type'] == 'checkbox') {
                    $checkboxData = input('post.'.$value['name'].'/a');
                    // checkbox可能是多值
                    $keyValueData[$value['name']]	= implode(',',$checkboxData);
                } else {
                    $keyValueData[$value['name']]	= $data[$value['name']];
                }
                if($value['type'] == 'time') {
                    $keyValueData[$value['name']]   = getFormatTime($data[$value['name']]);
                }
            }            
            // 写入keyvalue表
            $result = insert_key_value('posts.form',$keyValueData,$uuid);
        } else {
            $result = '无此表单！';
        }
    }    

}


