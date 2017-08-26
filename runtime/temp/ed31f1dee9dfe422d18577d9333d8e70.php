<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:63:"D:\phpStudy\WWW\minishop/application/admin\view\banner\add.html";i:1490584772;s:64:"D:\phpStudy\WWW\minishop/application/admin\view\common\head.html";i:1490584772;s:66:"D:\phpStudy\WWW\minishop/application/admin\view\common\header.html";i:1490584772;s:66:"D:\phpStudy\WWW\minishop/application/admin\view\common\navbar.html";i:1490584772;s:66:"D:\phpStudy\WWW\minishop/application/admin\view\common\footer.html";i:1490783690;}*/ ?>
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
<link rel="stylesheet" type="text/css" href="STATIC_PATH/plugins/webuploader/css/webuploader.css" />
<link rel="stylesheet" type="text/css" href="STATIC_PATH/plugins/webuploader/examples/image-upload/style.css" />
<script src="STATIC_PATH/plugins/jQuery/jquery-1.9.1.min.js"></script>
<body class="skin-blue sidebar-mini wysihtml5-supported fixed">
<div class="wrapper">
  <style type="text/css">
    label {
    display: inline-block;
    font-weight: 700;
    margin-bottom: 5px;
    max-width: 100%;
    font-size: 12px;
    }
  </style>
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
      广告管理
        <small>添加广告</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo url('admin/index/index'); ?>"><i class="fa fa-dashboard"></i> 主页</a></li>
        <li><a href="<?php echo url('admin/banner/index'); ?>">广告管理</a></li>
        <li class="active"><a href="<?php echo url('admin/banner/add'); ?>">添加广告</a></li>
      </ol>
    </section>
 
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">添加广告</h3>
              
            </div>
            <div class="box-body">
              <form method="post" enctype="multipart/form-data"  action="<?php echo url('add'); ?>" id="add">
                <div class="box-body">
                  <div class="form-group">
                   <label for="exampleInputEmail1">广告名称</label>
                    <input class="form-control" id="name" name="adname" value="" placeholder="广告名称" type="text">

                  </div>
                   <div class="form-group">
                    <label for="exampleInputEmail1">广告描述</label>
                    <input class="form-control" id="description" name="description" value="" placeholder="广告描述" type="text">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">URL</label>
                    <input class="form-control" id="link" name="link" value="" placeholder="链接地址" type="url">
                  </div>                
                  <div class="form-group">
                    <label for="exampleInputEmail1">广告位置</label>
                    <select class="form-control" id="pos" name="pos">
                      <option value="0">无</option>
                     <?php if(is_array($pos) || $pos instanceof \think\Collection): $i = 0; $__LIST__ = $pos;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?>
                     <option value="<?php echo $list['id']; ?>"><?php echo $list['title']; ?></option>
                     <?php endforeach; endif; else: echo "" ;endif; ?>            
                    </select>
                  </div>
                 <div class="form-group">
                    <label for="exampleInputEmail1">优先级</label>
                    <input class="form-control" name="level" value="" placeholder="优先级" type="text">
                  </div>    
                 <div class="form-group">
                    
                    <label>封面图</label><br/>  
                    <div class="box-body cover_show">
                    </div>
                    <a href="#" class="btn" data-toggle="modal" data-target="#myModal" style="background-color: #3c8dbc;border-color: #367fa9;border: 1px solid transparent;color:#fff;">上传封面图</a>
                    <input id="img_list" hidden="hidden" type="text" name="banner_path"/>
                                         
                  </div>                            
                  <div class="pull-right">
                    <button class="btn btn-success" onclick="javascript:history.back(-1);return false;">返 回</button>&nbsp;&nbsp;&nbsp;&nbsp;
                    <button type="button" class="btn btn-primary submit">确 定</button>
                  </div>
              </form>
<script type="text/javascript"> 
  $(function(){
  
    $('.submit').click(function() {
  
      $.ajax({
        cache: true,
        type: "POST",
         url: '<?php echo url('add'); ?>',
        data: $('#add').serialize(),
        async: false,
          success: function(data) {
            if (data.code) {
              msgok(data.msg);
              setTimeout(function () {
                location.href = data.url;
              }, 1000);
            } else {
              msgerr(data.msg);
            }

          },
          error: function(request) {
            msgerr("页面错误");
          }
      });
    });
  })  
   
</script>

             
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /. box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
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
</div>
<!-- ./wrapper -->
<script type="text/javascript">
  var uploadPictuer     = '<?php echo url('Upload/uploadPicture'); ?>';  
</script>
<!-- 模态框（Modal） -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
 <div class="modal-dialog modal-lg">
    <div class="modal-content">
       <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" 
             aria-hidden="true">×
          </button>
          <h4 class="modal-title" id="myModalLabel">
             封面图
          </h4>
       </div>
       <div class="modal-body">
        <div id="wrapper">
            <div id="container">
                <!--头部，相册选择和格式选择-->
                <div id="uploader">
                    <div class="queueList">
                        <div id="dndArea" class="placeholder">
                            <div id="filePicker"></div>  
                                        
                        </div>
                    </div>
                    <div class="statusBar" style="display:none;">
                        <div class="progress" style="position:relative;">
                            <span class="text">0%</span>
                            <span class="percentage"></span>
                        </div><div class="info"></div>
                        <div class="btns">
                            <!-- <div id="filePicker2"></div> --><div class="uploadBtn">开始上传</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       </div>
       <div class="modal-footer">
          <button type="button" class="btn btn-primary insert_images">
             确定
          </button>
          <button type="button" class="btn btn-default" 
             data-dismiss="modal">取消
          </button>
       </div>
    </div><!-- /.modal-content -->
 </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript" src="STATIC_PATH/plugins/webuploader/dist/webuploader.js"></script>
<script type="text/javascript" src="STATIC_PATH/plugins/webuploader/examples/image-upload/upload.js"></script>
<!-- jQuery 2.2.0 -->

<script src="STATIC_PATH/plugins/jQueryUI/jquery-ui.min.js"></script>


<script type="text/javascript">
  $('document').ready(function (argument) {
    
    $('.insert_images').on('click',function () {
      var list = new Array(); //定义一数组
      list = $('#img_list').val().split(","); //字符分割
      //下面使用each进行遍历
      var text = '';
      $.each(list,function(n,value) {
        if (value !== null && value !== undefined && value !== '') {
          text = text+"<div class='form-group'><img class='banner_path' style='max-height:150px;' src='ROOT_PATH"+value+"'></div>";
          $('#img_list').val(value);
        }
      });

      $('.cover_show').html(text);
      uploader = "<div class='queueList'><div id='dndArea' class='placeholder'><div id='filePicker'></div></div></div><div class='statusBar' style='display:none;'><div class='progress' style='position:relative;'><span class='text'>0%</span><span class='percentage'></span></div><div class='info'></div><div class='btns'><div class='uploadBtn'>开始上传</div></div></div>";
      // 重置uploader
      $('#uploader').html(uploader);
      // 隐藏Modal
      $('#myModal').modal('hide');
    });



  });
</script>

<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.6 -->
<script src="STATIC_PATH/bootstrap/js/bootstrap.min.js"></script>
<!-- Slimscroll -->
<script src="STATIC_PATH/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- AdminLTE App -->
<script src="STATIC_PATH/dist/js/app.min.js"></script>
</body>
</html>










