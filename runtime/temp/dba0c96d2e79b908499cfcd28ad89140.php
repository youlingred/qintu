<?php if (!defined('THINK_PATH')) exit(); /*a:8:{s:38:"./themes/qintu/index/goods_detail.html";i:1503724384;s:72:"D:\phpStudy\WWW\minishop/application/index\view\public\qintu\header.html";i:1497783158;s:69:"D:\phpStudy\WWW\minishop/application/index\view\public\qintu\nav.html";i:1498742819;s:75:"D:\phpStudy\WWW\minishop/application/index\view\public\qintu\post-cost.html";i:1490927325;s:79:"D:\phpStudy\WWW\minishop/application/index\view\public\qintu\post-question.html";i:1490927325;s:80:"D:\phpStudy\WWW\minishop/application/index\view\public\qintu\post-cost-ztdz.html";i:1491885788;s:84:"D:\phpStudy\WWW\minishop/application/index\view\public\qintu\post-question-ztdz.html";i:1491885783;s:72:"D:\phpStudy\WWW\minishop/application/index\view\public\qintu\footer.html";i:1497781935;}*/ ?>
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

<?php
	$top_cate_info = get_top_cate_info($categoryInfo['id']);
	$top_cate_url=get_nav_info($top_cate_info['name'])['url'];
	$nearby_list=_get_goods_nearby_list($data,'qdz_tese_djty');
	$shares=_get_qtdr_share_list($data['share_master_id']);
	$daren=_get_qtdr_person($data['share_child_id']);
?>
<style>
	.nav-tabs > li > a{
		width:70px;
		font-size: 16px;
		font-weight: bold;
		border: none;
		border-bottom: 1px solid #FFFFFF;
    	border-bottom-width: thick;
	}
	.nav-tabs > li:first-child a{
		left: 80%;
	}
	.nav-tabs > li.active > a, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focus{
		border: none;
		border-bottom: 1px solid #cda62f;
    	border-bottom-width: thick;
	}
	.share .title{
		font-weight: bold;
	    font-size: 18px;
	    color: #525252;
	    line-height: 1.2em;
	}
	.share .price{
		font-weight: bold;
	    font-size: 16px;
	    color: #d9534f;
	    line-height: 1.2em;
	}
	.btn-circle{
		border-radius: 40px;
	}
	.share_btn{
		position: absolute;
		right: 15%;
		top:350px;
	    /*right: 15%;
	    top: 280px;*/
	}
	.share .person{
		font-weight: normal;
		font-size: 14px;
		padding-left: 20px;
	}
	.share .span-ico{
		margin-right: 20px;
	}
	.m-pop-up{
	    right: 13%;
   		top: 70px;
	}
	.product-comment{
	background:#F9F9F9;
	margin-top: 20px;
	padding-left:10px;
	height: 40px;
	line-height: 40px;
	font-size: 16px;
}
.product-comment span{
	height: 40px;
	padding:4px 10px;
	margin-right: 20px; 
	cursor: pointer;
}
.product-comment .span-actived{
	border-bottom: 2px solid #FF2D4B; 
	color:#FF0024;

}
.detail-wap{
	background: #fff;
	padding: 20px;
	
}
.comment-wap{
	display: none;
}
.commont{
	background: #fff;
	border-bottom: dashed 1px #eee; 
}
.commont .commont-info span{
	margin-top:20px;
	margin-left:20px;
	margin-right:20px;
	display: block;
	color: #666;
}
.commont .commont-info .comment-phone{
	float: left;
}
.commont .commont-info .comment-flower{
	float: left;
}
.commont .commont-info .comment-flower img{
	margin-right: 20px;
	margin-top: -4px;
}
.commont .commont-info .comment-time{
	float: right;
}
.commont .commont-content{

	padding: 20px;
	word-wrap: break-word;
}
</style>
<!-- 私信 -->
<div class="modal fade" id="msg-dialog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel1">私信</h4>
      </div>
      <div class="modal-body">
     	 <form id="form-reg" class="reg-login-form" action="">
			<div class="form-group">
				<textarea name="description" rows="2" placeholder="留言内容" class="form-control" style="height: 180px;"></textarea>
			</div>
			<div class="text-center">
				<button type="submit" class="btn btn-gold btn-full">发送</button>
			</div>
		</form>
   	  </div>
    </div>
  </div>
