<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:67:"D:\phpStudy\WWW\minishop/application/admin\view\goods\goodsadd.html";i:1496121055;s:66:"D:\phpStudy\WWW\minishop/application/admin\view\common\header.html";i:1490584772;s:66:"D:\phpStudy\WWW\minishop/application/admin\view\common\navbar.html";i:1490584772;s:66:"D:\phpStudy\WWW\minishop/application/admin\view\common\footer.html";i:1490783690;}*/ ?>
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
  <link rel="stylesheet" href="https://cdn.bootcss.com/font-awesome/4.6.3/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdn.bootcss.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- fullCalendar 2.2.5-->
  <link rel="stylesheet" href="STATIC_PATH/plugins/fullcalendar/fullcalendar.min.css">
  <link rel="stylesheet" href="STATIC_PATH/plugins/fullcalendar/fullcalendar.print.css" media="print">
  <!-- Theme style -->
  <link rel="stylesheet" href="STATIC_PATH/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="STATIC_PATH/dist/css/skins/_all-skins.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" type="text/css" href="STATIC_PATH/plugins/webuploader/css/webuploader.css" />
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
  <![endif]-->
  <style type="text/css">
    label {
    display: inline-block;
    font-weight: 700;
    margin-bottom: 5px;
    max-width: 100%;
    font-size: 12px;
    }
    .thumbnail{margin-bottom: 0px;}
  </style>
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
        商品
        <small>添加商品</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> 主页</a></li>
        <li><a href="#">商品</a></li>
        <li class="active"><a href="#">添加商品</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <form action="<?php echo url('goodsAdd'); ?>" method="post" id="addPost">
    <section class="content">
      <div class="row">
        <div class="col-md-9">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">填写内容</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="form-group">
                <input id="title" name="name" class="form-control" placeholder="商品名称">
              </div>
              <div class="form-group">
                  <textarea name="description" rows="2" placeholder="商品描述" class="form-control"></textarea>
              </div>
              <div class="form-group">
                  <textarea name="man_profiles" rows="2" placeholder="个人简介————达人选填项" class="form-control"></textarea>
              </div>
              <div class="form-group">
                  <textarea name="goods_profiles" rows="2" placeholder="体检简介————达人选填项" class="form-control"></textarea>
              </div>
              <div class="form-group">
                  <script type="text/plain" id="editor" name="content" style="height:400px;"></script>
              </div>
              <!--扩展表单-->
              <div class="form-extend">
              	<div class="form-group">
                    <label>排序</label>
                    <input name="sort" type="number" value="0" class="form-control" >
                </div>
              	<div class="form-group">
                    <label>价格</label>
                    <input name="price" type="text" placeholder="价格" class="form-control" >
                </div>
                <div class="form-group">
                    <label>特色标签</label>
                    <input name="label_tese" type="text" placeholder="北极光|破冰船" class="form-control" >
                </div>
                <div class="form-group">
                    <label>券代标签</label>
                    <input name="label_quan" type="text" placeholder="券|代" class="form-control" >
                </div>
                <div class="form-group">
                    <label>地区+类型匹配</label>
                    <input name="label_match_1" type="text" placeholder="东京1001" class="form-control" >
                </div>
                <div class="form-group">
                    <label>地区匹配</label>
                    <input name="label_area" type="text" placeholder="东京" class="form-control" >
                </div>
                <div class="form-group hidden">
                    <label>库存</label>
                    <input name="num" type="text" value="100" placeholder="库存" class="form-control" >
                </div>
                <div class="form-group hidden">
                    <label>点击数</label>
                    <input name="click_count" type="text" value="0" placeholder="商品点击数" class="form-control" >
                </div>
                <div class="form-group hidden">
                    <label>销售数量</label>
                    <input name="sell_num" type="text" value="0" placeholder="销售数量" class="form-control" >
                </div>
                <div class="form-group hidden">
                    <label>规格型号</label>
                    <input name="standard" type="text" placeholder="规格型号" class="form-control" >
                </div>
                <div class="form-group hidden">
                    <label>赠送积分</label>
                    <input name="score" type="text" placeholder="积分值" class="form-control" >
                </div>
                <div class="form-group">
                    <label>分享主ID(达人主页使用)</label>
                    <input name="share_master_id" type="text" placeholder="" class="form-control" >
                </div>
                <div class="form-group">
                    <label>分享子ID(达人分享产品使用)</label>
                    <input name="share_child_id" type="text" placeholder="" class="form-control" >
                </div>
                <div class="form-group">
                	<label>发现内容(达人分享主页使用)</label>
                  <script type="text/plain" id="editor_discover" name="discover" style="height:400px;"></script>
              	</div>
              </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              <div class="pull-right">
                <button class="btn btn-success" onclick="javascript:history.back(-1);return false;">返 回</button>&nbsp;&nbsp;&nbsp;&nbsp;
                <button type="button" class="btn btn-primary submit">发 布</button>
              </div>
            </div>
            <!-- /.box-footer -->
          </div>
          <!-- /. box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3">

          <!-- /. box -->
          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">分类目录</h3>

              <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <div class="box-body">
                <div class="form-group">
                <?php echo tree_to_checkbox($goodsCateTree); ?>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <!-- <a>添加新分类目录</a> -->
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
           <!-- /. box -->
          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">筛选标签</h3>

              <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <div class="box-body">
                <div class="form-group">
                <?php echo tree_to_checkbox_filter($goodsFilterTree); ?>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <!-- <a>添加新分类目录</a> -->
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">商品推荐</h3>

              <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <div class="box-body">

                <div class="form-group">
                    <div class="radio" style="width:180px;float:left">
                      精品：
                      <label>
                        <input name="is_best" type="radio" value="1">是
                      </label>
                      &nbsp;
                      <label>
                        <input name="is_best" type="radio" value="0"  checked="checked">否
                      </label>
                    </div>
                </div>
                <div style="clear:both;"></div>
                <div class="form-group hidden">
                    <div class="radio" style="width:180px;float:left">
                      新品：
                      <label>
                        <input name="is_new" type="radio" value="1">是
                      </label>
                      &nbsp;
                      <label>
                        <input name="is_new" type="radio" value="0"  checked="checked">否
                      </label>
                    </div>
                </div>
                <div style="clear:both;"></div>
                <div class="form-group">
                      <div class="radio" style="width:180px;float:left">
                        热销：
                        <label>
                          <input name="is_hot" type="radio" value="1">是
                        </label>
                        &nbsp;
                        <label>
                          <input name="is_hot" type="radio" value="0"  checked="checked">否
                        </label>
                      </div>
                </div>
                <div style="clear:both;"></div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
          <!-- /.box -->
          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">封面图</h3>

              <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <div class="box-body">
                <div id="uploader-demo">
                    <!--用来存放item-->
                    <input type="hidden" name="cover_path" class="cover_path">
                    <div id="cover_path" class="uploader-list"></div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <div class="insertCover">添加封面图</div>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">商品相册</h3>

              <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <div class="box-body">
                <div id="uploader-demo">
                    <!--用来存放item-->
                    <input type="hidden" name="photo_path_1" class="photo_path_1">
                    <div id="photo_path_1" class="uploader-list"></div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                 <div class="photo_path_1_insertPhoto">商品相册一</div>
              </div>
              <div class="box-body">
                <div id="uploader-demo">
                    <!--用来存放item-->
                    <input type="hidden" name="photo_path_2" class="photo_path_2">
                    <div id="photo_path_2" class="uploader-list"></div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                 <div class="photo_path_2_insertPhoto">商品相册二</div>
              </div>
              <div class="box-body">
                <div id="uploader-demo">
                    <!--用来存放item-->
                    <input type="hidden" name="photo_path_3" class="photo_path_3">
                    <div id="photo_path_3" class="uploader-list"></div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                 <div class="photo_path_3_insertPhoto">商品相册三</div>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    </form>
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
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.0 -->
<script src="http://code.jquery.com/jquery-1.12.0.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="STATIC_PATH/bootstrap/js/bootstrap.min.js"></script>
<!-- Slimscroll -->
<script src="STATIC_PATH/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- AdminLTE App -->
<script src="STATIC_PATH/dist/js/app.min.js"></script>

