<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:31:"./themes/qintu/index/index.html";i:1501382476;s:72:"D:\phpStudy\WWW\minishop/application/index\view\public\qintu\header.html";i:1497783158;s:69:"D:\phpStudy\WWW\minishop/application/index\view\public\qintu\nav.html";i:1498742819;s:72:"D:\phpStudy\WWW\minishop/application/index\view\public\qintu\banner.html";i:1496051614;s:72:"D:\phpStudy\WWW\minishop/application/index\view\public\qintu\footer.html";i:1497781935;}*/ ?>
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
<body>
<div class="hidden">
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

<div id="carousel" class="carousel slide" data-ride="carousel">
	<ol class="carousel-indicators">
		<?php $__BANNER__ = db("banner")
        ->alias("a")
        ->join("banner_position b","b.id= a.position","LEFT")        
        ->where("a.status",1)->where("a.position",1)
        ->order("a.createtime")->select();if(is_array($__BANNER__) || $__BANNER__ instanceof \think\Collection): if( count($__BANNER__)==0 ) : echo "" ;else: foreach($__BANNER__ as $key=>$banner): ?>
		<li data-target="#carousel" data-slide-to="<?php echo $key; ?>" class="<?php if($key == '0'): ?>active<?php endif; ?>"></li>
		<?php endforeach; endif; else: echo "" ;endif; ?>
	</ol>
	<div class="carousel-inner" role="listbox">
		<?php $__BANNER__ = db("banner")
        ->alias("a")
        ->join("banner_position b","b.id= a.position","LEFT")        
        ->where("a.status",1)->where("a.position",1)
        ->order("a.createtime")->select();if(is_array($__BANNER__) || $__BANNER__ instanceof \think\Collection): if( count($__BANNER__)==0 ) : echo "" ;else: foreach($__BANNER__ as $key=>$banner): ?>
		<div class="item <?php if($key == '0'): ?>active<?php endif; ?>">
			<a href="<?php echo url($banner['link']); ?>"><img class="center-block img-responsive" src="<?php echo root_path(); ?><?php echo $banner['banner_path']; ?>"> 
		</div>
		<?php endforeach; endif; else: echo "" ;endif; ?>
	</div>
	<a class="left carousel-control" href="#carousel" role="button" data-slide="prev"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span><span class="sr-only">Previous</span></a>
	<a class="right carousel-control" href="#carousel" role="button" data-slide="next"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span><span class="sr-only">Next</span></a>
</div>
<?php
	$qdz_hot_list=_get_goods_hot_list('qdz',9,'sortup');
	$qtdr_hot_list=_get_goods_hot_list('qtdr',4,'sortup');
	$fx_hot_list=_get_goods_best_list('qtlp_hsps',3,'sortup');
	$ztdz_hot_list=_get_goods_hot_list('ztdz',3,'sortup');
	$qdz_length=count($qdz_hot_list);