</div>
<!-- 私信 -->
<!--<a><div id="car_container" class="pull-right bag-right <?php if($top_cate_info['slug'] == 'ztdz'): ?>hidden<?php endif; if($top_cate_info['slug'] == 'qtdr'): ?>hidden<?php endif; ?>" id="bag">
	<span id="car_num" class="badge badge-red">0</span>
</div></a>-->
<div class="row section <?php if($top_cate_info['slug'] == 'qtdr'): ?>hidden<?php endif; ?>">
	<div class="col-md-4 col-md-offset-2">
		<ol class="breadcrumb">
		  <li><a href="<?php echo url($top_cate_url); ?>"><?php echo $top_cate_info['name']; ?></a></li>
		  <li><a><?php echo $data['name']; ?></a></li>
		</ol>
	</div>
	
	<div class="col-sm-6 col-sm-offset-3 title-one section-bg-white">
	  <div class="row  product-card">
		<div class="col-sm-5">
			<div class="row product-real">
				<div id="preview" class="col-sm-12">
					<?php if(empty($data['photo_path_1']) || ($data['photo_path_1'] instanceof \think\Collection && $data['photo_path_1']->isEmpty())): ?>
					  <img src="<?php echo config('theme_path'); ?>/index/images/ImgResponsive_Placeholder.png" class="img-thumbnail img-responsive">
			        <?php else: ?>
			          <img src="<?php echo root_path(); ?><?php echo $data['photo_path_1']; ?>" class="img-responsive">
			        <?php endif; ?>
				</div>
			</div>
			<div class="row product-preview">
				<?php if(!(empty($data['photo_path_1']) || ($data['photo_path_1'] instanceof \think\Collection && $data['photo_path_1']->isEmpty()))): ?>
                    <div class="col-sm-4 no-padding">
                    	<img src="<?php echo root_path(); ?><?php echo $data['photo_path_1']; ?>" class="img-thumbnail img-responsive" alt="" onmouseover="preview(this)">
                    </div>
                <?php endif; if(!(empty($data['photo_path_2']) || ($data['photo_path_2'] instanceof \think\Collection && $data['photo_path_2']->isEmpty()))): ?>
                    <div class="col-sm-4 no-padding">
                    	<img src="<?php echo root_path(); ?><?php echo $data['photo_path_2']; ?>" class="img-thumbnail img-responsive" alt="" onmouseover="preview(this)">
                    </div><?php endif; if(!(empty($data['photo_path_3']) || ($data['photo_path_3'] instanceof \think\Collection && $data['photo_path_3']->isEmpty()))): ?>
                    <div class="col-sm-4 no-padding">
                    	<img src="<?php echo root_path(); ?><?php echo $data['photo_path_3']; ?>" class="img-thumbnail img-responsive" alt="" onmouseover="preview(this)">
                    </div><?php endif; ?>
		  	</div>
		</div>
		<div class="col-sm-7 product-card-right">
		  	<p class="product-detail-title"><?php echo $data['name']; ?></p>
		  	<p class="text-left label-wrap" style="height: 25px;"> 
		  		<?php
					$labels = explode("|", $data['label_tese']);
				if(is_array($labels) || $labels instanceof \think\Collection): $i = 0; $__LIST__ = $labels;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$label): $mod = ($i % 2 );++$i;if($label): ?>
						<span class="label label-default"><?php echo $label; ?></span>
					<?php endif; endforeach; endif; else: echo "" ;endif; ?>
		  	</p>
		  	<div class="row" style="margin-top: 20px;">
		  		<div class="col-sm-12">
		  			<?php 
		  				$price_txt=floor($data['price']);
						if(($price_txt/10000)>1){
							$price_txt=floor($price_txt);
							$w=floor($price_txt/10000);
							$ww=$price_txt%10000;
							$price_txt=$w.'万'.($ww>0?$ww:"");
						}
						$val_key=$exchange_rate;
						$price_rmb=floor($data['price']/$val_key);
		  			 ?>
		  			<p id="price_txt" class="product-detail-title txt-red" data-rmb="<?php echo $price_rmb; ?>"><?php echo $price_txt; ?>元<small>人/起</small></p>
		  		</div>
		  		<!--<div class="col-sm-4">
	  			 <?php
					$labels = explode("|", $data['label_quan']);
				if(is_array($labels) || $labels instanceof \think\Collection): $i = 0; $__LIST__ = $labels;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$label): $mod = ($i % 2 );++$i;if($label): ?>
						<span id="quan_help" class="label label-danger"><?php echo $label; ?></span>
					<?php endif; endforeach; endif; else: echo "" ;endif; ?>
		  		</div>
	  		  	<div class="col-sm-3 txt-red no-padding <?php if($top_cate_info['slug'] == 'ztdz'): ?>hidden<?php endif; ?>">
					<span id="price_help" class="label label-danger badge bg-red">?</span>
		  			起价说明
		  		</div>-->
		  	</div>
		  	<hr>
		  	<div class="row">
	  		  <div class="col-sm-5 detail_form_item">
				<p>选择日期</p>
				<div class="col-sm-12 no-padding">
					<div class="input-group date form_date col-sm-12" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
						<input id="departure_time" class="form-control" size="16" type="text" value="" readonly>
						<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
					</div>
				</div>
	  	      </div>
  		  	   <div class="col-sm-3 detail_form_item">
				<p>成人</p>
				<div class="col-sm-12 no-padding">
					<div class="input-group spinner" data-trigger="spinner">
					  <input id="man_num" type="text" class="form-control text-center" value="1" data-min="1" data-rule="percent">
					  <div class="input-group-addon">
						<a href="javascript:;" class="spin-up" data-spin="up"><span class="glyphicon glyphicon-triangle-top"></span></a>
						<a href="javascript:;" class="spin-down" data-spin="down"><span class="glyphicon glyphicon-triangle-bottom"></span></a>
					  </div>
					</div>
				</div>
  		  	   </div>
  		  	   <div class="col-sm-4 detail_form_item">
				<p style="max-height: 35px">儿童（0~4周岁）</p>
				<div class="col-sm-12 no-padding">
					<div class="input-group spinner" data-trigger="spinner">
					  <input id="child_num" type="text" class="form-control text-center" value="0" data-min="0" data-rule="percent">
					  <div class="input-group-addon">
						<a href="javascript:;" class="spin-up" data-spin="up"><span class="glyphicon glyphicon-triangle-top"></span></a>
						<a href="javascript:;" class="spin-down" data-spin="down"><span class="glyphicon glyphicon-triangle-bottom"></span></a>
					  </div>
					</div>
				</div>
  		  	   </div>
		  	</div>
		  	<div class="row">
				<div class="col-sm-12 sum_btns text-right <?php if($top_cate_info['slug'] == 'ztdz'): ?>hidden<?php endif; ?>">
					<button id="lookOrder" type="button" class="btn btn-gold hidden">查看全部</button>
                    <button id="addOrder" type="button" class="btn btn-gold" dataname="<?php echo $data['name']; ?>" dataid="<?php echo $data['id']; ?>">申请预订</button>
				</div>
				<div class="col-sm-12 sum_btns text-right <?php if($top_cate_info['slug'] != 'ztdz'): ?>hidden<?php endif; ?>">
					<button id="postOrder" type="button" class="btn btn-gold">申请预订</button>
				</div>
			</div>
		</div>
	  </div>
