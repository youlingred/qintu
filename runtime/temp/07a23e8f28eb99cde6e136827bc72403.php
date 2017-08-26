<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:40:"./themes/qintu/index/page_qtlp_lxgp.html";i:1497998110;s:72:"D:\phpStudy\WWW\minishop/application/index\view\public\qintu\header.html";i:1497783158;s:69:"D:\phpStudy\WWW\minishop/application/index\view\public\qintu\nav.html";i:1496493226;s:76:"D:\phpStudy\WWW\minishop/application/index\view\public\qintu\post-lvpai.html";i:1497790705;s:72:"D:\phpStudy\WWW\minishop/application/index\view\public\qintu\footer.html";i:1497781935;}*/ ?>
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
				            <li><a href="<?php echo url('order/orderLists'); ?>">我的旅行</a></li>
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

<?php
	$product1_list=_get_goods_best_list('qtlp_lxgp',6,'sortup');
	$man_list=_get_goods_list('qtlp_lpdr',4,'sortup');
	$product2_list=_get_goods_hot_list('qtlp_lxgp',3,'sortup');
	$product3_list=_get_goods_list('qtlp_lp_bottoms',4,'sortup');
	$post = _get_post_by_name('post-lptc');
?>
<style type="text/css">
	.col-sm-3,
	.col-sm-4 {
		padding-left: 5px;
		padding-right: 5px;
	}
	
	.thumbnail {
		margin-bottom: 10px;
		position: relative;
	}
	.modal-content {
		-webkit-box-shadow: none;
		box-shadow: none;
		border: none;
	}
	
	.btn-circle {
		border-radius: 40px;
	}
	.share_btn {
		position: absolute;
		right: 20%;
		top: 350px;
	}
	.title-one .txt{
		font-size: 14px;
	}
	.caption .c-title {
		font-size: 16px;
	}
	.caption .description{
		font-size: 14px;
	}
	.layui-layer-btn .layui-layer-btn0{
		border-color: #414141;
   		background-color: #414141;
	}
</style>
<img class="img-responsive" src="<?php echo config('theme_path'); ?>/index/images/banner_lxgp.jpg?ver=<?php echo __VERSION__; ?>">
<div class="row section-bg-white section-one">
	<div class="col-md-8 col-md-offset-2 title-one">
		<p class="text-center title" style="margin-top: 20px;"><img src="<?php echo config('theme_path'); ?>/index/images/ico_hsps.png?ver=<?php echo __VERSION__; ?>"></p>
		<p class="text-center txt">独特的视觉为您诠释幸福的意义，用全新的摄影理念，带来不一样的视觉盛宴。</p>
		<div class="row">
			<?php if(is_array($product1_list) || $product1_list instanceof \think\Collection): $i = 0; $__LIST__ = $product1_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
			<div class="col-sm-4">
				<!--<a href="">-->
				<div class="thumbnail">
					<?php if(empty($vo['cover_path']) || ($vo['cover_path'] instanceof \think\Collection && $vo['cover_path']->isEmpty())): ?>
					<img src="<?php echo config('theme_path'); ?>/index/images/Thumbnail_Placeholder.png" alt="<?php echo $vo['name']; ?>"> <?php else: ?>
					<img class="zoomify" src="<?php echo root_path(); ?><?php echo $vo['cover_path']; ?>"><?php endif; ?>
					<p class="item-overlay text-center"><?php echo $vo['label_area']; ?></p>
				</div>
				<!--</a>-->
			</div>
			<?php endforeach; endif; else: echo "" ;endif; ?>
		</div>
		<p class="text-center" style="margin-top: 20px"><button id="notice_btn" type="button" class="btn btn-circle btn-gray" style="width: 150px;">婚纱拍摄套餐</button></p>
		<div id="notice_content" style="display:none"><?php echo $post['content']; ?></div>
	</div>
</div>
</div>
<div class="row section-bg-white section">
	<div class="col-md-8 col-md-offset-2 title-one">
		<p class="text-center title" style="margin-top: 20px;">摄影师会根据您的个性量身打造</p>
		<p class="text-center txt">在亲途旅拍你可以任意选择专业摄影师、化妆师直到找到属于自己的风格。</p>
		<div class="row">
			<?php if(is_array($man_list) || $man_list instanceof \think\Collection): $i = 0; $__LIST__ = $man_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
			<div class="col-sm-3">
				<!--<a href="">-->
				<div class="thumbnail">
					<?php if(empty($vo['cover_path']) || ($vo['cover_path'] instanceof \think\Collection && $vo['cover_path']->isEmpty())): ?>
					<img src="<?php echo config('theme_path'); ?>/index/images/Thumbnail_Placeholder.png" alt="<?php echo $vo['name']; ?>"> <?php else: ?>
					<img src="<?php echo root_path(); ?><?php echo $vo['cover_path']; ?>" alt="<?php echo $vo['name']; ?>"> <?php endif; ?>
					<div class="caption text-center">
						<p class="c-title"><?php echo $vo['name']; ?></p>
						<p class="description"><?php echo $vo['description']; ?></p>
					</div>
				</div>
				<!--</a>-->
			</div>
			<?php endforeach; endif; else: echo "" ;endif; ?>
		</div>

	</div>
