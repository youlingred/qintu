<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: tangtanglove <dai_hang_love@126.com> <http://www.ixiaoquan.com>
// +----------------------------------------------------------------------

/**
 * 系统配文件
 * 所有系统级别的配置
 */
return [
    // application信息
    'application'               => [
        'app_name'     => 'admin',
        'app_url'      => 'http://www.xxxx.com/plugins/',
        'description'  => '此模块描述信息',
        'version'      => '1.0.0',
        'author'       => 'tangtanglove',
        'author_url'   => 'http://www.xxxx.com/',
        'license'      => 'GPL',
    ],
    // URL设置
    'url_route_on'          => true,
    // Session设置
    'session'               => [
        'id'             => '',
        // SESSION_ID的提交变量,解决flash上传跨域
        'var_session_id' => 'session_id',
        // SESSION 前缀
        'prefix'         => 'minishop',
        // 驱动方式 支持redis memcache memcached
        'type'           => '',
        // 是否自动开启 SESSION
        'auto_start'     => true,
    ],
    // 验证码设置
    'captcha'   =>  [
        'fontSize'    =>    30,    // 验证码字体大小
        'length'      =>    3,     // 验证码位数
        'useNoise'    =>    false, // 关闭验证码杂点
    ],
    // 多语言设置
    'lang_switch_on'        => true,   // 开启语言包功能
    'lang_list'             => ['zh-cn,zh-tw,en-us'], // 支持的语言列表
    // 模板设置
    'view_replace_str'      =>[
        'STATIC_PATH'=> __ROOT__.'/static', // 模板变量替换
        'ROOT_PATH'  => __ROOT__, // 模板变量替换
    ],
    // 图片上传白名单
    'upload_picture_mime'   => 'image/bmp,image/gif,image/jpeg,image/png', //允许上传的图片后缀
    // 文件上传白名单
    'upload_file_mime'      => 'image/bmp,image/gif,image/jpeg,image/png,application/zip,application/rar,application/x-tar,application/x-gzip,application/octet-stream,application/msword,application/vnd.ms-excel,text/plain,application/xml', //允许上传的文件后缀
    // ueditor文件上传配置
    'ueditor_upload'        => [
        // 上传图片配置项
        "imageActionName"       => "uploadimage", // 执行上传图片的action名称
        "imageFieldName"        => "upfile", // 提交的图片表单名称
        "imageMaxSize"          => 2048000, // 上传大小限制，单位B
        "imageAllowFiles"       =>  [".png", ".jpg", ".jpeg", ".gif", ".bmp"], // 上传图片格式显示
        "imageCompressEnable"   =>  true, // 是否压缩图片,默认是true
        "imageCompressBorder"   =>  1600, // 图片压缩最长边限制
        "imageInsertAlign"      =>  "none", // 插入的图片浮动方式
        "imageUrlPrefix"        =>  "", // 图片访问路径前缀
        "imagePathFormat"       =>  __ROOT__."/uploads/editor/image/{yyyy}{mm}{dd}/{time}{rand:6}", // 上传保存路径,可以自定义保存路径和文件名格式
        // 涂鸦图片上传配置项
        "scrawlActionName"      =>  "uploadscrawl", // 执行上传涂鸦的action名称
        "scrawlFieldName"       =>  "upfile", // 提交的图片表单名称
        "scrawlPathFormat"      =>  __ROOT__."/uploads/editor/image/{yyyy}{mm}{dd}/{time}{rand:6}", // 上传保存路径,可以自定义保存路径和文件名格式
        "scrawlMaxSize"         =>  2048000, // 上传大小限制，单位B
        "scrawlUrlPrefix"       =>  "", // 图片访问路径前缀
        "scrawlInsertAlign"     =>  "none",
        // 截图工具上传
        "snapscreenActionName"  =>  "uploadimage", // 执行上传截图的action名称
        "snapscreenPathFormat"  =>  __ROOT__."/uploads/editor/image/{yyyy}{mm}{dd}/{time}{rand:6}", // 上传保存路径,可以自定义保存路径和文件名格式
        "snapscreenUrlPrefix"   =>  "", // 图片访问路径前缀
        "snapscreenInsertAlign" =>  "none", // 插入的图片浮动方式
        // 抓取远程图片配置
        "catcherLocalDomain"    =>  ["127.0.0.1", "localhost", "img.baidu.com"],
        "catcherActionName"     =>  "catchimage", // 执行抓取远程图片的action名称
        "catcherFieldName"      =>  "source", // 提交的图片列表表单名称
        "catcherPathFormat"     =>  __ROOT__."/uploads/editor/image/{yyyy}{mm}{dd}/{time}{rand:6}", // 上传保存路径,可以自定义保存路径和文件名格式
        "catcherUrlPrefix"      =>  "", // 图片访问路径前缀
        "catcherMaxSize"        =>  2048000, // 上传大小限制，单位B
        "catcherAllowFiles"     =>  [".png", ".jpg", ".jpeg", ".gif", ".bmp"], // 抓取图片格式显示
        // 上传视频配置
        "videoActionName"       =>  "uploadvideo", // 执行上传视频的action名称
        "videoFieldName"        =>  "upfile", // 提交的视频表单名称
        "videoPathFormat"       =>  __ROOT__."/uploads/editor/video/{yyyy}{mm}{dd}/{time}{rand:6}", // 上传保存路径,可以自定义保存路径和文件名格式
        "videoUrlPrefix"        =>  "", // 视频访问路径前缀
        "videoMaxSize"          =>  102400000, // 上传大小限制，单位B，默认100MB
        "videoAllowFiles"       =>  [
            ".flv", ".swf", ".mkv", ".avi", ".rm", ".rmvb", ".mpeg", ".mpg",
            ".ogg", ".ogv", ".mov", ".wmv", ".mp4", ".webm", ".mp3", ".wav", ".mid"], // 上传视频格式显示
        // 上传文件配置
        "fileActionName"        =>  "uploadfile", // controller里,执行上传视频的action名称
        "fileFieldName"         =>  "upfile", // 提交的文件表单名称
        "filePathFormat"        =>  __ROOT__."/uploads/editor/file/{yyyy}{mm}{dd}/{time}{rand:6}", // 上传保存路径,可以自定义保存路径和文件名格式
        "fileUrlPrefix"         =>  "", // 文件访问路径前缀
        "fileMaxSize"           =>  51200000, // 上传大小限制，单位B，默认50MB
        "fileAllowFiles"        =>  [
            ".png", ".jpg", ".jpeg", ".gif", ".bmp",
            ".flv", ".swf", ".mkv", ".avi", ".rm", ".rmvb", ".mpeg", ".mpg",
            ".ogg", ".ogv", ".mov", ".wmv", ".mp4", ".webm", ".mp3", ".wav", ".mid",
            ".rar", ".zip", ".tar", ".gz", ".7z", ".bz2", ".cab", ".iso",
            ".doc", ".docx", ".xls", ".xlsx", ".ppt", ".pptx", ".pdf", ".txt", ".md", ".xml"
        ], // 上传文件格式显示
        // 列出指定目录下的图片
        "imageManagerActionName" =>  "listimage", // 执行图片管理的action名称
        "imageManagerListPath"   =>  __ROOT__."/uploads/editor/image/", // 指定要列出图片的目录
        "imageManagerListSize"   =>  20, // 每次列出文件数量
        "imageManagerUrlPrefix"  =>  "", // 图片访问路径前缀
        "imageManagerInsertAlign"=>  "none", // 插入的图片浮动方式
        "imageManagerAllowFiles" =>  [".png", ".jpg", ".jpeg", ".gif", ".bmp"], // 列出的文件类型
        // 列出指定目录下的文件
        "fileManagerActionName"  =>  "listfile", // 执行文件管理的action名称
        "fileManagerListPath"    =>  __ROOT__."/uploads/editor/file/", // 指定要列出文件的目录
        "fileManagerUrlPrefix"   =>  "", // 文件访问路径前缀
        "fileManagerListSize"    =>  20, // 每次列出文件数量
        "fileManagerAllowFiles"  =>  [
            ".png", ".jpg", ".jpeg", ".gif", ".bmp",
            ".flv", ".swf", ".mkv", ".avi", ".rm", ".rmvb", ".mpeg", ".mpg",
            ".ogg", ".ogv", ".mov", ".wmv", ".mp4", ".webm", ".mp3", ".wav", ".mid",
            ".rar", ".zip", ".tar", ".gz", ".7z", ".bz2", ".cab", ".iso",
            ".doc", ".docx", ".xls", ".xlsx", ".ppt", ".pptx", ".pdf", ".txt", ".md", ".xml"
        ] // 列出的文件类型
    ]

];