?>
<div class="row section-bg-white section">
	<div class="col-md-8 col-md-offset-2 title-one">
		  <p class="text-center title">跨境分享结交良师益友</p>
		  <p class="text-center txt">告别走马观花，这里只有纯粹的生活方式，让你深入民间结交朋友，有空来亲途看看。</p>
		  <p class=" title-two">推荐分享 <a href="<?php echo url('goods/lists?category=qdz_area_all|qdz_tese_all'); ?>"><span class="txt-lookmore">查看更多>></span></p>
	  <div class="row">
	  	<div id="carousel1" class="carousel slide" data-ride="carousel">	
			<div class="carousel-inner" role="listbox">
				<?php $__FOR_START_24459__=0;$__FOR_END_24459__=$qdz_length;for($i=$__FOR_START_24459__;$i < $__FOR_END_24459__;$i+=3){ ?>
				<div class="item <?php if($i == '0'): ?>active<?php endif; ?>">
						<?php if($i < $qdz_length): ?>
							<div class="col-sm-4">
							  <a href="<?php echo url('goods/detail?id='.$qdz_hot_list[$i]['id']); ?>">
							  <div class="thumbnail">
							  	<?php if(empty($qdz_hot_list[$i]['cover_path']) || ($qdz_hot_list[$i]['cover_path'] instanceof \think\Collection && $qdz_hot_list[$i]['cover_path']->isEmpty())): ?>
									<img src="<?php echo config('theme_path'); ?>/index/images/Thumbnail_Placeholder.png" alt="<?php echo $qdz_hot_list[$i]['name']; ?>">
								<?php else: ?>
							    	<img src="<?php echo root_path(); ?><?php echo $qdz_hot_list[$i]['cover_path']; ?>" alt="<?php echo $qdz_hot_list[$i]['name']; ?>">
							    <?php endif; ?>
								<div class="caption text-center">
								  <p class="c-title"><?php echo $qdz_hot_list[$i]['name']; ?></p>	
								  <p class="description"><?php echo $qdz_hot_list[$i]['description']; ?></p>
								</div>
							  </div>
							  </a>
							</div>
						<?php endif; if(($i+1) < $qdz_length): ?>
							<div class="col-sm-4">
							  <a href="<?php echo url('goods/detail?id='.$qdz_hot_list[$i+1]['id']); ?>">
							  <div class="thumbnail">
							  	<?php if(empty($qdz_hot_list[$i+1]['cover_path']) || ($qdz_hot_list[$i+1]['cover_path'] instanceof \think\Collection && $qdz_hot_list[$i+1]['cover_path']->isEmpty())): ?>
									<img src="<?php echo config('theme_path'); ?>/index/images/Thumbnail_Placeholder.png" alt="<?php echo $qdz_hot_list[$i+1]['name']; ?>">
								<?php else: ?>
							    	<img src="<?php echo root_path(); ?><?php echo $qdz_hot_list[$i+1]['cover_path']; ?>" alt="<?php echo $qdz_hot_list[$i+1]['name']; ?>">
							    <?php endif; ?>
								<div class="caption text-center">
								  <p class="c-title"><?php echo $qdz_hot_list[$i+1]['name']; ?></p>	
								  <p class="description"><?php echo $qdz_hot_list[$i+1]['description']; ?></p>
								</div>
							  </div>
							  </a>
							</div>
						<?php endif; if(($i+2) < $qdz_length): ?>
							<div class="col-sm-4">
							  <a href="<?php echo url('goods/detail?id='.$qdz_hot_list[$i+2]['id']); ?>">
							  <div class="thumbnail">
							  	<?php if(empty($qdz_hot_list[$i+2]['cover_path']) || ($qdz_hot_list[$i+2]['cover_path'] instanceof \think\Collection && $qdz_hot_list[$i+2]['cover_path']->isEmpty())): ?>
									<img src="<?php echo config('theme_path'); ?>/index/images/Thumbnail_Placeholder.png" alt="<?php echo $qdz_hot_list[$i+2]['name']; ?>">
								<?php else: ?>
							    	<img src="<?php echo root_path(); ?><?php echo $qdz_hot_list[$i+2]['cover_path']; ?>" alt="<?php echo $qdz_hot_list[$i+2]['name']; ?>">
							    <?php endif; ?>
								<div class="caption text-center">
								  <p class="c-title"><?php echo $qdz_hot_list[$i+2]['name']; ?></p>	
								  <p class="description"><?php echo $qdz_hot_list[$i+2]['description']; ?></p>
								</div>
							  </div>
							  </a>
							</div>
						<?php endif; ?>
					</div>
				<?php } ?>
			</div>
			<a class="left carousel-control" style="left:-100px;color: #6D6666;" href="#carousel1" role="button" data-slide="prev"><span class="glyphicon glyphicon-chevron-left" style="margin-top: -50px;" aria-hidden="true"></span><span class="sr-only">Previous</span></a>
			<a class="right carousel-control" style="right:-100px;color: #6D6666" href="#carousel1" role="button" data-slide="next"><span class="glyphicon glyphicon-chevron-right" style="margin-top: -50px;" aria-hidden="true"></span><span class="sr-only">Next</span></a>
		</div>
	</div>
	  <p class=" title-two">推荐达人<a href="<?php echo url('goods/lists?category=qtdr_area_all|qtdr_tese_all'); ?>"><span class="txt-lookmore">查看更多>></span></p>
		  <div class="row">
			<?php if(is_array($qtdr_hot_list) || $qtdr_hot_list instanceof \think\Collection): $i = 0; $__LIST__ = $qtdr_hot_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
			<div class="col-sm-3">
			  <a href="<?php echo url('goods/detail?id='.$vo['id']); ?>">
			  <div class="thumbnail">
			  	<?php if(empty($vo['cover_path']) || ($vo['cover_path'] instanceof \think\Collection && $vo['cover_path']->isEmpty())): ?>
					<img src="<?php echo config('theme_path'); ?>/index/images/Thumbnail_Placeholder.png" alt="<?php echo $vo['name']; ?>">
				<?php else: ?>
	            	<img src="<?php echo root_path(); ?><?php echo $vo['cover_path']; ?>" alt="<?php echo $vo['name']; ?>">
	            <?php endif; ?>
				<div class="caption text-center">
				  <p class="c-title"><?php echo $vo['name']; ?></p>	
				  <p class="description"><?php echo $vo['description']; ?></p>
				</div>
			  </div>
			  </a>
			</div>
			<?php endforeach; endif; else: echo "" ;endif; ?>
		  </div>