</div>
</div>
<div class="row section <?php if($top_cate_info['slug'] == 'qtdr'): ?>hidden<?php endif; ?>">
	<div class="col-sm-6 col-sm-offset-3 title-one section-bg-white">
	  <div class="row content">
	  <?php echo $data['content']; if(!(empty($daren) || ($daren instanceof \think\Collection && $daren->isEmpty()))): ?>
	  <hr/>
		<p style="line-height: 1.75em;">
			<span style="font-size: 24px; line-height: 1.75em;">
				<span style="color: rgb(255, 192, 0); font-size: 24px; line-height: 28px;">
					▎
				</span>
				达人介绍
			</span><br>
		</p>
	    	<div class="share">
	    		<p class="title person"><span class="span-ico"><img src="<?php echo root_path(); ?><?php echo $daren['photo_path_1']; ?>" class="img-circle" style="width:50px;height:50px;"/></span><?php echo $daren['name']; ?><a href="<?php echo url('goods/detail?id='.$daren['id']); ?>"><span class="txt-lookmore"><button type="button" class="btn btn-md btn-gold btn-circle">了解达人</button></span></a></p>
	    		<p class="description"><?php echo $daren['description']; ?></p>
	    	</div>
		<?php endif; ?>
	  </div>
	</div>
</div>
<div class="row section <?php if($top_cate_info['slug'] == 'qtdr'): ?>hidden<?php endif; ?>">
	
	<div class="col-sm-6 col-md-offset-3 title-one">
		<hr />
		  <p class="text-center title" style="font-size: 18px;">用户评价</p>
		  <p class="text-center txt"  style="font-size: 12px;">共<?php echo $total_comment; ?>条评论</p> 
	      <?php if(is_array($comment) || $comment instanceof \think\Collection): $i = 0; $__LIST__ = $comment;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?>
          <div class="commont">
            <div class="commont-list">
                <div class="commont-info">
                  <span class="comment-phone"><?php echo get_userinfo($list['uid'],'nickname'); ?></span>
                  <span class="comment-flower">
                  <?php switch($list['score']): case "1": ?><img src="<?php echo config('theme_path'); ?>/index/images/flower_1.png" alt=""><?php break; case "2": ?><img src="<?php echo config('theme_path'); ?>/index/images/flower_2.png" alt=""><?php break; case "3": ?><img src="<?php echo config('theme_path'); ?>/index/images/flower_3.png" alt=""><?php break; case "4": ?><img src="<?php echo config('theme_path'); ?>/index/images/flower_4.png" alt=""><?php break; case "5": ?><img src="<?php echo config('theme_path'); ?>/index/images/flower_5.png" alt=""><?php break; default: ?><img src="<?php echo config('theme_path'); ?>/index/images/flower_1.png" alt="">
                  <?php endswitch; ?>
                  <?php echo $list['score']; ?>分</span>
                  <span class="comment-time"><?php echo date('Y-m-d',$list['createtime']); ?></span>
                  <div class="clearfix"></div>
                </div>
                <div class="commont-content">
                  <span><?php echo $list['content']; ?></span>
                </div>
            </div>
          </div>
          <?php endforeach; endif; else: echo "" ;endif; ?>
	</div>