</div>
</div>
<div class="row section-bg-white section no-padding">
	<div class="col-md-8 col-md-offset-2 title-one">
		<p class=" title-two">摄影作品
			<a href="<?php echo url('goods/lists?category=qtlp_lxgp'); ?>"><span class="txt-lookmore">更多作品>></span></a></p>
		<div class="row">
			<?php if(is_array($product2_list) || $product2_list instanceof \think\Collection): $i = 0; $__LIST__ = $product2_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
			<div class="col-sm-4">
				<!--<a href="">-->
				<div class="thumbnail">
					<?php  $daren=_get_qtdr_person($vo['share_child_id']);  if(empty($vo['cover_path']) || ($vo['cover_path'] instanceof \think\Collection && $vo['cover_path']->isEmpty())): ?> 
					<img src="<?php echo config('theme_path'); ?>/index/images/Thumbnail_Placeholder.png" alt="<?php echo $vo['name']; ?>"> <?php else: ?>
					<img src="<?php echo root_path(); ?><?php echo $vo['cover_path']; ?>" alt="<?php echo $vo['name']; ?>"> <?php endif; ?>
					<p class="item-overlay text-center">来自<?php echo $daren['name']; ?></p>
				</div>
				<!--</a>-->
			</div>
			<?php endforeach; endif; else: echo "" ;endif; ?>
		</div>
	</div>
</div>
</div>
<div class="row section-bg-white section">
	<div class="col-sm-8 col-sm-offset-2 title-one">
		<p class="text-center title">与您相约在日本婚拍
			<span class="txt-lookmore"><button id="share_btn" type="button" class="btn btn-circle btn-pink">推荐给朋友</button>
				<div id="share_qrcode" class="m-pop-up">
					<p class="m-tt">分享到微信朋友圈</p>
					<div id="qrcode" class="m-ewm"></div>
					<p class="m-ct text-left">打开微信，使用「扫一扫」打开页面后，通过右上角的操作即可分享到朋友圈。</p>
				</div>
			</span>
		</p>
		<p class="text-center txt">亲途与你与他（她）共同完成一次难忘的旅拍。</p>
		
		<div class="row">
			<?php if(is_array($product3_list) || $product3_list instanceof \think\Collection): $i = 0; $__LIST__ = $product3_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
			<div class="col-sm-3">
				<!--<a href="">-->
				<div class="thumbnail">
					<?php if(empty($vo['cover_path']) || ($vo['cover_path'] instanceof \think\Collection && $vo['cover_path']->isEmpty())): ?>
					<img src="<?php echo config('theme_path'); ?>/index/images/Thumbnail_Placeholder.png" alt="<?php echo $vo['name']; ?>"> <?php else: ?>
					<img src="<?php echo root_path(); ?><?php echo $vo['cover_path']; ?>" alt="<?php echo $vo['name']; ?>"> <?php endif; ?>
					<div class="caption text-center">
						<p class="c-title"><?php echo $vo['name']; ?></p>
						<p class="description"><?php echo $vo['description']; ?></p>
					</div>
				</div>
				<!--</a>-->
			</div>
			<?php endforeach; endif; else: echo "" ;endif; ?>
		</div>
	</div>
</div>
</div>
<div class="row section-bg-gray section">
	<div class="col-md-8 col-md-offset-2 title-one text-center">
		<img src="<?php echo config('theme_path'); ?>/index/images/lxgp_banner_2.jpg?ver=<?php echo __VERSION__; ?>" width="100%	">
		<a href="<?php echo url('article/page?name=hsps'); ?>">
			<button type="button" class="btn btn-lg btn-default" style="top: 60%;
    left: 45%;
    position: absolute;
    background: rgba(0,0,0,0.0);
    color: #FFF;">婚纱拍摄</button>
		</a>
	</div>
</div>
<div class="section"></div>

<div class="row section-bg-white section">
	<div class="col-sm-8 col-sm-offset-2 col-lg-6 col-lg-offset-3 title-one">
		<p class="text-center title">立即咨询</p>
		<div class="row">
			<div class="col-sm-8">
					<div class="modal-content">
						<div class="modal-body">
							<form id="form-need" class="person-form" action="<?php echo url('index/postLvpai'); ?>">
								<div class="form-group">
									<label for="name"><span class="txt-red">*</span>姓名</label>
									<input type="text" class="form-control" name="name" placeholder="请输入姓名">
								</div>
								<div class="form-group">
									<label for="name"><span class="txt-red">*</span>手机</label>
									<input type="text" class="form-control" name="mobile" placeholder="请输入手机号">
								</div>
								<div class="form-group">
									<label for="name">微信</label>
									<input type="text" class="form-control" name="weixin" placeholder="请输入微信号">
								</div>
								<div class="form-group">
									<label for="name">备注</label>
									<textarea name="description" rows="2" placeholder="我要咨询旅行跟拍" class="form-control"></textarea>
								</div>
								<div class="form-group"> </div>
								<div class="text-center">
									<button id="submit" type="submit" class="btn btn-gold btn-full" style="margin-top: 10px;"> 提交需求单</button>
								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="col-sm-4">
					<img src="<?php echo config('theme_path'); ?>/index/images/2wm_hp.jpg?ver=<?php echo __VERSION__; ?>" style="margin-top: 40px;"/>
					<p class="text-center">扫描二维码关注微信公众号</p>
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
<script src="<?php echo config('theme_path'); ?>/index/js/page_qtlp_hsps.js?ver=<?php echo __VERSION__; ?>"></script>
<script>
     $(function() {
	$('.zoomify').zoomify();
});
</script>