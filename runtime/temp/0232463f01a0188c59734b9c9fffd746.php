<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:65:"D:\phpStudy\WWW\minishop/application/index\view\public/error.html";i:1490584771;}*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0" />
<title>错误</title>

<link type="text/css" rel="stylesheet" href="STATIC_PATH/404/css/404.css" />

<!--[if IE 6]>
<script src="js/png.js"></script>
<script>DD_belatedPNG.fix('*')</script>
<![endif]-->

</head>
<body>

<div id="wrap">
	<div style="text-align:center">
		<span style="font-size:50px;color:#fff">抱歉,出错啦!</span>
	</div>
	<div style="text-align:center">
			<p class="error" style="font-size:30px;color:#fff"><?php echo($msg); ?></p>
			<p class="detail"></p>
			<p class="jump" style="font-size:20px;color:#fff">
			<b id="wait" ><?php echo($wait); ?></b> 秒后页面将自动跳转
			</p>
	</div>
	<div id="text">
		<strong>
			<a id="href" id="btn-now" href="<?php echo($url); ?>">立即跳转</a>
			<a href="#" id="btn-stop" type="button" onclick="stop()">停止跳转</a>
		</strong>
	</div>
</div>

<div class="animate below"></div>
<div class="animate above"></div>
<div style="text-align:center;">
</div>
<script type="text/javascript">
(function(){
 var wait = document.getElementById('wait'),href = document.getElementById('href').href;
 var interval = setInterval(function(){
     	var time = --wait.innerHTML;
     	if(time <= 0) {
     		location.href = href;
     		clearInterval(interval);
     	};
     }, 1000);
  window.stop = function (){
         console.log(111);
            clearInterval(interval);
 }
 })();
</script>
</body>
</html>