</div>
</div>
<div class="row section-bg-gray section">
  <div class="col-md-8 col-md-offset-2 title-one">
    <p class="text-center title">不简单的是旅行<!--<a href="<?php echo url('article/page?name=srdz'); ?>"><span class="txt-lookmore"><button type="button" class="btn btn-lg btn-gold">预约我的旅行</button></span></a>--></p>
    <p class="text-center txt">在亲途还可以做很多事，我们只会为您精选日本最好的服务与产品，您差的只是一张机票而已。</p>
    <div class="row">
    <?php if(is_array($ztdz_hot_list) || $ztdz_hot_list instanceof \think\Collection): $i = 0; $__LIST__ = $ztdz_hot_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
			<div class="col-sm-4">
	  <!--<a href="">-->
	  <div class="thumbnail">
	  	<?php if(empty($vo['cover_path']) || ($vo['cover_path'] instanceof \think\Collection && $vo['cover_path']->isEmpty())): ?>
			<img src="<?php echo config('theme_path'); ?>/index/images/Thumbnail_Placeholder.png" alt="<?php echo $vo['name']; ?>">
		<?php else: ?>
        	<img src="<?php echo root_path(); ?><?php echo $vo['cover_path']; ?>" alt="<?php echo $vo['name']; ?>">
        <?php endif; ?>
		<div class="caption text-center">
		  <p class="c-title"><?php echo $vo['name']; ?></p>	
		  <p class="description"><?php echo $vo['description']; ?></p>
		</div>
	  </div>
	  <!--</a>-->
	</div>
	<?php endforeach; endif; else: echo "" ;endif; ?>
    </div>
    <!--<p class=" title-two">当季推荐主题<a href="<?php echo url('goods/lists?category=ztdz'); ?>"><span class="txt-lookmore">查看更多>></span></p>
    <div class="row">
    	 <?php if(is_array($ztdz_hot_list) || $ztdz_hot_list instanceof \think\Collection): $i = 0; $__LIST__ = $ztdz_hot_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
		<div class="col-sm-4">
		  <a href="<?php echo url('goods/detail?id='.$vo['id']); ?>">
			  <div class="thumbnail">
			  	<?php if(empty($vo['cover_path']) || ($vo['cover_path'] instanceof \think\Collection && $vo['cover_path']->isEmpty())): ?>
					<img src="<?php echo config('theme_path'); ?>/index/images/Thumbnail_Placeholder.png" alt="<?php echo $vo['name']; ?>">
				<?php else: ?>
		        	<img src="<?php echo root_path(); ?><?php echo $vo['cover_path']; ?>" alt="<?php echo $vo['name']; ?>">
		        <?php endif; ?>
			  		<div>
						<img class="mark-png" src="<?php echo config('theme_path'); ?>/index/images/hot.png"/>
						<div class="caption text-center">
						  <p class="c-title"><?php echo $vo['name']; ?></p>	
		  				 <p class="description"><?php echo $vo['description']; ?></p>
						</div>
				   </div>
			  </div>
			</a>
		  </div>
		  <?php endforeach; endif; else: echo "" ;endif; ?>
		 </div>-->
  </div>
</div>
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

