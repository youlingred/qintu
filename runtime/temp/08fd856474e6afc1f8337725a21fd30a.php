<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:64:"D:\phpStudy\WWW\minishop/application/admin\view\config\edit.html";i:1492398162;s:64:"D:\phpStudy\WWW\minishop/application/admin\view\common\head.html";i:1490584772;s:66:"D:\phpStudy\WWW\minishop/application/admin\view\common\header.html";i:1490584772;s:66:"D:\phpStudy\WWW\minishop/application/admin\view\common\navbar.html";i:1490584772;s:66:"D:\phpStudy\WWW\minishop/application/admin\view\common\footer.html";i:1490783690;}*/ ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>系统管理</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Msgbox -->
  <link rel="stylesheet" href="STATIC_PATH/msgbox/css/style.css">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="STATIC_PATH/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="STATIC_PATH/dist/css/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="STATIC_PATH/dist/css/ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="STATIC_PATH/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="STATIC_PATH/dist/css/skins/_all-skins.min.css">
  
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="STATIC_PATH/dist/js/html5shiv.min.js"></script>
  <script src="STATIC_PATH/dist/js/respond.min.js"></script>
  <![endif]-->
</head>
<body class="skin-blue sidebar-mini wysihtml5-supported fixed">
<div class="wrapper">

   <header class="main-header">
    <!-- Logo -->
    <a href="#" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>L</b>S</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>后台管理</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
         <!--  <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-envelope-o"></i>
              <span class="label label-success">4</span>
            </a>
           
          </li> -->
          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu">
            <!-- <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning">10</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 10 notifications</li>
             
              <li class="footer"><a href="#">View all</a></li>
            </ul> -->
          </li>
          <!-- Tasks: style can be found in dropdown.less -->
          <li class="dropdown tasks-menu">
            <!-- <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-flag-o"></i>
              <span class="label label-danger">9</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 9 tasks</li>
              
              <li class="footer">
                <a href="#">View all tasks</a>
              </li>
            </ul> -->
          </li>
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
             
              <span class="hidden-xs"><?php echo Session('admin_user_auth.username'); ?></span>
            </a>
            <ul class="dropdown-menu">
 
              <li class="user-footer">
                <div class="pull-right">
                  <a href="<?php echo url('user/edit'); ?>" class="btn btn-default btn-flat">个人资料</a>
                  
                </div>
                </li>
                <li>
                 <div class="box-footer">
                  
                   <a href="<?php echo url('common/logout'); ?>" class="btn btn-default btn-flat">退出</a>
                </div>
                
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
         <!--  <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li> -->
        </ul>
      </div>
    </nav>
  </header>
  
  <!-- Left side column. contains the logo and sidebar -->
 
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel" style="height:40px;">
        <div class="pull-left info">
          <p><?php echo Session('admin_user_auth.username'); ?> <a href="#"><i class="fa fa-circle text-success"></i> </a></p>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">导航</li>
        <?php if(is_array($menuTree) || $menuTree instanceof \think\Collection): $i = 0; $__LIST__ = $menuTree;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
        <li class="<?php echo get_menu_navbar_active($vo['id']); ?> treeview">
          <a href="<?php echo $vo['url']; ?>">
            <i class="<?php echo $vo['icon']; ?>"></i> <span><?php echo $vo['name']; ?></span> <i class="fa fa-angle-left pull-right"></i>
          </a>
          <?php if(!(empty($vo['_child']) || ($vo['_child'] instanceof \think\Collection && $vo['_child']->isEmpty()))): ?>
          <ul class="treeview-menu">
            <?php if(is_array($vo['_child']) || $vo['_child'] instanceof \think\Collection): $i = 0; $__LIST__ = $vo['_child'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sub): $mod = ($i % 2 );++$i;?>
                <li class="<?php echo get_menu_navbar_active($sub['id']); ?>"><a href="<?php echo url($sub['url']); ?>"><i class="<?php echo $sub['icon']; ?>"></i><?php echo $sub['name']; ?></a></li>
            <?php endforeach; endif; else: echo "" ;endif; ?>
          </ul>
          <?php endif; ?>
        </li>
        <?php endforeach; endif; else: echo "" ;endif; ?>
      </ul>
    </section>
    <!-- /.sidebar -->
</aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        设置
        <small>基本设置</small>
      </h1>
      <ol class="breadcrumb">
       <li><a href="<?php echo url('admin/index/index'); ?>"><i class="fa fa-dashboard"></i> 主页</a></li>
        <li><a href="<?php echo url('admin/config/edit'); ?>">设置</a></li>
        <li class="active">基本设置</li>
      </ol>
    </section>

    <!-- Main content -->
      <!-- form start -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
           <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">基本设置</h3>
              <!-- <a type="button" href="<?php echo url('add'); ?>" class="btn btn-primary pull-right">新 增</a> -->
            </div>
            <div class="tab-content">
              <!-- Font Awesome Icons -->
              <form  method="post" action="" id='form1'>
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">网站标题 </label>
                  <input type="text" class="form-control" id="title" name="web_site_title" value="<?php echo $list['web_site_title']; ?>" placeholder="网站标题前台显示标题" />
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">网站描述</label>
                  <input type="text" class="form-control" id="description" value="<?php echo $list['web_site_description']; ?>" name="web_site_description" placeholder="网站搜索引擎描述" />
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">网站关键字</label>
                  <input type="text" class="form-control" id="keyword" value="<?php echo $list['web_site_keyword']; ?>" name="web_site_keyword" placeholder="网站搜索引擎关键字">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">网站备案号</label>
                  <input type="text" class="form-control" id="site_icp" value="<?php echo $list['web_site_icp']; ?>" name="web_site_icp" placeholder="设置在网站底部显示的备案号，如“沪ICP备12007941号-2" />
                </div>                
                <div class="form-group">
                  <input type="hidden" id="close" value="<?php echo $list['web_site_close']; ?>" />
                  <label for="exampleInputPassword1">关闭站点</label>
                  <select class="form-control" id="site_close" name="web_site_close">
                    <option value="0">否</option>
                    <option value="1">是</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">是否允许用户注册</label>
                  <input type="hidden" id="register" value="<?php echo $list['web_allow_register']; ?>" />
                  <select class= "form-control" id="allow_register" name="web_allow_register">              
                    <option value="1">允许注册</option>
                    <option value="0">关闭注册</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">是否开启小票打印机(设置-接口设置中配置小票打印机接口)</label>
                  <input type="hidden" id="ticket" value="<?php echo $list['web_allow_ticket']; ?>" />
                  <select class= "form-control" id="allow_ticket" name="web_allow_ticket">              
                    <option value="1">开启</option>
                    <option value="0">关闭</option>                
                  </select>
                </div>                
                 <div class="form-group">
                  <label for="exampleInputPassword1">汇率</label>
                  <input type="text" class="form-control" id="rate" value="<?php echo $list['exchange_rate']; ?>" name="exchange_rate" placeholder="设置在网站底部显示的备案号，如“沪ICP备12007941号-2" />
                </div> 
              <!-- /.box-body -->

              <div class="pull-right">
                <button class="btn btn-success" onclick="javascript:history.back(-1);return false;">返 回</button>&nbsp;&nbsp;&nbsp;&nbsp;
                <button type="button" onclick="submitInfo()" class="btn btn-primary">确 定</button>
              </div>
            </form>
                
              </div>
              <!-- /#fa-icons -->

            </div>
            <!-- /.tab-content -->
          </div>
          </div>
          <!-- /.nav-tabs-custom -->
          </section>
           </div>
 
  <!-- /.content-wrapper -->
  <footer class="main-footer">	
    <div class="pull-right hidden-xs">
      <b>Version</b> 1.0.0
    </div>
    <strong>Copyright &copy; 2017-2020 <a href="http://www.kintou.net">亲途研发团队</a>.</strong> All rights
    reserved.
</footer>
<script src="STATIC_PATH/plugins/jQuery/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="STATIC_PATH/msgbox/js/msgbox.js"></script>



  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<script src="STATIC_PATH/plugins/jQuery/jquery-1.9.1.min.js"></script>
<script src="STATIC_PATH/plugins/jQueryUI/jquery-ui.min.js"></script>
<script type="text/javascript">
  var uploadPictuer     = '<?php echo url('Upload/uploadPicture'); ?>';
  var uploadFlash       = 'STATIC_PATH/plugins/webuploader/dist/Uploader.swf';
  var ueditorUploadPath = '<?php echo url('ueditor/index'); ?>';
</script>
<link rel="stylesheet" type="text/css" href="STATIC_PATH/plugins/webuploader/css/webuploader.css" />
<script type="text/javascript" src="STATIC_PATH/plugins/webuploader/dist/webuploader.js"></script>
<script type="text/javascript" src="STATIC_PATH/plugins/webuploader/dist/onefile.js"></script>
<script>
  $.widget.bridge('uibutton', $.ui.button);
  function submitInfo(){
       
    var title = $("#title").val();
    var description = $("#description").val();
    var keyword = $("#keyword").val();
    var site_close = $("#site_close").val();
    var site_icp = $("#site_icp").val();
    var allow_register = $("#allow_register").val();
    var allow_ticket = $("#allow_ticket").val();
    // alert($('#form1').serialize());
    // return false;
    $.ajax({
      type: "POST",
      cache: true,
      url: "<?php echo url('admin/config/edit'); ?>",
      data: $('#form1').serialize(),
      dataType: "json",
      async: false,
      success: function(data) {
        if (data.code) {
          msgok(data.msg);
          location.reload();                  
        } else {
          msgerr(data.msg);
        }
      },
      error: function(request) {
        msgerr("页面错误");
      }
    });
  }
</script>
<script type="text/javascript">
  var val_close = eval(document.getElementById('close')).value;

  var val_register =document.getElementById('register').value;
  var val_ticket =document.getElementById('ticket').value;
  // alert(val_register);
  $("#site_close option[value="+val_close+"]").attr("selected",true);
  $("#allow_register option[value="+val_register+"]").attr("selected",true);
  $("#allow_ticket option[value="+val_ticket+"]").attr("selected",true);
 </script>
<!-- Bootstrap 3.3.6 -->
<script src="STATIC_PATH/bootstrap/js/bootstrap.min.js"></script>
<!-- Slimscroll -->
<script src="STATIC_PATH/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- AdminLTE App -->
<script src="STATIC_PATH/dist/js/app.min.js"></script>
</body>
</html>






