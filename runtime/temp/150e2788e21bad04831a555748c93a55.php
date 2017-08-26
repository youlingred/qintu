<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:38:"./themes/qintu/index/user_comment.html";i:1499084783;s:72:"D:\phpStudy\WWW\minishop/application/index\view\public\qintu\header.html";i:1497783158;s:69:"D:\phpStudy\WWW\minishop/application/index\view\public\qintu\nav.html";i:1498742819;s:72:"D:\phpStudy\WWW\minishop/application/index\view\public\qintu\footer.html";i:1497781935;}*/ ?>
<!DOCTYPE html>
<html lang="zh">
<head>
	<div style="width:0px;height:0px;overflow:hidden;">
		<img src="<?php echo config('theme_path'); ?>/index/images/4.jpg"/>
	</div>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<meta name="format-detection" content="telephone=no" />
	<title><?php echo config('web_site_title'); ?></title>
	<meta name="description" content="<?php echo config('web_site_description'); ?>" />
	<link rel="shortcut icon" href="<?php echo root_path(); ?>/favicon.ico" />
	<meta name="keywords" content="<?php echo config('web_site_keyword'); ?>" />
	<!-- basic styles -->
		<link href="<?php echo config('theme_path'); ?>/index/css/bootstrap.css" rel="stylesheet">
		<link href="<?php echo config('theme_path'); ?>/index/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css">
		<link href="<?php echo config('theme_path'); ?>/index/css/bootstrap-spinner.min.css" rel="stylesheet" type="text/css">
		<link href="<?php echo config('theme_path'); ?>/index/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css">	
		<link href="<?php echo config('root_path'); ?>/static/plugins/layer/skin/layer.css" rel="stylesheet" type="text/css">
		<link href="<?php echo config('theme_path'); ?>/index/css/zoomify.css" rel="stylesheet" type="text/css">
		<link href="<?php echo config('theme_path'); ?>/index/css/common.css?ver=<?php echo __VERSION__; ?>" rel="stylesheet" type="text/css">

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body> <div class="hidden">
	<img src="<?php echo config('theme_path'); ?>/index/images/about_pic_4.jpg"/>
</div>
<div id="backtotop" class="backtotop">
	<i class="glyphicon glyphicon-circle-arrow-up"></i>
