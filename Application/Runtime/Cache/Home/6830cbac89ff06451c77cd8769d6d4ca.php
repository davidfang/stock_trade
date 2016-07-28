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
        .form_label{
            line-height: 34px;
        }
        .head_img{
            line-height: 200px;
        }
        .user_info{
            height: 200px;
            padding: 25px!important;
        }
        .asset{
            padding: 0px;
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
                

    <div class="col-lg-12 col-sm-12 col-xs-12 margin-bottom-20">
        <div class="profile-container">
            <div class="profile-header row" style="margin: 0px;">
                <div class="col-lg-2 col-md-12 col-sm-12 text-center head_img">
                    <img src="/stock_trade/Public/Home/Images/default.jpg" alt=""
                         class="header-avatar">
                </div>
                <div class="col-lg-5 col-md-12 col-sm-12 profile-info user_info">
                    <div class="header-fullname"><?php echo ($user_info['name']); ?></div>
                    <div class="header-information"><?php echo ($user_info['identity_card']); ?></div>
                </div>
                <div class="col-lg-5 col-md-12 col-sm-12 col-xs-12 profile-stats asset">
                    <div style="margin-bottom: 0px;" class="databox databox-xlg databox-halved radius-bordered databox-shadowed databox-vertical">
                        <div class="databox-top bg-white padding-10">
                            <div class="col-lg-12 col-sm-12 col-xs-12 text-align-center padding-10">
                                <span class="databox-header carbon no-margin">我的资产</span>
                            </div>
                        </div>
                        <div class="databox-bottom bg-white no-padding">
                            <div class="databox-row row-12">
                                <div class="databox-row row-6 no-padding">
                                    <div class="databox-cell cell-6 no-padding text-align-center bordered-right bordered-platinum">
                                        <span class="databox-text sonic-silver no-margin">
                                            账户资金（元）
                                        </span>
                                        <span class="databox-number lightcarbon no-margin"><?php echo ($user_info['current']); ?> 元</span>
                                    </div>

                                    <div class="databox-cell cell-6 no-padding text-align-center">
                                        <span class="databox-text sonic-silver no-margin">我的产品（种）</span>
                                        <span class="databox-number lightcarbon no-margin"><?php echo ($product_sum); ?> 种</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="widget flat">
            <div class="widget-header">
                <span class="widget-caption">交易记录</span>
            </div><!--Widget Header-->
            <div class="widget-body">
                <div class="table-toolbar">
                    <div class="panel-group accordion" id="accordion" style="margin-bottom: 8px;">
                        <div class="panel panel-default">
                            <div class="panel-heading ">
                                <h4 class="panel-title">
                                    <a class="accordion-toggle collapsed" data-toggle="collapse"
                                       data-parent="#accordion"
                                       href="#collapseOne">
                                        <i class="fa fa-search"></i> 高级搜索
                                    </a>
                                </h4>
                            </div>

                            <div id="collapseOne" class="panel-collapse collapse">
                                <div class="panel-body">

                                    <label for="time" style="float: left;" class="col-sm-1 control-label text-align-right form_label">日期：</label>
                                    <div class="controls" style="float: left;width: 21%;display: inline-block;">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </span><input type="text" value="<?php echo ($time); ?>" class="form-control active" id="time">
                                        </div>
                                    </div>

                                    <label class="col-sm-1 control-label text-align-right form_label">分类：</label>
                                    <select id="product" class="form_text" data="<?php echo ($product); ?>">
                                        <option value="">全部</option>
                                        <?php if(is_array($product_list)): foreach($product_list as $key=>$vo): ?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["name"]); ?></option><?php endforeach; endif; ?>
                                    </select>

                                    <button id="seek" type="button" class="btn btn-primary" style="padding: 7px;">
                                        <i class="fa fa-search"></i>搜索
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <table class="table_data table table-striped table-hover table-bordered">
                    <thead>
                    <tr role="row">
                        <th>产品</th>
                        <th>交易手数</th>
                        <th>日期</th>
                    </tr>
                    </thead>
                    <tbody class="data_user">
                    <?php if(is_array($trade_info)): foreach($trade_info as $key=>$vo): ?><tr>
                            <td><?php echo ($vo["product"]); ?></td>
                            <td><?php echo ($vo["number"]); ?></td>
                            <td><?php echo (date("Y-m-d",$vo["create_time"])); ?></td>
                        </tr><?php endforeach; endif; ?>
                    </tbody>
                </table>
                <div class="page"><?php echo ($show_page); ?></div>

            </div><!--Widget Body-->
        </div><!--Widget-->
    </div>

    <input type="hidden" url="<?php echo U('User/index');?>" id="seek_url" />


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
        if($('table tr').length==1){
            var html = '<tr><td colspan="9999">没有数据哦</td></tr>'
            $('table').append(html);
        }
    })
</script>


    <script src="/stock_trade/Public/assets/js/datetime/daterangepicker.js"></script>
    <script>
        $(function(){
            $('#time').daterangepicker();

            $("#product option[value="+$("#product").attr('data')+"]").attr('selected',true);

            var url = $("#seek_url").attr('url');
            $("#seek").click(function(){
                var time = $.trim($("#time").val());
                var begin = '';
                var end = '';
                var condition = new RegExp(/^[0|1]\d[/][0|1|2|3]\d[/]\d{4}[ ][-][ ][0|1]\d[/][0|1|2|3]\d[/]\d{4}$/);
                if(time!=''){
                    if(!condition.test(time)){
                        hint('warning', '提示', '日期格式有误！！！');
                        return;
                    }else{
                        var time_res = time.split("-");
                        begin = $.trim(time_res[0]);
                        end = $.trim(time_res[1]);
                        begin = Date.parse(new Date(begin))/1000;
                        end = Date.parse(new Date(end))/1000;
                    }
                }

                var product = $.trim($("#product").val());

                window.location.href=url+"?begin="+begin+"&end="+end+"&product="+product;
            })

        })
    </script>


</body>
</html>