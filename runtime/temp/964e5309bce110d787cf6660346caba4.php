<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:32:"./themes/qintu/wap/register.html";i:1496323753;}*/ ?>
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
			<h1 class="mui-title" style="color:#cda62f">会员注册</h1>
		</header>
		<!-- 头部结束 -->
		<div class="mui-content">
		  <div class="main">
		   <!--<div class="head">
		   	 <a href="<?php echo url('index/index'); ?>"><img  src="<?php echo config('theme_path'); ?>/wap/images/logo1.png" ></a><a href="<?php echo url('base/register'); ?>"><span class="line_left">会员注册</span></a>
		   </div>-->
		   <form action="" method="POST">
		   <div class="input-login" style="margin-top:60px;">
		   	<div style="margin-top:-5px !important">
					<input type="text" id="mobile" class="pass-img prev-check-mobile" placeholder="请输入手机号" />
			</div>
			<div style="margin-top:-5px !important">
					<input type="text" id="nickname" class="pass-img prev-user" placeholder="请输入昵称" />
			</div>
			<div  style="margin-top:-5px !important">
					<input type="password" id="password" class="pass-img prev-pass" placeholder="请输入密码" />
			</div>
			<div  style="margin-top:-5px !important">
					<input type="password" id="repassword" class="pass-img prev-pass" placeholder="请再次输入密码" />
			</div>
			<!--<div  style="margin-top:-5px !important">
					<input type="text" id="pic_code" class="pass-img prev-check-mobile" style="width:60%;" placeholder="请输入图形验证码" /><img  class="pic-img" src="<?php echo url('base/captcha'); ?>" onclick="this.src='<?php echo url('base/captcha'); ?>?rand='+Math.random()" style="cursor:pointer" title="点击刷新">
			</div>
			<div >
					<input type="text" class="pass-img prev-mobile" id="mobile" placeholder="请输入你的手机号">
			</div>
			<div  style="margin-top:-5px !important">
					<input type="text" id="sms_code" class="pass-img prev-check-mobile" style="width:60%;" placeholder="请输入手机验证码" /><input type="button"class="pass-img sms-button" onclick="sendSms()" style="padding-left:10px !important;font-size:10px!important;" value="发送验证码" />
			</div>
			
			<div class="read">
               <input type="checkbox" aria-label="..." >&nbsp;&nbsp;<span>我已阅读并遵守协议</span><span class="read_member" style="margin-left:20px">用户协议</span>
           </div>-->
			<input type="button" class="login-button" id="submit" value="注册" />
			</div>
		   </form>

			<div class="account">
				<span style="color:#888888">已有账号</span><a href="<?php echo url('base/login'); ?>"><span style="margin-left:10px;color:#cda62f">马上登录</span></a>
			</div>
			
		  		
		<!-- 底部 -->
		<div style='height: 10px;'></div>
			<div style='height: 80px; margin-top:70px; text-align: center;'>
				<!--<p><a>联系我们</a>&nbsp;&nbsp;&nbsp;&nbsp;<a>企业介绍</a></p>
				<p>copyright 2016&nbsp;&nbsp; 珍良缘农副食品超商有限公司</p>-->
			</div>
			<div style='height: 10px;'></div>
		</div>
		</div>
		<!-- 底部结束 -->

<script src="<?php echo config('theme_path'); ?>/wap/js/jquery-1.11.3.min.js"></script>
<script type="text/javascript">
  //验证码
  function get_code(){
    $("#get_code").removeClass("disabled");
  }
</script>

<script type="text/javascript">

	$('.show-nav').click(function(){
		$('#h-nav').slideToggle();
   })

//获取手机验证码
function sendSms(){
  var mobile   = $("#mobile").val();
  var pic_code = $("#pic_code").val();
    if(verifymobile(mobile) == false){
      alert('请填写正确的手机号码')
      return false
    }
    $.ajax({
      type:"post",
      url:"<?php echo url('alidayu/index'); ?>",
      data:{"mobile":mobile,"captcha":pic_code},
      dataType:"json",
      success: function(res){
             if(res.code == 0 )
                   {
                     alert(res.msg);
                   
                   } else{
                        
                          var wait = 60;
                           $(".sms-button").val((--wait) + "秒后重新发送");
                             var time_line = setInterval(function(){
                             if(wait == 0)
                             {
                            
                             $(".sms-button").val("获取手机验证码");
                             return clearInterval(time_line);
                           }
                           else
                           {
                             $(".sms-button").val((--wait) + "秒后重新发送"); 
                           }    
                             },1000);
             alert(res.msg);            
             }
           
               }
                 });
  
}
//手机号验证
function verifymobile(mobile){
  var phone = /^13[0-9]{1}[0-9]{8}$|15[0-9]{1}[0-9]{8}$|18[0-9]{1}[0-9]{8}$|17[0-9]{9}$/;
    if(!phone.test(mobile)){
      return false
    }
}


 </script>

<script type="text/javascript" language="javascript">
// 提交数据
$(function(){
  $("#submit").click(function(){
    var mobile   =$("#mobile").val();
    var nickname   =$("#nickname").val();
    var password  =$("#password").val();
    var repassword=$("#repassword").val();
  $.ajax({
     type:'post',
     url:"<?php echo url('base/register'); ?>",
     data:{"mobile":mobile, 
          "nickname":nickname,
          "password":password,
           "repassword":repassword,
     },
     dataType:'json',
     success: function(data) {
                if (data.code) {
            alert(data.msg);
          setTimeout(function () {
          location.href = data.url;
        }, 1000);
        } else {
            alert(data.msg);
        }
        },
        error: function(request) {
                alert("页面错误");
      }
  });
  
   })
})

</script>
	</body>

</html>