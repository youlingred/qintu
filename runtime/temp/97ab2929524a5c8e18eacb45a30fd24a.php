<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:40:"./themes/qintu/index/goods_qdz_list.html";i:1499085470;s:72:"D:\phpStudy\WWW\minishop/application/index\view\public\qintu\header.html";i:1497783158;s:69:"D:\phpStudy\WWW\minishop/application/index\view\public\qintu\nav.html";i:1498742819;s:72:"D:\phpStudy\WWW\minishop/application/index\view\public\qintu\footer.html";i:1497781935;}*/ ?>
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
$filters=_get_filters();
$url_category='category='.$category;
$url_filter='&filter='.$filter;
$url_search='&search='.$search;
$url_sort='&sort='.$sort;
$url_base_search=url('goods/lists?category='.'qdz_area_all|qdz_tese_all'.$url_sort)
 ?>
<style>
	.item-overlay{
		left: initial;
		width:30%;
		right:15px;
		bottom:142px;
		text-align: right;
	}
</style>
<img class="img-responsive" src="<?php echo config('theme_path'); ?>/index/images/banner_qdz.jpg?ver=<?php echo __VERSION__; ?>">
<a name="pos"></a>
<div class="row section-bg-gray section no-padding banner-bottom">
	<div class="col-md-3 col-md-offset-7">
		 <div class="input-group">
                        <input type="text" class="form-control search-input" id="test_data" onkeydown="javascript:if(event.keyCode==13) search('test_data');" value="<?php echo $search; ?>" placeholder="输入要搜索的内容关键字">
                        <div class="input-group-btn">
                            <button type="button" class="btn btn-gold search-btn" onclick="search('test_data');return false;">
                                <span class="glyphicon glyphicon-search"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                            </ul>
                        </div>
                        <!-- /btn-group -->
                    </div>
	</div>
	<div class="col-md-8 col-md-offset-2 title-one">
		<div class="row select-main">
			<ul class="nav">
				<?php if(is_array($selfCates) || $selfCates instanceof \think\Collection): $i = 0; $__LIST__ = $selfCates;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?>
					<li class="nav-item">
							<ul class="nav nav-pills">
							<?php if(is_array($data) || $data instanceof \think\Collection): $k = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;
									$url_str=str_replace($categoryInfos[$i-1]['slug'],$vo['slug'],$category);
								if($categoryInfos[$i-1]['name'] == $vo['name']): ?>
									<li role="presentation" class="active">
										<a href="<?php echo url('goods/lists?category='.$url_str.$url_filter.$url_search.$url_sort); ?>#pos"><?php echo $vo['name']; ?></a>
									</li>
	                            <?php else: ?>    
	                                <li role="presentation">
										<a href="<?php echo url('goods/lists?category='.$url_str.$url_filter.$url_search.$url_sort); ?>#pos"><?php echo $vo['name']; ?></a>
									</li>
	                            <?php endif; endforeach; endif; else: echo "" ;endif; ?>  
                   		</ul>
					</li>
                <?php endforeach; endif; else: echo "" ;endif; if(!(empty($filters) || ($filters instanceof \think\Collection && $filters->isEmpty()))): ?>
	                <li class="nav-item">
	                	<ul class="nav nav-pills">
	                		<?php if(is_array($filters) || $filters instanceof \think\Collection): $i = 0; $__LIST__ = $filters;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
						     <li role="presentation">
							  <div class="checkbox" style="margin-bottom: 0px;margin-top: 0px;">
							    <label>
							      <input name="filter" type="checkbox" onchange="filterChange()" data-slug="<?php echo $vo['slug']; ?>" value="<?php echo $vo['id']; ?>" style="width: 15px; height: 15px;"><?php echo $vo['name']; ?>
							    </label>
							  </div>
							</li>
							<?php endforeach; endif; else: echo "" ;endif; ?>
						</ul>
	                </li>
                 <?php endif; ?>
			</ul>
		</div>
		<div class="row">
			<?php if(is_array($list) || $list instanceof \think\Collection): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?>
			<div class="col-sm-4">
				<a href="<?php echo url('goods/detail?id='.$data['id']); ?>">
					<div class="thumbnail">
						<?php if(empty($data['cover_path']) || ($data['cover_path'] instanceof \think\Collection && $data['cover_path']->isEmpty())): ?>
							<img src="<?php echo config('theme_path'); ?>/index/images/Thumbnail_Placeholder.png" alt="<?php echo $data['name']; ?>">
						<?php else: ?>
                        	<img src="<?php echo root_path(); ?><?php echo $data['cover_path']; ?>" alt="<?php echo $data['name']; ?>">
                        <?php endif; 
			  				$price_txt=floor($data['price']);
			  			?>
                        <p class="item-overlay text-center"><?php echo $price_txt; ?>元起</p>
						<div class="caption text-center">
							<p class="c-title"><?php echo $data['name']; ?></p>	
							<p class="description"><?php echo $data['description']; ?></p>
							<?php
								$labels = explode("|", $data['label_tese']);
								$total_comment=get_total_comment($data['id'])
							?>
							
							<div style="color: #717171;">
								<div style="float: left;">
									<p class="text-left label-wrap"> 
										<?php if(is_array($labels) || $labels instanceof \think\Collection): $i = 0; $__LIST__ = $labels;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$label): $mod = ($i % 2 );++$i;if($label): ?>
												<span class="label label-default"><?php echo $label; ?></span>
											<?php endif; endforeach; endif; else: echo "" ;endif; ?>
									</p>
								</div>
								<div style="float: right"><?php echo $total_comment; ?>条评论</div>
								<div style="clear: both;"></div>
							</div>
						</div>
					</div>
				</a>
			</div>
			<?php endforeach; endif; else: echo "" ;endif; ?>
		</div>
		<nav class="text-center" aria-label="Page navigation">
			<?php echo $page; ?>
		</nav>
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
<script type="text/javascript">
	$().ready(function () {
		 $url="<?php echo url('goods/lists?'.$url_category.$url_filter.$url_search.$url_sort); ?>";
		<?php if(is_array($filterInfos) || $filterInfos instanceof \think\Collection): $i = 0; $__LIST__ = $filterInfos;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
	      $("input:checkbox[value='<?php echo $vo['id']; ?>']").attr('checked','true');
		<?php endforeach; endif; else: echo "" ;endif; ?>
	});
	function filterChange(){
		filter_value=[];
		$('input[name="filter"]:checked').each(function(){ 
			filter_value.push($(this).attr('data-slug')); 
		}); 
		filter_str=filter_value.join("|");
		location.href = $url+"&filter="+filter_str+"#pos";
	}
	function search(search_key){
		sk=$("#"+search_key).val();
		$url="<?php echo $url_base_search; ?>";
//		search_key=$.session.get("search_key");
//		if(search_key){
//			search_key.push(sk);
//		}else{
//			search_key=new Array();
//			search_key.push(sk);
//		}
		location.href= $url+"&search="+sk+"#pos";
	}
</script>