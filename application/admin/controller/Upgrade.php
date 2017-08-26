<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: vaey ***************************
// +----------------------------------------------------------------------

namespace app\admin\controller;
use think\Db;
use think\Request;
use think\Loader;

/**
 * 系统升级
 * @author vaey 
 */
class Upgrade extends Common
{
	
	/**
	 * 系统检测首页
	 * @return [type] [description]
	 */
	public function index(){
		
		$url = "http://127.0.0.1/mini/minishop/upgrade.php/index/versionInfo";
        $data = array('version'=>MINISHOP_VERSION);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $res = curl_exec($ch); 
        //出错则显示错误并退出
        curl_errno($ch) && die(curl_error($ch));
        //关闭资源
        curl_close($ch);
        $data = json_decode($res,true);
        $data['can'] = 1;
        //无新版本
        if($data['version']==""){
        	$data["version"] 	= MINISHOP_VERSION;
			$data["content"] 	= "当前版本已是最新版本";
			$data["title"] 		= "暂无新版本";
			$data["can"] 		= 2;
        }
        $this->assign('data',$data);

        return $this->fetch();
		
	}

	/**
	 * 版本还原列表
	 * @return [type] [description]
	 */
	public function lists(){

		$src = ROOT_PATH.'data\system\\';

		$lists = array();
		$file_array = array();
		if(file_exists($src)){
			$dir = opendir($src);
			while(false !== ( $file = readdir($dir)) ) {
			    if (( $file != '.' ) && ( $file != '..' )) {
			     	if(preg_match('/^(system-back-V).*$/', $file)){
			     		 $file_array['name'] = $file;
			     		 $arr = explode("-",$file);
			     		 $file_array['version'] = $arr[2];
			     		 $file_array['time'] = substr($arr[3],0,10);
			     		 $file_array['size'] =  filesize ( $src.$file );

			     		 $lists[] = $file_array;  
			     	}
				}
			}
			closedir($dir);
			
		}
		
		$lists = array_reverse($lists); 
		$this->assign('lists',$lists);
		return $this->fetch();
	}

	/**
	 * 删除备份
	 * @return [type] [description]
	 */
	public function delback(){
		$filename = input('post.filename');
		$src = ROOT_PATH.'data\system\\';
		if(file_exists($src.$filename)){
		    unlink($src.$filename);
		    return $this->success('备份文件删除成功');
		}else{
			return $this->error('指定文件不存在');
		}
	}

	/**
	 * 系统升级开始:下载补丁包
	 * @return [type] [description]
	 */
	public function start(){
		$address = input('post.address');
		//下载安装补丁包
		$resault = $this->downloadNew($address);
		switch ($resault) {
			case '1':
				return $this->error('非法操作','',array('success'=>0));
				break;
			case '2':
				return $this->error('网络连接超时，请稍后重试','',array('success'=>0));
				break;
			case '3':
				return $this->error('创建保存目录失败，请检查权限','',array('success'=>0));
				break;
			case '4':
				return $this->success('补丁包下载完成','',array('success'=>1));
				break;
			default:
				return $this->error('未知错误','',array('success'=>0));
				break;
		}
	}

	/**
	 * 解压补丁包
	 * @return [type] [description]
	 */
	public function extract(){
		$src = ROOT_PATH.'data\upgrade\\';
		// $dst = ROOT_PATH;
		$zip = new \ZipArchive;
		$res = $zip->open($src.'upgrade.zip');
		if ($res === TRUE) {
		    //解压缩到test文件夹
		    $zip->extractTo($src);
		    $zip->close();
		    //判断sql文件是否存在
		    // $this->hasSql($src);
		    unlink($src.'upgrade.zip');
		} else {
		    return $this->error('补丁包解压失败','',array('success'=>0));
		} 
		return $this->success('补丁包解压完成','',array('success'=>1));
	}


