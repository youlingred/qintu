<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:62:"D:\phpStudy\WWW\minishop/application/admin\view\post\edit.html";i:1490931849;s:66:"D:\phpStudy\WWW\minishop/application/admin\view\common\header.html";i:1490584772;s:66:"D:\phpStudy\WWW\minishop/application/admin\view\common\navbar.html";i:1490584772;s:66:"D:\phpStudy\WWW\minishop/application/admin\view\common\footer.html";i:1490783690;}*/ ?>
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
  <link rel="stylesheet" type="text/css" href="STATIC_PATH/plugins/webuploader/examples/image-upload/style.css" />
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="STATIC_PATH/dist/js/html5shiv.min.js"></script>
  <script src="STATIC_PATH/dist/js/respond.min.js"></script>
  <![endif]-->
  <style type="text/css">
    label {
    display: inline-block;
    font-weight: 700;
    margin-bottom: 5px;
    max-width: 100%;
    font-size: 12px;
    }
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
        文章
        <small>撰写新文章</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> 主页</a></li>
        <li><a href="#">文章</a></li>
        <li class="active"><a href="#">撰写新文章</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <form action="<?php echo url('edit'); ?>" method="post" id="editPost">
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
              	<label>标题</label>
                <input id="title" name="title" class="form-control" value="<?php echo $postsInfo['title']; ?>" placeholder="标题">
                <input name="id" hidden="hidden" value="<?php echo $postsInfo['id']; ?>">
                <input name="uuid" hidden="hidden" value="<?php echo $postsInfo['uuid']; ?>">
              </div>
              <div class="form-group">
              	<label>别名</label>
                <input id="title" name="name" class="form-control" value="<?php echo $postsInfo['name']; ?>" placeholder="别名">
              </div>
              <div class="form-group">
              		<label>内容</label>
                  <script id="editor" name="content" type="text/plain" style="height:500px;"><?php echo $postsInfo['content']; ?></script>
              </div>
              <!--扩展表单-->
              <div class="form-extend">

              </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              <div class="pull-right">
                <button class="btn btn-success" onclick="javascript:history.back(-1);return false;">返 回</button>&nbsp;&nbsp;&nbsp;&nbsp;
                <button type="button" class="btn btn-default draft">保存草稿</button>
                <button type="button" class="btn btn-primary submit">更 新</button>
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
                <?php echo tree_to_checkbox($termTaxonomyTree); ?>
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
              <h3 class="box-title">封面图</h3>

              <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
                <div>
                  <input id="img_list" hidden="hidden" type="text" value="<?php if(is_array($coverList) || $coverList instanceof \think\Collection): $i = 0; $__LIST__ = $coverList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>,<?php echo $vo; endforeach; endif; else: echo "" ;endif; ?>" name="cover_path"/>
                </div>
                <div class="box-body cover_show">
                  <?php if(is_array($coverList) || $coverList instanceof \think\Collection): $i = 0; $__LIST__ = $coverList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                    <div class='form-group'><img class='cover_path' width=100% style='max-height:150px;' src='ROOT_PATH<?php echo $vo; ?>'></div>
                  <?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                  <a href="#" data-toggle="modal" data-target="#myModal">添加封面图</a>
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
                            <p>或将照片拖到这里，单次最多可选300张</p>
                        </div>
                    </div>
                    <div class="statusBar" style="display:none;">
                        <div class="progress">
                            <span class="text">0%</span>
                            <span class="percentage"></span>
                        </div><div class="info"></div>
                        <div class="btns">
                            <div id="filePicker2"></div><div class="uploadBtn">开始上传</div>
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
<!-- jQuery 2.2.0 -->
<script src="STATIC_PATH/plugins/jQuery/jquery-1.12.0.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="STATIC_PATH/bootstrap/js/bootstrap.min.js"></script>
<!-- Slimscroll -->
<script src="STATIC_PATH/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- AdminLTE App -->
<script src="STATIC_PATH/dist/js/app.min.js"></script>
<script src="STATIC_PATH/bootstrap/js/bootstrap-datetimepicker.js"></script>
<script src="STATIC_PATH/bootstrap/js/bootstrap-datetimepicker.zh-CN.js"></script>
<link href="STATIC_PATH/bootstrap/css/bootstrap-datetimepicker.css" rel="stylesheet"/>

<!-- Page Script -->
<script type="text/javascript">
  var uploadPictuer     = '<?php echo url('Upload/uploadPicture'); ?>';
  var ueditorUploadPath = '<?php echo url('ueditor/index'); ?>';
