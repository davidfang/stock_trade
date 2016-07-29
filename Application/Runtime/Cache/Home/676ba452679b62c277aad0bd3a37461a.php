<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title><?php echo ($title); ?></title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <!--Basic Styles-->
    <link href="/stock_trade/Public/assets/css/bootstrap.min.css" rel="stylesheet"/>

    <link href="/stock_trade/Public/assets/css/font-awesome.min.css" rel="stylesheet"/>
    <link href="/stock_trade/Public/assets/css/dataTables.bootstrap.css" rel="stylesheet"/>

    <!--Beyond styles-->
    <link href="/stock_trade/Public/assets/css/beyond.min.css" rel="stylesheet"/>
    <link href="/stock_trade/Public/assets/css/demo.min.css" rel="stylesheet"/>
    <link href="/stock_trade/Public/assets/css/typicons.min.css" rel="stylesheet"/>
    <link href="/stock_trade/Public/assets/css/animate.min.css" rel="stylesheet"/>

    <link href="/stock_trade/Public/Home/Css/page.css" rel="stylesheet"/>
    <style>
        .widget-body{
            display: inline-table!important;
        }
        .page-header{
            display: none;
        }
    </style>
    <!--引入css文件-->
    
    <style>
        .form-group{
            display: inline-block;
            width: 100%;
        }
        .widget-body{
            display: inline-block;
            width: 100%;
            height: 450px;
        }
        .save_info{
            float: right;
            margin-right: 45%;
            margin-top: 10%;
        }
        .form_label{
            display: inline-block;
            max-width: 100%;
            margin-bottom: 0px;
            line-height: 34px;
        }
        .form_text{
            width: 40%;
            display: inline-block;
        }
    </style>

</head>
<body>
<!-- Navbar -->
<div class="navbar">
    <div class="navbar-inner">
        <div class="navbar-container">
            <!-- Navbar Barnd -->
            <div class="navbar-header pull-left">
                <a href="#" class="navbar-brand">
                    <small>
                        <img src="/stock_trade/Public/assets/img/logo.png" alt=""/>
                    </small>
                </a>
            </div>
            <!-- /Navbar Barnd -->
            <!-- Sidebar Collapse -->
            <div class="sidebar-collapse" id="sidebar-collapse">
                <i class="collapse-icon fa fa-bars"></i>
            </div>
            <!-- /Sidebar Collapse -->
            <!-- Account Area and Settings --->
            <div class="navbar-header pull-right">
                <div class="navbar-account">
                    <ul class="account-area">
                        <li class="">
                            <a class="login-area dropdown-toggle" data-toggle="dropdown">
                                <section>
                                    <h2><span class="profile"><span><?php echo ($user['name']); ?>，您好！</span></span></h2>
                                </section>
                            </a>
                            <!--Login Area Dropdown-->
                            <ul style="min-width: 70px;width: 124px;" class="pull-right dropdown-menu dropdown-arrow dropdown-login-area">
                                <li class="username"><a><?php echo ($user['name']); ?></a></li>
                                <li><a href="<?php echo U('Personal/personal_info');?>" style="text-align: center;">个人信息</a></li>
                                <li class="dropdown-footer">
                                    <a href="<?php echo U('Login/login_out');?>">
                                        退出
                                    </a>
                                </li>
                            </ul>
                            <!--/Login Area Dropdown-->
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Navbar -->
<!-- Main Container -->
<div class="main-container container-fluid">
    <!-- Page Container -->
    <div class="page-container">
        <!-- Page Sidebar -->
        <div class="page-sidebar" id="sidebar">
            <!-- /Page Sidebar Header -->
            <!-- Sidebar Menu -->
            <ul class="nav sidebar-menu">
                <?php
 list($first, $last) = explode(' / ',$route); foreach( $nav as $key => $item ){ if($item['name'] == $first){ if(!$item['url']){ echo '<li class="active open">'; }else{ echo '<li class="active">'; } }else{ echo '<li>'; } if($item['url']){ echo '<a href="'.$item['url'].'">'; }else{ echo '<a href="#" class="menu-dropdown">'; } echo '<i class="menu-icon '.$item['ico'].'"></i>'; echo '<span class="menu-text">'.$item['name'].'</span>'; if(!$item['url']){ echo '<i class="menu-expand"></i>'; } echo '</a>'; if(!$item['url']){ echo '<ul class="submenu">'; foreach( $item['children'] as $k => $value ){ if($value['name'] == $last){ echo '<li class="active">'; }else{ echo '<li>'; } echo '<a href="'. $value['url'] .'">'; echo '<span class="menu-text">'.$value['name'].'</span>'; echo '</a></li>'; } echo '</ul>'; } } ?>
            </ul>
            <!-- /Sidebar Menu -->
        </div>

        <div class="page-content">
            <div class="page-breadcrumbs">
                <ul class="breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <?php echo ($route); ?>
                    </li>
                </ul>
            </div>
            <div class="page-header position-relative">
                <div class="header-title">
                    <h1>
                        <?php echo ($header_title); ?>
                    </h1>
                </div>
            </div>
            <div class="age-body">
                
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="widget flat">
            <div class="widget-header">
                <span class="widget-caption">基本信息修改</span>
            </div><!--Widget Header-->
            <div class="widget-body">
                <div class="form-group" style="margin-top: 30px;">
                    <label for="name" class="col-sm-2 control-label text-align-right form_label">姓名：</label>
                    <input type="text" maxlength="5" class="form-control form_text" value="<?php echo ($user['name']); ?>" name="name" id="name">
                </div>
                <?php if(session('user')['type'] == 1): ?><div class="form-group">
                        <label class="col-sm-2 control-label text-align-right">身份：</label>
                        <span class="col-sm-10 control-label"><?php echo ($user['grade_name']); ?></span>
                    </div><?php endif; ?>
                <div class="form-group">
                    <label for="identity_card" class="col-sm-2 control-label text-align-right form_label">身份证号：</label>
                    <input type="text" maxlength="18" class="form-control form_text" value="<?php echo ($user['identity_card']); ?>" name="identity_card" id="identity_card">
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label text-align-right">手机号：</label>
                    <span class="col-sm-10 control-label"><?php echo ($user['phone']); ?></span>
                </div>
                <div class="form-group">
                    <label for="email" class="col-sm-2 control-label text-align-right form_label">邮箱：</label>
                    <input type="text" class="form-control form_text" value="<?php echo ($user['email']); ?>" name="email" id="email">
                </div>
                <div class="form-group">
                    <label for="address" class="col-sm-2 control-label text-align-right form_label">地址：</label>
                    <input type="text" maxlength="100" class="form-control form_text" value="<?php echo ($user['address']); ?>" name="address" id="address">
                </div>
                <a class="btn btn-blue shiny save_info" to-url="<?php echo U('Personal/personal_info');?>" url="<?php echo U('Personal/save_personal_info');?>">保存</a>
            </div><!--Widget Body-->
        </div><!--Widget-->
    </div>

            </div>
        </div>
    </div>
    <!-- /Page Container -->
    <!-- Main Container -->