</div>
<!--<?php if($top_cate_info['slug'] == 'qdz'): 
	$post = _get_post_by_name('post-cost');
?>
<div class="row section no-padding">
	<div class="col-sm-8 col-sm-offset-2 col-lg-6 col-lg-offset-3 title-one section-bg-white">
	  <div class="row content no-padding-top-bottom">
	  <h3><?php echo $post['title']; ?></h3>
	  <?php echo $post['content']; ?>
	  </div>
	</div>
</div>
<?php
	$post = _get_post_by_name('post-question');
?>
<div class="row section no-padding">
	<div class="col-sm-8 col-sm-offset-2 col-lg-6 col-lg-offset-3 title-one section-bg-white">
	  <div class="row content no-padding-top-bottom">
	  <h3><?php echo $post['title']; ?></h3>
	  <?php echo $post['content']; ?>
	  </div>
	</div>
</div>
<?php endif; if($top_cate_info['slug'] == 'ztdz'): 
	$post = _get_post_by_name('post-cost-ztdz');
?>
<div class="row section no-padding">
	<div class="col-sm-8 col-sm-offset-2 col-lg-6 col-lg-offset-3 title-one section-bg-white">
	  <div class="row content no-padding-top-bottom">
	  <h3><?php echo $post['title']; ?></h3>
	  <?php echo $post['content']; ?>
	  </div>
	</div>
