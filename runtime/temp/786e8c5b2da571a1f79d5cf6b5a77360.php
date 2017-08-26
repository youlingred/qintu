<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:65:"D:\phpStudy\WWW\minishop/application/admin\view\order\detail.html";i:1495268859;s:64:"D:\phpStudy\WWW\minishop/application/admin\view\common\head.html";i:1490584772;s:66:"D:\phpStudy\WWW\minishop/application/admin\view\common\header.html";i:1490584772;s:66:"D:\phpStudy\WWW\minishop/application/admin\view\common\navbar.html";i:1490584772;s:66:"D:\phpStudy\WWW\minishop/application/admin\view\common\footer.html";i:1490783690;}*/ ?>
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
           订单详情 
                        
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo url('Index/index'); ?>"><i class="fa fa-dashboard"></i> 主页</a></li>
        <li class="active"><a href="<?php echo url('order/index'); ?>">订单</a></li>
        <li class="active">订单详情</li>
      </ol>
    </section>

    <!-- Main content -->
      <!-- form start -->
          <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a data-toggle="tab" href="#fa-icons">订单详情</a></li>
              
            </ul>
            <div class="tab-content">
                
            <form id="form">
              <table class="table table-bordered" >
                <tr>
                  <td style="text-align:right;padding-right:20px;">订单号</td>
                  <td style="text-align:left;padding-left:20px;"><?php echo $ordersInfo['order_no']; ?></td>
                  <td style="text-align:right;padding-right:20px;">生成订单时间 </td>
                  <td style="text-align:left;padding-left:20px;"><?php echo date("Y-m-d H:i:s ",$ordersInfo['createtime']); ?></td>
                 	<td style="text-align:right;padding-right:20px;">商品总价</td>
                  <td style="text-align:left;padding-left:20px;"><?php echo $ordersInfo['amount']; ?></td>
                </tr>
                <tr>
                  <td style="text-align:right;padding-right:20px;">收货人</td>
                  <td style="text-align:left;padding-left:20px;">
                  <input type="text" name="consignee_name" value="<?php echo $ordersInfo['consignee_name']; ?>">
                  </td>
                  <td style="text-align:right;padding-right:20px;">联系方式  </td>
                  <td style="text-align:left;padding-left:20px;">
                    <input type="text" name="mobile" value="<?php echo $ordersInfo['mobile']; ?>">
                  </td>
                </tr>
              </table>
              <input type="hidden" name="ordersId" value="<?php echo $ordersInfo['id']; ?>">
              <!--<div >
                <input type="submit" value="提交"  style="float:right" class="submit btn btn-primary">
                <?php if($ordersInfo['status'] == 'paid'): ?>
                <input type="submit" value="发货"  style="float:right;margin-right:20px;" class="send btn btn-success">
                <?php endif; if($ordersInfo['status'] == 'shipped'): ?>
                <input type="submit" value="完成"  style="float:right;margin-right:20px;" class="completed btn btn-success">
                <?php endif; ?>
              </div>-->
              </div>
             
              </form> 
  <table class="table table-hover table-striped">
                  <thead>
                  <tr>
                  
                    <th>商品名称</th>
                    <th>出发日期</th> 
                    <th>成人</th>
                    <th>儿童</th>
                    <th>价格</th>                  
                  </tr>
                  </thead>
                  <tbody>
                      <?php if(is_array($goodInfo) || $goodInfo instanceof \think\Collection): $i = 0; $__LIST__ = $goodInfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?>
                  <tr>
                                      
                  <!-- <td><a href="<?php echo url('index/goods/detail?id='.$list['goods_id']); ?>"><?php echo $list['name']; ?></a></td>-->
                   <td><?php echo $list['name']; ?></td>
                   <td><?php echo date("Y-m-d",$list['departure_time']); ?></td>
                   <td><?php echo $list['man_num']; ?></td>
                   <td><?php echo $list['child_num']; ?></td>
                    <td><?php echo $list['price']; ?></td>
        
                  </tr>
                  <?php endforeach; endif; else: echo "" ;endif; ?>

                 
                  </tbody>
                  <thead>
                  <tr>                  
                    <th>商品名称</th>
                    <th>出发日期</th> 
                    <th>成人</th>
                    <th>儿童</th>
                    <th>价格</th>                       
                  </tr>
                  </thead>
                </table>
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



</div>
<!-- ./wrapper -->

<script src="STATIC_PATH/plugins/jQuery/jquery-1.9.1.min.js"></script>
<script src="STATIC_PATH/plugins/jQueryUI/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->

<script type="text/javascript">
  
  var val_status =  $("#status").val();
  $("#status1 option[value="+val_status+"]").attr("selected",true);

  $('.submit').click(function () {
        $.ajax({
          cache: true,
          type: "POST",
          url : '<?php echo url('edit'); ?>',
          data: $('#form').serialize(),
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
  
    $('.send').click(function () {
        $.ajax({
          cache: true,
          type: "POST",
          url : '<?php echo url('send'); ?>',
          data: $('#form').serialize(),
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

    $('.completed').click(function () {
        $.ajax({
          cache: true,
          type: "POST",
          url : '<?php echo url('completed'); ?>',
          data: $('#form').serialize(),
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

 </script>

 <!-- <script>
 function submitInfo(){

        var id = $("#id").val();
        var order_no = $("#order_no").val();
        var pay_type = $("#pay_type").val();
        var price = $("#price").val();
        var num = $("#num").val();
        var amount = $("#amount").val();
        var status = $("#status1").val();
        
      
         $.ajax({
             type: "POST",
             url: "<?php echo url('admin/order/edit'); ?>",
             data: {id            :id,
                    post_title    :post_title,
                    order_no      :order_no,
                    pay_type      :pay_type,  
                    price         :price,
                    num           :num,
                    amount        :amount,
                    status        :status
                    },
             dataType: "json",
             success: function(data){
                     alert(data.msg);
                      },
        
         });
        
    }
  
</script> -->
<!-- Bootstrap 3.3.6 -->
<script src="STATIC_PATH/bootstrap/js/bootstrap.min.js"></script>
<!-- Slimscroll -->
<script src="STATIC_PATH/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- AdminLTE App -->
<script src="STATIC_PATH/dist/js/app.min.js"></script>
</body>
</html>