</div>
<nav class="navbar navbar-default navbar-fixed-top">
	<div class="container">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#defaultNavbar1"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
			<a class="navbar-brand" href="<?php echo url('index/index'); ?>"><img src="<?php echo config('theme_path'); ?>/index/images/logo.jpg?ver=<?php echo __VERSION__; ?>"/></a>
		</div>
		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="defaultNavbar1">
			<ul class="nav navbar-nav">
				<?php $__NAV__ = db('navigation')->field(true)->where("hide",0)->order("sort")->select();$__NAV__ = list_to_tree($__NAV__, "id", "pid", "_");if(is_array($__NAV__) || $__NAV__ instanceof \think\Collection): $i = 0; $__LIST__ = $__NAV__;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$nav): $mod = ($i % 2 );++$i;if(isset($nav['_'])): ?>
				<li class="dropdown">
					<a href="#" style="background-color: white;" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $nav['name']; ?><span class="caret"></span></a>
					<ul class="dropdown-menu" style="min-width: 0px; top:80%">
						<?php if(is_array($nav['_']) || $nav['_'] instanceof \think\Collection): $k = 0; $__LIST__ = $nav['_'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?>
						<li style="margin-top: 10px;">
							<a href="<?php echo url($vo['url']); ?>"><?php echo $vo['name']; ?></a>
						</li>
						<?php endforeach; endif; else: echo "" ;endif; ?>
					</ul>
				</li>
				<?php else: ?>
				<li>
					<a href="<?php echo url($nav['url']); ?>"><?php echo $nav['name']; ?></a>
				</li>
				<?php endif; endforeach; endif; else: echo "" ;endif; ?>
			</ul>
			<ul class="nav navbar-nav navbar-right">
						<li>
							<a>4000-530-586</a>
						</li>
						<?php if(session('index_user_auth')): ?>
						<li class="dropdown user-login"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="user-ico glyphicon glyphicon-user" aria-hidden="true"></span><span class="caret"></span></a>
				          <ul class="dropdown-menu" role="menu">
				            <li><a href="<?php echo url('order/orderLists'); ?>">我的预订</a></li>
				            <li class="divider"></li>
				            <li><a href="<?php echo url('common/logout'); ?>">退出</a></li>
				          </ul>
				        </li>
				        <?php else: ?>
						<li>
							<div class="register">
								<a data-toggle="modal" data-target="#user-login">登录</a>
        						<a data-toggle="modal" data-target="#user-reg">注册</a>
							</div>
						</li>
						<?php endif; ?>
					</ul>
		</div>
		<!-- /.navbar-collapse -->
	</div>
	<!-- /.container-fluid -->
</nav>
<div style="height:73px"></div>
<!-- 登录框 -->
<div class="modal fade" id="user-login" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" style="margin-top: 8%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">登录</h4>
      </div>
      <div class="modal-body">
     	 <form id="form-login" role="form" class="reg-login-form" action="<?php echo url('base/login'); ?>">
			<div class="form-group">
				<label for="name">手机号</label>
				<input type="text" class="form-control" id="key" name="key" 
					   placeholder="请输入手机号">
			</div>
			<div class="form-group">
				<label for="name">密码</label>
				<input type="password" class="form-control" id="password" name="password" 
					   placeholder="请输入密码">
			</div>
			<div class="checkbox">
				<label>
				  <input type="checkbox" name="rememberMe" id="rememberMe">记住我
				</label>
			  </div>
			<div class="text-center">
				<button type="submit" class="btn btn-gold btn-full">提交</button>
			</div>
			<div class="form-group">
				<p class="help-block text-left">还没有账号？<span role="button" data-toggle="modal" data-target="#user-reg" data-dismiss="modal" class="btn btn-default" style="position: absolute;right: 20px">注册</span></p>
			</div>
		</form>
   	  </div>	
    </div>
  </div>
</div>
<!-- 登录框结束-->
<!-- 注册框 -->
<div class="modal fade" id="user-reg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel1">注册账号</h4>
      </div>
      <div class="modal-body">
     	 <form id="form-reg" class="reg-login-form" action="<?php echo url('base/register'); ?>">
			<div class="form-group">
				<label for="name">手机号</label>
				<input type="text" class="form-control" name="mobile" 
					   placeholder="请输入手机号">
			</div>
			<div class="form-group">
				<label for="name">昵称</label>
				<input type="text" class="form-control" name="nickname" 
					   placeholder="请输入昵称">
			</div>
			<div class="form-group">
				<label for="name">密码</label>
				<input type="password" class="form-control" name="password" 
					   placeholder="请输入密码">
			</div>
			<div class="form-group">
				<label for="name">确认密码</label>
				<input type="password" class="form-control" name="repassword" 
					   placeholder="请再次输入密码">
			</div>
			<div class="form-group">
				<p class="help-block text-center">我已阅读并同意<span class="txt-red">亲途旅行的隐私政策</span></p>
			</div>
			<div class="text-center">
				<button type="submit" class="btn btn-gold btn-full">注册</button>
			</div>
			<div class="form-group">
				<p class="help-block text-center">已有亲途账号?<span role="button" class="txt-red" data-toggle="modal" data-target="#user-login" data-dismiss="modal">登录</span></p>
			</div>
		</form>
   	  </div>
    </div>
  </div>
</div>
<!-- 注册框结束-->
<!-- 加入心愿单提示框-->
<div class="modal fade" id="add-success" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1">
  <div class="modal-dialog" role="document" style="margin-top: 8%;">
    <div class="modal-content">
      <div class="modal-header" style="border-bottom:none;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
			<div class="form-group text-center">
				<img src="<?php echo config('theme_path'); ?>/index/images/ico_alert_success.png">
			</div>
			<div class="form-group">
				<p class="help-block text-center">可在<span class="txt-red">我的旅行</span>中提交所有心愿行程</p>
				<!--<p class="help-block text-center">我们会在<span class="txt-red">2小时之内</span>与您取得联系</p>-->
			</div>
			<div class="text-center">
				<button id="go_on" class="btn btn-gold btn-lg" style="width:200px">继续逛逛</button>
				<button id="lookOrder_1" class="btn btn-gold btn-lg" style="width:200px">查看我的全部心愿</button>
			</div>
			<div class="form-group">
				
			</div>
   	  </div>
    </div>
  </div>
</div>
<!-- 加入心愿单提示框结束-->
<!-- 提交需求单提示框-->
<div class="modal fade" id="need-success" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1">
  <div class="modal-dialog" role="document" style="margin-top: 8%;">
    <div class="modal-content">
      <div class="modal-header" style="border-bottom:none;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
			<div class="form-group text-center">
				<img src="<?php echo config('theme_path'); ?>/index/images/ico_alert_success.png">
			</div>
			<div class="form-group">
				<h3 class="text-center">恭喜您提交成功</h3>
				<p class="help-block text-center">我们会在<span class="txt-red">2小时之内</span>与您取得联系</p>
			</div>
			<div class="text-center">
				<button id="go_on_need" class="btn btn-gold btn-lg" style="width:200px">继续逛逛</button>
			</div>
			<div class="form-group">
				
			</div>
   	  </div>
    </div>
  </div>
</div>
<!-- 提交需求单提示框结束-->
 <?php  $serverList=_get_posts_by_term('user_server_list'); $notice=_get_post_by_name('user_notice');  ?>
<link href="<?php echo config('theme_path'); ?>/index/css/user_center.css" rel="stylesheet">
<div class="row section-bg-gray section">
	<div class="col-md-6 section-bg-white col-md-offset-3 title-one" style="padding: 40px">
		<div class="row">
			<div class="col-sm-3 text-center">
				<img src="<?php echo config('theme_path'); ?>/index/images/user_ico.png" style="margin-top: 30px" alt="" />
				<p><?php echo session('index_user_auth.nickname'); ?></p>
				<a href="<?php echo url('common/logout'); ?>"><button type="button" class="btn-orders btn btn-default">退出</button></a>
				<div class="form-group" style="position: relative;margin-top: 30px;">
					<hr>
					<span style="position: absolute;top:-15px;left: 29%; font-size: 20px">服务流程</span>
				</div>
				<ul class="list-group list-no-border">
					<?php if(is_array($serverList) || $serverList instanceof \think\Collection): $k = 0; $__LIST__ = $serverList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?>
					<li class="list-group-item">
						<span class="badge badge-gold" style="float: left;"><?php echo $k; ?></span> <?php echo $vo['content']; ?>
					</li>
					<?php endforeach; endif; else: echo "" ;endif; ?>
				</ul>
				<div class="text-left">
					<label class="label-nobg">
					特别提示：
				</label>
				</div>
				<div class="text-left">
					<label class="label-nobg">
					<?php echo $notice['content']; ?>
				</label>
				</div>
			</div>
			<div class="col-sm-9" style="overflow: hidden;">
				<!--我的评论 start-->
					<div class="user-center" style="margin-left: 0;">
						<p class="user-title"><span>我要评论</span></p>
						<div class="user-content user-content-center">
							<!--不同部分 start-->
							<div class="row">
								<div class="col-xs-12 text-center">
									<div>
										<a href="<?php echo url('goods/detail',['id'=>$postInfo['goods_id']]); ?>">
											<?php
												$cover_path=get_product_cover_path($postInfo['goods_id']);
												
												if(empty($cover_path) || ($cover_path instanceof \think\Collection && $cover_path->isEmpty())): ?>
											<img src="<?php echo config('theme_path'); ?>/index/images/Thumbnail_Placeholder.png" class="img-thumbnail" /> <?php else: ?>
											<img src="<?php echo root_path(); ?><?php echo $cover_path[0]; ?>" class="img-thumbnail" /> <?php endif; ?>
										</a>
										<p class="title-two" style="margin: 20px 0 20px;"><?php echo $postInfo['name']; ?></p>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-9 ">
								<div class="comment">
									<div class="star_ul">
										<!--             <span class="s_name">总体评价：</span> -->
										<ul class="star_ul fl">
											<li>
												<a class="one-star" id="1" title="很差"></a>
											</li>
											<li>
												<a class="two-star" id="2" title="差"></a>
											</li>
											<li>
												<a class="three-star" id="3" title="还行"></a>
											</li>
											<li>
												<a class="four-star" id="4" title="好"></a>
											</li>
											<li>
												<a class="five-star" id="5" title="很好"></a>
											</li>
										</ul>
										<span class="s_result fl">请打分</span>
									</div>

								</div>
								<div style="margin-top:30px">
									<form action="" method="POST">
										<textarea class="comment-area" id="content" onkeyup="ta(this)" maxlength="100" title="最多可输入100个字符" placeholder="请输入评论的内容......"></textarea>
									</form>
								</div>

							</div>
							</div>
							
							<input type="hidden" id="order_id" value="<?php echo $postInfo['order_id']; ?>" />
							<input type="hidden" id="goods_id" value="<?php echo $postInfo['goods_id']; ?>" />
							<input type="hidden" id="score" value="" />
							<button type="button" id="submit" class="  collection_btn" style="margin-top:50px;margin-left: initial;">发表评论</button>
							<!--不同部分 end-->
						</div>
					

				<!--我的评论 end-->
			</div>
		</div>
	</div>
</div>
</div>
<div class="section"></div>
<div class="row section-bg-footer section" style="padding-bottom: 20px;">
	<footer class="text-center">
		<h6>@2017 All rights reserved Powered by Japan Health Tech </h6>
		<h6><?php echo config('web_site_icp'); ?></h6></footer>
</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="<?php echo config('theme_path'); ?>/index/js/jquery-1.11.3.min.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="<?php echo config('theme_path'); ?>/index/js/bootstrap.js"></script>
<script src="<?php echo config('theme_path'); ?>/index/js/bootstrap-datetimepicker.min.js"></script>
<script src="<?php echo config('theme_path'); ?>/index/js/locales/bootstrap-datetimepicker.zh-CN.js"></script>
<script src="<?php echo config('theme_path'); ?>/index/js/bootstrapValidator.min.js"></script>
<script src="<?php echo config('theme_path'); ?>/index/js/jquery.spinner.min.js"></script>
<script src="<?php echo config('theme_path'); ?>/index/js/jquerysession.js"></script>
<!--<script src="<?php echo config('theme_path'); ?>/index/js/bootstrap-suggest.js"></script>-->
<!--<script src="<?php echo config('theme_path'); ?>/index/js/search.js"></script>-->
<script src="STATIC_PATH/plugins/layer/layer.js"></script>
<script src="STATIC_PATH/plugins/qrcode/jquery.qrcode.min.js"></script>
<script src="<?php echo config('theme_path'); ?>/index/js/zoomify.min.js"></script>
<script src="<?php echo config('theme_path'); ?>/index/js/common.js?ver=<?php echo __VERSION__; ?>"></script>
<!--<script src="<?php echo config('theme_path'); ?>/index/js/share.js?ver=<?php echo __VERSION__; ?>"></script>-->
<script type="text/javascript">
	var $login_url="<?php echo url('index/islogin'); ?>";
	var $orders_url="<?php echo url('order/orderLists'); ?>";
	var $addCart_url="<?php echo url('cart/addXyd'); ?>";
	var $postCart_url="<?php echo url('cart/postXyd'); ?>";
	var $orderNum_url="<?php echo url('order/getOrdersNoAddNum'); ?>";
	var $cartDel_url="<?php echo url('cart/delete'); ?>";
	var $orderDel_url="<?php echo url('order/cancel'); ?>";
</script>
	</body>
</html>
<script type="text/javascript">
$(function(){
  
  $('.star_ul a').click(function(){
    $('.star_ul a').removeClass('active-star');
    $(this).addClass('active-star');
    $('.s_result').css('color','#c00').html($(this).attr('title'))
    $('#score').val($(this).attr('id'));

  });  
})
</script>
<script type="text/javascript">
  function ta(obj){
    var val=$(obj).val().length;
    if(val==200){
      alert("至多输入200个字符！");
      $(obj).val($(obj).val().substring(0,100))
      }
  }
</script>
<script type="text/javascript" language="javascript">
// 提交数据
$(function(){
  $("#submit").click(function(){
    var goods_id  =$("#goods_id").val();
    var order_id  =$("#order_id").val();
    var content   =$("#content").val();
    var score     =$("#score").val();
  $.ajax({
     type:'post',
     url:"<?php echo url('comment/orderComment'); ?>",
     data:{"goods_id" :goods_id,
           "order_id" :order_id,
           "content"  :content,
           "score"    :score,
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
<script type="text/javascript">
	$('.del_cart_btn').click(function() {
		var cart = {
			id: $(this).attr('data-orderid'),
			type: 2,
		}
		delCart($(this), cart);
	});
	$('.del_order_btn').click(function() {
		var order = {
			id: $(this).attr('data-orderid'),
			type: 2,
		}
		delOrder($(this), order);
	});
	$('#post_btn').click(function() {
		var carts = new Array();

		$(".order_no_elem").each(function(key, value) {
			carts.push({
				cart_id: $(value).attr("data-id"),
				goods_id: $(value).attr("data-goods-id"),
				name: $(value).attr("data-name"),
				departure_time: $(this).attr('data-departure-time'),
				man_num: $(this).attr('data-man-num'),
				child_num: $(this).attr('data-child-num')
			});

		});
		postCarts(carts);
	});
	$('#go_on_need').click(function() {
		$('#need-success').modal('hide');
		window.location.reload();
	});
</script>