</div>
<?php
	$post = _get_post_by_name('post-question-ztdz');
?>
<div class="row section no-padding">
	<div class="col-sm-8 col-sm-offset-2 col-lg-6 col-lg-offset-3 title-one section-bg-white">
	  <div class="row content no-padding-top-bottom">
	  <h3><?php echo $post['title']; ?></h3>
	  <?php echo $post['content']; ?>
	  </div>
	</div>
</div>
<?php endif; ?>-->
<?php if($top_cate_info['slug'] == 'qtdr'): ?>
	<div class="row section qtdr-section-top text-center">
		<img src="<?php echo root_path(); ?><?php echo $data['photo_path_1']; ?>" class="img-circle" style="width:150px;height:150px;">
		<div class="caption text-center" style="margin-top: 20px;">
			<p class="c-title" style="font-weight: bold"><?php echo $data['name']; ?><span style="font-weight: normal;font-size: 14px;position: absolute;">&nbsp;&nbsp;&nbsp;&nbsp;<img src="<?php echo config('theme_path'); ?>/index/images/yanzheng.png"/>已验证</span></p>	
			<if condition="<?php echo $data['label_area']; ?>">
				<p ><?php echo $data['label_area']; ?></p>
			</if>
			<p ><?php echo $data['description']; ?></p>
		</div>
		<div class="share_btn">
			<button id="msg_btn" type="button" class="btn btn-md btn-gold btn-circle">私&nbsp;&nbsp;&nbsp;&nbsp;信</button>
		<button id="share_btn" type="button" class="btn btn-md btn-gold btn-circle">推荐给朋友</button>
		</div>
			<div id="share_qrcode" class="m-pop-up">
				<p class="m-tt">分享到微信朋友圈</p>
				<div id="qrcode" class="m-ewm"></div>
				<p class="m-ct text-left">打开微信，使用「扫一扫」打开页面后，通过右上角的操作即可分享到朋友圈。</p>
			</div>
	</div>
	<div class="row section">
	<div class="col-sm-6 col-sm-offset-3 title-one section-bg-white">
	  	<div role="tabpanel">
		  	<ul class="nav nav-tabs text-justify" role="tablist">
		    	<li style="width: 50%;margin-bottom:0px;" role="presentation" class="active"><a href="#分享" data-toggle="tab" role="tab" aria-controls="tab1">分享</a></li>
		    	<li style="width: 50%;margin-bottom:0px;" role="presentation"><a href="#发现" data-toggle="tab" role="tab" aria-controls="tab2">发现</a></li>		    		
		    </ul>
		    <div id="tabContent1" class="tab-content">
		      	<div role="tabpanel" class="tab-pane fade in active" id="分享">
			        <div class="col-sm-12 content">
			        	<?php echo $data['content']; ?>
			        	<hr/>
			        	<p style="line-height: 1.75em;">
			        		<span style="font-size: 24px; line-height: 1.75em;">
			        			<span style="color: rgb(255, 192, 0); font-size: 24px; line-height: 28px;">
			        				▎
			        			</span>
			        			达人分享
			        		</span><br>
			        	</p>
			        	<?php if(is_array($shares) || $shares instanceof \think\Collection): $i = 0; $__LIST__ = $shares;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;
			  				$price_txt=floor($vo['price']);
							if(($price_txt/10000)>1){
								$price_txt=floor($price_txt);
								$w=floor($price_txt/10000);
								$ww=$price_txt%10000;
								$price_txt=$w.'万'.($ww>0?$ww:"");
							}
				  			 ?>
				        	<div class="share">
				        		<p class="title"><?php echo $vo['name']; ?><a href="<?php echo url('goods/detail?id='.$vo['id']); ?>" target="_blank"><span class="txt-lookmore"><button type="button" class="btn btn-md btn-gold btn-circle">查看体验</button></span></a></p>
				        		<p class="price"><?php echo $price_txt; ?>元</p>
				        		<p class="description"><?php echo $vo['description']; ?></p>
				        	</div>
			        		<div class="row product-preview">
								<?php if(!(empty($vo['photo_path_1']) || ($vo['photo_path_1'] instanceof \think\Collection && $vo['photo_path_1']->isEmpty()))): ?>
				                    <div class="col-sm-4 no-padding">
				                    	<img src="<?php echo root_path(); ?><?php echo $vo['photo_path_1']; ?>" class="img-thumbnail img-responsive" alt="">
				                    </div>
				                <?php endif; if(!(empty($vo['photo_path_2']) || ($vo['photo_path_2'] instanceof \think\Collection && $vo['photo_path_2']->isEmpty()))): ?>
				                    <div class="col-sm-4 no-padding">
				                    	<img src="<?php echo root_path(); ?><?php echo $vo['photo_path_2']; ?>" class="img-thumbnail img-responsive" alt="">
				                    </div><?php endif; if(!(empty($vo['photo_path_3']) || ($vo['photo_path_3'] instanceof \think\Collection && $vo['photo_path_3']->isEmpty()))): ?>
				                    <div class="col-sm-4 no-padding">
				                    	<img src="<?php echo root_path(); ?><?php echo $vo['photo_path_3']; ?>" class="img-thumbnail img-responsive" alt="">
				                    </div><?php endif; ?>
						  	</div>
			        		<hr/>
			        	<?php endforeach; endif; else: echo "" ;endif; ?>
			        </div>
		      	</div>
		      	<div role="tabpanel" class="tab-pane fade in " id="发现">
			        <div class="col-sm-12 content">
			        	<?php echo $data['discover']; ?>
			        	
			        </div>
		      	</div>
		    </div>
		  </div>
	</div>
	</div>
