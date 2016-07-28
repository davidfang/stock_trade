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
        .widget-body{
            display: inline-block;
            width: 100%;
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
                
    <!--<div class="col-lg-12 col-sm-12 col-xs-12">-->
        <!--<div class="widget flat">-->
            <!--<div class="widget-header">-->
                <!--<span class="widget-caption">基本信息</span>-->
            <!--</div>&lt;!&ndash;Widget Header&ndash;&gt;-->
            <!--<div class="widget-body">-->

                <div class="col-lg-12 col-sm-12 col-xs-12">
                    <div class="widget flat">
                        <div class="widget-header">
                            <span class="widget-caption">用户信息</span>
                        </div><!--Widget Header-->
                        <div class="widget-body">
                            <?php if(is_array($user_distribute)): foreach($user_distribute as $key=>$vo): ?><div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                    <div class="databox radius-bordered databox-shadowed databox-graded">
                                        <div class="databox-left bg-palegreen">
                                            <div class="databox-piechart">
                                                <div id="users-pie" data-toggle="easypiechart" class="easyPieChart"
                                                     data-barcolor="#fff" data-linecap="butt"
                                                     data-percent="<?php echo ($vo["num_rate"]); ?>" data-animate="500" data-linewidth="3" data-size="47"
                                                     data-trackcolor="rgba(255,255,255,0.1)"
                                                     style="width: 47px; height: 47px; line-height: 47px;">

                                                    <span class="white font-90"><?php echo ($vo["num_rate"]); ?>%</span>
                                                    <canvas width="47" height="47"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="databox-right">
                                            <span class="databox-number green"><?php echo ($vo["user_num"]); ?> 人</span>
                                            <div class="databox-text darkgray">
                                                <?php if($vo["grade_id"] == 0): ?>普通用户
                                                <?php elseif($vo["grade_id"] == 1): ?>
                                                    一级代理
                                                <?php elseif($vo["grade_id"] == 2): ?>
                                                    二级代理
                                                <?php elseif($vo["grade_id"] == 3): ?>
                                                    三级代理<?php endif; ?>
                                            </div>
                                            <!--<div class="databox-state bg-themeprimary">-->
                                                <!--<i class="fa fa-check"></i>-->
                                            <!--</div>-->
                                        </div>
                                    </div>
                                </div><?php endforeach; endif; ?>
                        </div><!--Widget Body-->
                    </div><!--Widget-->
                </div>

                <div class="col-lg-12 col-sm-12 col-xs-12">
                    <div class="widget flat">
                        <div class="widget-header">
                            <span class="widget-caption">今日充值信息</span>
                        </div><!--Widget Header-->
                        <div class="widget-body">

                            <div class="databox radius-bordered databox-shadowed databox-graded databox-vertical">
                                <div class="databox-top no-padding ">
                                    <div class="databox-row">
                                        <div class="databox-cell cell-6 text-align-center bg-sky">
                                            <span class="databox-number"><?php echo ($prepaid['indent']); ?>单 / ￥<?php echo ($prepaid['indent_money']); ?></span>
                                            <span class="databox-text">今日的订单</span>
                                        </div>
                                        <div class="databox-cell cell-6 text-align-center bg-azure">
                                            <span class="databox-number"><?php echo ($prepaid['finish']); ?>单 / ￥<?php echo ($prepaid['finish_money']); ?></span>
                                            <span class="databox-text">今日的订单完成量</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="databox-bottom">
                                    <span class="databox-text">完成金额比：<?php echo ($prepaid['money_percentage']); ?>%</span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar progress-bar-azure" role="progressbar" aria-valuenow="<?php echo ($prepaid['money_percentage']); ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo ($prepaid['money_percentage']); ?>%">
                                            <span class="sr-only">
                                                <?php echo ($prepaid['money_percentage']); ?>% Complete
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div><!--Widget Body-->
                    </div><!--Widget-->
                </div>

                <div class="col-lg-12 col-sm-12 col-xs-12">
                    <div class="widget flat">
                        <div class="widget-header">
                            <span class="widget-caption">昨日提成信息</span>
                        </div><!--Widget Header-->
                        <div class="widget-body">
                            <div class="databox databox-xlg databox-halved radius-bordered databox-shadowed databox-vertical">
                                    <div class="databox-top bg-white padding-10">
                                        <div class="col-lg-12 col-sm-12 col-xs-12 text-align-center padding-10">
                                            <span class="databox-header carbon no-margin">昨日提成信息</span>
                                            <!--<span class="databox-text lightcarbon no-margin"> Software Manager at Microsoft </span>-->
                                        </div>
                                    </div>
                                    <div class="databox-bottom bg-white no-padding">
                                        <div class="databox-row row-12">
                                            <div class="databox-row row-6 no-padding">

                                                <?php if(is_array($yesterday_push)): foreach($yesterday_push as $key=>$vo): ?><div class="databox-cell cell-4 no-padding text-align-center bordered-right bordered-platinum">
                                                        <span class="databox-text sonic-silver  no-margin">
                                                           <?php if($vo["grade_id"] == 1): ?>一级代理
                                                               <?php elseif($vo["grade_id"] == 2): ?>
                                                               二级代理
                                                               <?php elseif($vo["grade_id"] == 3): ?>
                                                               三级代理<?php endif; ?>
                                                        </span>
                                                        <span class="databox-number lightcarbon no-margin"><?php echo ($vo["push_sum"]); ?> 元</span>
                                                    </div><?php endforeach; endif; ?>
                                                <?php if(empty($yesterday_push)): ?><div class="databox-cell cell-12 no-padding text-align-center bordered-platinum">
                                                        <span class="databox-number lightcarbon no-margin">无</span>
                                                    </div><?php endif; ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div><!--Widget Body-->
                    </div><!--Widget-->
                </div>

            <!--</div>&lt;!&ndash;Widget Body&ndash;&gt;-->
        <!--</div>&lt;!&ndash;Widget&ndash;&gt;-->
    <!--</div>-->


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


    <script>
        $(function(){
            InitiateEasyPieChart.init();
        })
    </script>
    <script src="/stock_trade/Public/assets/js/charts/easypiechart/jquery.easypiechart.js"></script>
    <script src="/stock_trade/Public/assets/js/charts/easypiechart/easypiechart-init.js"></script>


</body>
</html>