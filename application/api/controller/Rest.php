<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

namespace app\api\controller;

use think\App;
use think\Request;
use think\Response;
use think\Controller;

class Rest extends Controller
{

    protected $method; // 当前请求类型
    protected $type; // 当前资源类型
    // 输出类型
    protected $restMethodList    = 'get|post|put|delete';
    protected $restDefaultMethod = 'get';
    protected $restTypeList      = 'html|xml|json|rss';
    protected $restDefaultType   = 'html';
    protected $restOutputType    = [ // REST允许输出的资源类型列表
        'xml'  => 'application/xml',
        'json' => 'application/json',
        'html' => 'text/html',
    ];

    /**
     * 架构函数 取得模板对象实例
     * @access public
     */
    public function _initialize()
    {
        // 资源类型检测
        $request = Request::instance();
        $ext     = $request->ext();
        if ('' == $ext) {
            // 自动检测资源类型
            $this->type = $request->type();
        } elseif (!preg_match('/\(' . $this->restTypeList . '\)$/i', $ext)) {
            // 资源类型非法 则用默认资源类型访问
            $this->type = $this->restDefaultType;
        } else {
            $this->type = $ext;
        }
        // 请求方式检测
        $method = strtolower($request->method());
        if (false === stripos($this->restMethodList, $method)) {
            // 请求方式非法 则用默认请求方法
            $method = $this->restDefaultMethod;
        }
        // 控制器初始化
        if(method_exists($this,'_initRest'))
        {
            $this->_initRest();
        }
        $this->method = $method;
        load_config();// 加载接口配置
    }

    /**
     * REST 调用
     * @access public
     * @param string $method 方法名
     * @return mixed
     * @throws \Exception
     */
    public function _empty($method)
    {
        $method = str_replace('.'.$this->type,'',$method);
        if (method_exists($this, $method . '_' . $this->method . '_' . $this->type)) {
            // RESTFul方法支持
            $fun = $method . '_' . $this->method . '_' . $this->type;
        } elseif ($this->method == $this->restDefaultMethod && method_exists($this, $method . '_' . $this->type)) {
            $fun = $method . '_' . $this->type;
        } elseif ($this->type == $this->restDefaultType && method_exists($this, $method . '_' . $this->method)) {
            $fun = $method . '_' . $this->method;
        }
        if (isset($fun)) {
            return App::invokeMethod([$this, $fun]);
        } else {
            // 抛出异常
            throw new \Exception('error action :' . $method);
        }
    }

    /**
     * 输出返回数据
     * @access protected
     * @param mixed     $data 要返回的数据
     * @param String    $type 返回类型 JSON XML
     * @param integer   $code HTTP状态码
     * @return Response
     */
    protected function response($data, $type = 'json', $code = 200)
    {
        return Response::create($data, $type)->code($code);
    }

    /**
     * 操作错误返回的快捷方法
     * @access protected
     * @param string $message 错误信息
     * @param integer $status 错误状态值
     * @return void
     * @author tangtnglove <dai_hang_love@126.com>
     */
    protected function restError($message = '', $code = 0) {
        $return['msg'] =   $message;
        $return['code'] =   $code;
        return json($return, 200);
    }

    /**
     * 操作成功跳返回的快捷方法
     * @access protected
     * @param string $message 成功信息
     * @return void
     * @author tangtnglove <dai_hang_love@126.com>
     */
    protected function restSuccess($message = '',$data = '') {
        $return['msg']  =   $message;
        $return['data'] =   $data;
        $return['code'] =   1;
        return json($return, 200);
    }
}