</div>
<?php endif; ?>
<div class="row section <?php if($top_cate_info['slug'] == 'qtdr'): ?>hidden<?php endif; ?>">
	<div class="col-sm-6 col-sm-offset-3 title-one section-bg-white">
		<p class="text-center title" style="margin-top: 20px">推荐体验</p>
	  <div class="row">
	  	<?php if(is_array($nearby_list) || $nearby_list instanceof \think\Collection): $i = 0; $__LIST__ = $nearby_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
		<div class="col-sm-6">
		  <a href="<?php echo url('goods/detail?id='.$vo['id']); ?>">
			  <div class="thumbnail thumbnail-qdz-detail-bottom">
			  	<?php if(empty($vo['cover_path']) || ($vo['cover_path'] instanceof \think\Collection && $vo['cover_path']->isEmpty())): ?>
					<img src="<?php echo config('theme_path'); ?>/index/images/Thumbnail_Placeholder.png" alt="<?php echo $vo['name']; ?>">
				<?php else: ?>
                	<img src="<?php echo root_path(); ?><?php echo $vo['cover_path']; ?>" alt="<?php echo $vo['name']; ?>">
                <?php endif; ?>
				<div class="caption text-center">
				<p class="c-title"><?php echo $vo['name']; ?></p>	
				  <p class="description"><?php echo $vo['description']; ?></p>
				  <p class="text-left label-wrap"> 
				  	<?php
						$labels = explode("|", $vo['label_tese']);
					if(is_array($labels) || $labels instanceof \think\Collection): $i = 0; $__LIST__ = $labels;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$label): $mod = ($i % 2 );++$i;if($label): ?>
							<span class="label label-default"><?php echo $label; ?></span>
						<?php endif; endforeach; endif; else: echo "" ;endif; ?>
				  	</p>
				</div>
			  </div>
			  </a>
		</div>
		<?php endforeach; endif; else: echo "" ;endif; ?>
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
<script src="<?php echo config('theme_path'); ?>/index/js/goods_detail.js?ver=<?php echo __VERSION__; ?>"></script>