</div>

<!--加载-->
<div class="loading-container">
    <div class="loading-progress">
        <img src="/stock_trade/Public/assets/img/loading.gif">
    </div>
</div>
<!--提示信息模态框-->
<!---------提示信息模态框------------------>
<!--Success Modal Templates-->
<div id="modal-success" class="modal modal-message modal-success fade" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <i class="glyphicon glyphicon-check"></i>
            </div>
            <div class="modal-title">Success</div>

            <div class="modal-body">You have done great!</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">OK</button>
            </div>
        </div>
        <!-- / .modal-content -->
    </div>
    <!-- / .modal-dialog -->
</div>
<!--End Success Modal Templates-->
<!--Info Modal Templates-->
<div id="modal-info" class="modal modal-message modal-info fade" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <i class="fa fa-envelope"></i>
            </div>
            <div class="modal-title">Alert</div>

            <div class="modal-body">You'vd got mail!</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info" data-dismiss="modal">OK</button>
            </div>
        </div>
        <!-- / .modal-content -->
    </div>
    <!-- / .modal-dialog -->
</div>
<!--End Info Modal Templates-->
<!--Danger Modal Templates-->
<div id="modal-danger" class="modal modal-message modal-danger fade" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <i class="glyphicon glyphicon-fire"></i>
            </div>
            <div class="modal-title">Alert</div>

            <div class="modal-body">You'vd done bad!</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">OK</button>
            </div>
        </div>
        <!-- / .modal-content -->
    </div>
    <!-- / .modal-dialog -->
</div>
<!--End Danger Modal Templates-->
<!--Danger Modal Templates-->
<div id="modal-warning" class="modal modal-message modal-warning fade" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <i class="fa fa-warning"></i>
            </div>
            <div class="modal-title">Warning</div>

            <div class="modal-body">Is something wrong?</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-dismiss="modal">OK</button>
            </div>
        </div>
        <!-- / .modal-content -->
    </div>
    <!-- / .modal-dialog -->
</div>
<!---------------end------------------------->

<!--Skin Script: Place this script in head to load scripts for skins and rtl support-->
<script src="/stock_trade/Public/assets/js/skins.min.js"></script>
<!--Basic Scripts-->
<script src="/stock_trade/Public/assets/js/jquery-2.0.3.min.js"></script>
<script src="/stock_trade/Public/assets/js/bootstrap.min.js"></script>

<!--Beyond Scripts-->
<script src="/stock_trade/Public/assets/js/beyond.min.js"></script>
<script src="/stock_trade/Public/assets/js/datetime/moment.js"></script>
<script src="/stock_trade/Public/assets/js/datetime/daterangepicker.js"></script>
<script src="/stock_trade/Public/assets/js/bootbox/bootbox.js"></script>
<script src="/stock_trade/Public/assets/js/validation/bootstrapValidator.js"></script>
<script src="/stock_trade/Public/assets/js/fullcalendar/fullcalendar.js"></script>
<script src="/stock_trade/Public/Home/Js/hint.js"></script>

<script>
    $(function(){
        for(var i=0;i < $('table').length;i++){
            var table = $('table').eq(i);
            if(table.find('tr').length==1){
                var th_len = table.find('th').length;
                var html = '<tr><td colspan="'+th_len+'">没有数据哦</td></tr>';
                table.append(html);
            }
        }
    })
</script>


    <script src="/stock_trade/Public/Home/Js/edit_personal_info.js"></script>


</body>
</html>