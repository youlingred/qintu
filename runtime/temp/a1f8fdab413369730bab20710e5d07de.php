<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:29:"./themes/qintu/wap/login.html";i:1496324199;}*/ ?>
<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<title><?php echo config('web_site_title'); ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">

		<!--标准mui.css-->
		<link rel="stylesheet" href="<?php echo config('theme_path'); ?>/wap/css/mui.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo config('theme_path'); ?>/wap/css/icons-extra.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo config('theme_path'); ?>/wap/css/login.css" />
		
	</head>

	<body>

		<style>
			.mui-control-content {
				background-color: white;
				min-height: 215px;
			}
			.mui-control-content .mui-loading {
				margin-top: 50px;
			}			
		</style>
		<div id="h-nav" style="position:fixed;top:45px;background:#000;z-index:9999;color:#fff;width:100%;height:100%;filter:alpha(opacity=80); -moz-opacity:0.8;-khtml-opacity: 0.8; opacity: 0.8;display:none">
			<ul style="list-style:none;margin-left:20px;line-height:250%">
				<?php echo get_nav(); ?>
			</ul>
		</div>
		<!-- 头部 -->
		<header class="mui-bar mui-bar-nav" style="background: #F9F9F9;">
			<!--<a onclick="history.go(-1)" class="mui-icon mui-icon-left-nav mui-pull-left" style="color: #FF6600;"></a>
			<a class="mui-icon mui-icon-extra mui-icon-extra-class mui-pull-right show-nav" style="color: #FF6600;"></a>-->
			<h1 class="mui-title" style="color:#cda62f">会员登录</h1>
		</header>
		<!-- 头部结束 -->
		<div class="mui-content" style="height:200px">
		  <div class="main">
		   <!--<div class="head">
		   	 <a href='#'><img src="<?php echo config('theme_path'); ?>/wap/images/logo1.png" height=25 style=''></a><a href="<?php echo url('base/login'); ?>"><span class="line_left">会员登录</span></a>
		   </div>-->
		   <form action="" method="POST">
		   <div  style="margin-top:60px;">
		   	<div>
				<input type="text" class="pass-img  prev-check-mobile"id="key" placeholder="请输入手机号">
			</div>
			<div style="margin-top:-5px !important" >
					<input type="password" id="password" class="pass-img prev-pass" style="height:60px;padding-left:50px;" placeholder="请输入密码">
			</div>


		   </div>

		   <button type="button" class="login-button" id="submit" >登录</button>

		   </form>
			<div class="forget-pass">
				<!--<a href="<?php echo url('base/getPassword'); ?>"><span >忘记密码?</span></a>--><a href="<?php echo url('base/register'); ?>"><span style="float:right">免费注册</span></a>
			</div>

	<!-- 		<div style="margin-top:50px">
			<p style="text-align:center">使用第三方登录</p>
			
			<div class="login_index">
            <a href="<?php echo url('OpenAuth/login',['type' => 'sina']); ?>"  target="_blank"><img src="<?php echo config('theme_path'); ?>/wap/images//wb.png" /></a>
            <a href="<?php echo url('OpenAuth/login',['type' => 'wechat']); ?>" target="_blank"><img src="<?php echo config('theme_path'); ?>/wap/images//wx.png" /></a>
            <a href="<?php echo url('OpenAuth/login',['type' => 'qq']); ?>"  target="_blank"><img src="<?php echo config('theme_path'); ?>/wap/images//qq.png" /></a></div>
			</div> -->		
		  
		
		<!-- 底部 -->
		<div style='height: 10px;'></div>
			<div style='height: 80px; margin-top:100px; text-align: center;'>
				<!--<p><a>联系我们</a>&nbsp;&nbsp;&nbsp;&nbsp;<a>企业介绍</a></p>
				<p>copyright 2016 &nbsp;&nbsp;珍良缘农副食品超商有限公司</p>-->
			</div>
			<div style='height: 10px;'></div>
			
		<!-- 底部结束 -->
	</div>
	</div>

<script src="<?php echo config('theme_path'); ?>/wap/js/jquery-1.11.3.min.js"></script>
<script type="text/javascript">

  $('.show-nav').click(function(){
		$('#h-nav').slideToggle();
  })

  $('#submit').click(function(){
  var key = $("#username").val();
  var password = $("#password").val();
  if(key ==""||key =="请输入手机号/用户名")
  {
     alert("请输入手机号或用户名");
     return false;  
  }
  if(password ==""||password =="请输入密码")
  {
     alert("请输入密码");
     return false;  
  }
  $.ajax({
    type:"post",
    url:"<?php echo url('base/login'); ?>",
    data:{"key":key,"password":password},
    dataType:'json',
    success: function(data) {
            if (data.code) {
              $('#submit').text('登录中...')
              setTimeout(function () {
                location.href = data.url;
              }, 1000);
            } else {
              alert(data.msg);
            }

          },
          error: function(request) {
            alert("页面错误");
          },
     });



});
</script>

	</body>

</html>