	/**
	 * 下载补丁包
	 * @param  [type] $address [description]
	 * @return [type]          [description]
	 */
	public function downloadNew($address){
		if(empty($address)){
			return 1; //连接超时
		}
		$src = ROOT_PATH.'data\upgrade\\';
		$url = "http://127.0.0.1".$address;
		//检测补丁包是否已经存在
		if(file_exists($src.'upgrade.zip')){
		    unlink($src.'upgrade.zip');
		}

		$ch=curl_init();  
        $timeout=5;  
        curl_setopt($ch,CURLOPT_URL,$url);  
        // curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);  
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);  
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);  
        $zip=curl_exec($ch);  
          
        curl_close($ch);
        if(!$zip){
        	return 2; //连接超时
        }

        //创建保存目录
		if(!file_exists($src)&&!mkdir($src,0777,true)){
		    return 3;  //目录不存在,且创建失败
		}  

        $fp2=fopen($src.'upgrade.zip','a');
		fwrite($fp2,$zip);
		fclose($fp2);
		unset($zip,$url);
		return 4; //补丁包下载完成
	}

	/**
	 * 备份源程序
	 * @return [type] [description]
	 */
	public function backSystem(){
		$version = MINISHOP_VERSION;
		$zip = new \ZipArchive();
		if ($zip->open('system.zip', \ZipArchive::OVERWRITE) === TRUE) {
			$this->addFileToZip(ROOT_PATH, $zip); //调用方法，对要打包的根目录进行操作，并将ZipArchive的对象传递给方法
			$zip->close(); //关闭处理的zip文件
		}
		$old_dir = ROOT_PATH."system.zip";

		if(!file_exists($old_dir)){
		    return $this->error('备份失败，请手动备份系统文件');
		}

		$new_dir = ROOT_PATH."data\system\system-back-".$version."-".time().".zip";
		if(!file_exists(ROOT_PATH."data\system")&&!mkdir(ROOT_PATH."data\system",0777,true)){
		   return $this->error("备份文件移动失败,请手动将根目录下system-back-V*.zip文件移动到/data/system目录下");
		}
		@rename($old_dir,$new_dir);
		return $this->success('系统备份完成');
		
	}

	/**
	 * 创建压缩文件
	 * @param [type] $path [description]
	 * @param [type] $zip  [description]
	 */
	public function addFileToZip($path, $zip) {
		$handler = opendir($path); //打开当前文件夹由$path指定。
		/*
		循环的读取文件夹下的所有文件和文件夹
		其中$filename = readdir($handler)是每次循环的时候将读取的文件名赋值给$filename，
		为了不陷于死循环，所以还要让$filename !== false。
		一定要用!==，因为如果某个文件名如果叫'0'，或者某些被系统认为是代表false，用!=就会停止循环
		*/
		$length = mb_strlen(ROOT_PATH,'utf-8');
		while (($filename = readdir($handler)) !== false) {

			if ($filename != "." && $filename != "..") {//文件夹文件名字为'.'和‘..’，不要对他们进行操作
				if (is_dir($path . "/" . $filename)) {// 如果读取的某个对象是文件夹，则递归
					$this->addFileToZip($path . "/" . $filename, $zip);
				} else { //将文件加入zip对象
					if(!preg_match('/^(system-back-V).*$/', $filename)){
						$file = substr($path . "/" . $filename,$length); 
						// echo $path . "/" . $filename."<br>";
						// echo $file."<br>";
						$zip->addFile($path . "/" . $filename,$file);
					}
				}
			}
		}
		// die();
		@closedir($path);
	}

	/**
	 * 判断是否存在sql文件，存在则执行sql升级
	 * @return boolean [description]
	 */
	public function hasSql(){
		$prefix = "mini_";
		$src = ROOT_PATH.'data\upgrade\\';
		if(file_exists($src.'upgrade.sql')){
			//读取sql文件
			$sql = file_get_contents($src.'upgrade.sql');
		    $sql = str_replace("\r", "\n", $sql);
		    $sql = explode(";\n", $sql);

		    //替换表前缀
		    $orginal = config('original_table_prefix');
		    $sql = str_replace($orginal, $prefix, $sql);

		    session('up_sql',$sql);

		    return $this->success('初始化sql文件','',array('sql'=>1));
		}
		
		return $this->success('没有sql文件','',array('sql'=>2));
	}


	public function executeSql($num){
		//更新数据表
		$sql = session('up_sql');
		// $num = input('post.num',0);
		if(empty($num)){
			$num = 0;
		}
		//dump($sql);
		//总数
		$count = count($sql); 
		if($num>=$count){
			session('up_sql',null);
			return ;
		}
		$value = trim($sql[$num]);
		$msg = "";
		if(!empty($value)){
			if(substr($value, 0, 12) == 'CREATE TABLE') {
	            $name = preg_replace("/^CREATE TABLE `(\w+)` .*/s", "\\1", $value);
	            $msg = "新增数据表 {$name} ";
	            if(false !== Db::execute($value)){
	                $msg = $msg.'成功...';
	            }else{
	                $msg = $msg.'失败...';       
	            }
	        }elseif(substr($value, 0, 11) == 'ALTER TABLE'){
	        	$name = preg_replace("/^ALTER TABLE `(\w+)` .*/s", "\\1", $value);
	            $msg = " 修改数据表 {$name} ";
	            if(false !== Db::execute($value)){
	                $msg = $msg.'成功...';
	            }else{
	                $msg = $msg.'失败...';             
	            }
	        } else {
	            Db::execute($value);
	        }
	        $num++;
	        return $this->success($msg,'',array('end'=>1,'num'=>$num));
		}else{
			$num++;
			$this->executeSql($num);
			//执行完毕删除数据库文件
			$src = ROOT_PATH.'data\upgrade\\';
			if(file_exists($src.'upgrade.sql')){
				unlink($src.'upgrade.sql');
			}
			return $this->success('执行完毕','',array('end'=>2,'num'=>$num));
		}
	}


	/**
	 * 解压备份包
	 * @return [type] [description]
	 */
	public function rollback(){
		$filename = input('post.filename');
		$src = ROOT_PATH.'data\system\\';
		// $dst = ROOT_PATH;
		$zip = new \ZipArchive;
		$res = $zip->open($src.$filename);
		if ($res === TRUE) {
		    //解压缩到test文件夹
		    $zip->extractTo($src.'temp\\');
		    $zip->close();
		} else {
			return $this->error('解压失败','',array('success'=>0));
		} 
		return $this->success('解压成功','',array('success'=>1));
	}


	

	

	
}