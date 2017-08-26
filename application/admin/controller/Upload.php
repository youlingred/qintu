<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: tangtanglove <dai_hang_love@126.com> <http://www.ixiaoquan.com>
// +----------------------------------------------------------------------

namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\File;

/**
 * 上传控制器
 * @author  tangtanglove <dai_hang_love@126.com>
 */
class Upload extends Common
{
    /**
     * 上传文件
     * @author tangtanglove <dai_hang_love@126.com>
     */
    public function uploadFile()
    {
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('file');
        // 获取上传文件信息
        $getInfo = $file->getInfo();
        // 上传白名单监测
        $this->checkMime($getInfo['type'],config('upload_file_mime'));
        // 移动到服务器的上传目录 并且使用md5规则
        $getFileInfo = $file->move('./uploads/file/');
        if (!empty($getFileInfo)) {
            $data['path']    = $getFileInfo->getPathname();
            $data['code']    = 1;
            $data['message'] = '上传成功！';
        } else {
            $data['path']    = '';
            $data['code']    = 0;
            $data['message'] = '上传失败！';
        }
        return json($data);
    }

    /**
     * 上传图片
     * @author tangtanglove <dai_hang_love@126.com>
     */
    public function uploadPicture()
    {
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('file');        
        // 获取上传文件信息
        $getInfo = $file->getInfo();
        // 上传白名单监测
        $this->checkMime($getInfo['type'],config('upload_picture_mime'));
        // 移动到服务器的上传目录 并且使用md5规则
        $getFileInfo = $file->move('./uploads/picture/');
        if (!empty($getFileInfo)) {
            $data['path']    = $this->pathConvert($getFileInfo->getPathname());
            $data['code']    = 1;
            $data['message'] = '上传成功！';
        } else {
            $data['path']    = '';
            $data['code']    = 0;
            $data['message'] = '上传失败！';
        }
        
        return json($data);                
    }

    /**
     * 检测文件上传类型
     * @author tangtanglove <dai_hang_love@126.com>
     */
    private function checkMime($fileMime,$allowMime)
    {
        $result = strpos($allowMime,$fileMime);
        if ($result == false) {
            return $this->error('该文件类型不允许上传！');
        }
    }

    /**
     * thinkphp上传文件bug，临时解决办法
     * @author tangtanglove <dai_hang_love@126.com>
     */
    private function pathConvert($path)
    {
        $path = str_replace('./','/',$path);
        $path = str_replace('\\','/',$path);
        return str_replace('//','/',$path);
    }
}