</script>
<script type="text/javascript" charset="utf-8" src="STATIC_PATH/plugins/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="STATIC_PATH/plugins/ueditor/ueditor.all.min.js"> </script>
<!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
<!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
<script type="text/javascript" charset="utf-8" src="STATIC_PATH/plugins/ueditor/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript" src="STATIC_PATH/plugins/webuploader/dist/webuploader.js"></script>
<script type="text/javascript" src="STATIC_PATH/plugins/webuploader/examples/image-upload/upload.js"></script>
<script type="text/javascript">
  $().ready(function () {
    $('.insert_images').on('click',function () {
        var list = new Array(); //定义一数组
        list = $('#img_list').val().split(","); //字符分割
        //下面使用each进行遍历
        var text = '';
        $.each(list,function(n,value) {
          if (value !== null && value !== undefined && value !== '') {
            text = text+"<div class='form-group'><img class='cover_path' width=100% style='max-height:150px;' src='ROOT_PATH"+value+"'></div>";
          }
        });
        $('.cover_show').html(text);
        uploader = "<div class='queueList'><div id='dndArea' class='placeholder'><div id='filePicker'></div><p>或将照片拖到这里，单次最多可选300张</p></div></div><div class='statusBar' style='display:none;'><div class='progress'><span class='text'>0%</span><span class='percentage'></span></div><div class='info'></div><div class='btns'><div id='filePicker2'></div><div class='uploadBtn'>开始上传</div></div></div>";
        // 重置uploader
        $('#uploader').html(uploader);
        // 隐藏Modal
        $('#myModal').modal('hide');
    });
    // 保存到草稿箱
    $('.draft').click(function () {
        $.ajax({
          cache: true,
          type: "POST",
          url : '<?php echo url('draft'); ?>',
          data: $('#addPost').serialize(),
          async: false,
            success: function(data) {
              if (data.code) {
                  msgok(data.msg);
              } else {
                  msgerr(data.msg);
              }
            },
            error: function(request) {
              msgerr("页面错误");
            }
        });
    });

    // 更新文章
    $('.submit').click(function () {
        $.ajax({
          cache: true,
          type: "POST",
          url : '<?php echo url('edit'); ?>',
          data: $('#editPost').serialize(),
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

    // ajax调用绑定表单
    $("[name='category_ids[]']").click(function(){
      initForm();
    });

    <?php if(is_array($categoryList) || $categoryList instanceof \think\Collection): $i = 0; $__LIST__ = $categoryList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
      $("input:checkbox[value='<?php echo $vo['term_taxonomy_id']; ?>']").attr('checked','true');
    <?php endforeach; endif; else: echo "" ;endif; ?>


    // 获取表单模板
    function getForm(formName){
      $.ajax({
        cache: true,
        type: "POST",
        url : '<?php echo url('FormBuilder/parse'); ?>',
        data: {'formName':formName,'uuid':'<?php echo $postsInfo['uuid']; ?>'},
        async: false,
          success: function(data) {
            if (data.code) {
                $('.form-extend').html(data.data);
            } else {
                $('.form-extend').html('');
                msgerr(data.msg);
            }
          },
          error: function(request) {
            msgerr("页面错误");
          }
      });
    }

    // 初始化表单
    initForm();
    function initForm(){
      var category_ids = '';
      $("[name='category_ids[]']").each(function(){
        if($(this).prop("checked")){
          category_ids += ','+$(this).val();
        }
      });
      $.ajax({
        cache: true,
        type: "POST",
        url : '<?php echo url('getBindForm'); ?>',
        data: {'categoryIds':category_ids},
        async: false,
          success: function(data) {
            if (data.code) {
                getForm(data.data);
            } else {
                $('.form-extend').html('');
                if(data.msg) {
                	msgerr(data.msg);
                }
            }
          },
          error: function(request) {
            msgerr("页面错误");
          }
      });
    }

  })
</script>
<script type="text/javascript">

    //实例化编辑器
    //建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
    var ue = UE.getEditor('editor');

    function getContent() {
        var arr = [];
        arr.push("使用editor.getContent()方法可以获得编辑器的内容");
        arr.push("内容为：");
        arr.push(UE.getEditor('editor').getContent());
        msginfo(arr.join("\n"));
    }
    function setContent(isAppendTo) {
        var arr = [];
        arr.push("使用editor.setContent('欢迎使用ueditor')方法可以设置编辑器的内容");
        UE.getEditor('editor').setContent('欢迎使用ueditor', isAppendTo);
        msginfo(arr.join("\n"));
    }
    function getLocalData () {
        msgok(UE.getEditor('editor').execCommand( "getlocaldata" ));
    }
    function clearLocalData () {
        UE.getEditor('editor').execCommand( "clearlocaldata" );
        msgok("已清空草稿箱")
    }
</script>
</body>
</html>
