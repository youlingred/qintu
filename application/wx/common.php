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
    $mail->SMTPSecure = 'tsl'; 
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

/*
读取导航，不区分二级
 */
function get_nav(){
    $data = Db::name('Navigation')->select();
    $li = "";
    foreach ($data as  $value) {
        $li = $li.'<a style="color:#fff" href="'.url($value['url']).'"><li>'.$value['name'].'</li></a>';
    }
    return $li;
}

/**
 * 或取当前用户是否收藏了该商品，返回图标
 * @return [type] [description]
 */
function wap_collection_ico($id){
    if($id){
        $uid = session('wap_user_auth.uid');
        if($uid){
            $info = Db::name('GoodsCollection')->where(['goods_id'=>$id,'uid'=>$uid])->find();
            if($info){
                return 'collection_big.png';
            }else{
                return "collectionone.png";
            }
        }
        return "collectionone.png";
    }else{
        return "collectionone.png";
    }
    
}

//获取返回json
function curl_file_get_contents($durl){  
    $handle = fopen($durl,"rb");
    $content = "";
    while (!feof($handle)) {
        $content .= fread($handle, 10000);
    }
    fclose($handle);
    // $content = json_encode($content);
    $content = (Array)json_decode($content); 
    return $content;
} 



