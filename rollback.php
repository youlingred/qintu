<?php 


	//定义根目录
	$file_path = $_SERVER["SCRIPT_FILENAME"];
	$root = strstr($file_path, 'rollback', true);

	copyToBack($root);

	$arr["msg"]="还原成功";
	$arr["code"]="1";
	$j_arr=json_encode($arr);
	echo $j_arr;

/**
 * 拷贝备份文件覆盖源程序文件
 * @param  [type] $src [description]
 * @param  [type] $dst [description]
 * @return [type]      [description]
 */
function copyToBack($root){
	$src = $root.'data\system\temp\\';
	$dst = $root;
	copy_dir($src,$dst);
	unlink_file($src);
}


/**
 * 拷贝补丁文件覆盖源程序文件
 * @param  [type] $src [description]
 * @param  [type] $dst [description]
 * @return [type]      [description]
 */
function copy_dir($src,$dst){
	$dir = opendir($src);
	@mkdir($dst);
	while(false !== ( $file = readdir($dir)) ) {
	    if (( $file != '.' ) && ( $file != '..' )) {
	      	if ( is_dir($src . '/' . $file) ) {
		        copy_dir($src . '/' . $file,$dst . '/' . $file);
		        continue;
		    }else{
		        copy($src.'/'.$file,$dst.'/'.$file);
		    }
		}
	}
	closedir($dir);
}


function unlink_file($dir){
  	//先删除目录下的文件：
  	$dh=opendir($dir);
  	while ($file=readdir($dh)) {
    	if($file!="." && $file!="..") {
      		$fullpath=$dir."/".$file;
      		if(!is_dir($fullpath)) {
          		unlink($fullpath);
      		} else {
          		unlink_file($fullpath);
      		}
    	}
  	}
  	closedir($dh);
  	//删除当前文件夹：
  	if(rmdir($dir)) {
    	return true;
  	} else {
    	return false;
  	}
}



?>