<script type="text/javascript">
  var uploadPictuer     = '<?php echo url('Upload/uploadPicture'); ?>';
  var uploadFlash       = 'STATIC_PATH/plugins/webuploader/dist/Uploader.swf';
  var ueditorUploadPath = '<?php echo url('ueditor/index'); ?>';
</script>
<!-- Page Script -->
<script type="text/javascript" charset="utf-8" src="STATIC_PATH/plugins/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="STATIC_PATH/plugins/ueditor/ueditor.all.min.js"> </script>
<!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
<!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
<script type="text/javascript" charset="utf-8" src="STATIC_PATH/plugins/ueditor/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript" src="STATIC_PATH/plugins/webuploader/dist/webuploader.js"></script>
<script type="text/javascript" src="STATIC_PATH/plugins/webuploader/dist/onefile.js"></script>
<script type="text/javascript">
  $().ready(function () {
    // 发布文章
    $('.submit').click(function () {
        $.ajax({
          cache: true,
          type: "POST",
          url : '<?php echo url('goodsAdd'); ?>',
          data: $('#addPost').serialize(),
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
<script type="text/javascript">

    //实例化编辑器
    //建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
    var ue = UE.getEditor('editor');
    function setContent(isAppendTo) {
        var arr = [];
        arr.push("使用editor.setContent('欢迎使用ueditor')方法可以设置编辑器的内容");
        UE.getEditor('editor').setContent('欢迎使用ueditor', isAppendTo);
        msginfo(arr.join("\n"));
    }
     var editor_discover = UE.getEditor('editor_discover');
    
</script>
</body>
</html>
