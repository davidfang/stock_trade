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
            height: 450px;
        }
        .form-control{
            width: 50%;
            display: inline-block;
        }
        .control-label{
            line-height: 34px;
            margin-bottom: 0px;
        }
        .form_label{
            display: inline-block;
            max-width: 100%;
            margin-bottom: 0px;
            line-height: 34px;
            float: none;
            padding-right: 0px;
        }
        .form_text{
            width: 15%;
            display: inline-block;
        }
        .add_trading select{
            width: 50%;
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

                                    <label for="phone" class="col-sm-1 control-label text-align-right form_label">手机号：</label>
                                    <input type="tel" maxlength="11" value="<?php echo ($phone); ?>" class="form-control form_text" name="phone" id="phone">
                                    <label for="name" class="col-sm-1 control-label text-align-right form_label">用户名：</label>
                                    <input type="text" maxlength="5" value="<?php echo ($name); ?>" class="form-control form_text" name="name" id="name">
                                    <button id="seek" type="button" class="btn btn-primary" url="<?php echo U('Admin/drawings_list');?>" style="padding: 7px; margin-top: -3px;">
                                        <i class="fa fa-search"></i>搜索
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-toolbar operation">
                    <div class="btn-group">
                        <a id="import_excel" href="javascript:void(0);" class="btn btn-default">
                            <i class="glyphicon glyphicon-log-in"></i>导入记录
                        </a>
                    </div>
                    <div class="btn-group">
                        <a type="button" id="add_record" class="btn btn-default" href="javascript:void(0);">
                            <i class=""></i>添加记录
                        </a>
                    </div>
                </div>
                <table class="table_data table table-striped table-hover table-bordered">
                    <thead>
                    <tr role="row">
                        <th>用户</th>
                        <th>产品</th>
                        <th>交易手数</th>
                        <th>联系电话</th>
                        <th>时间</th>
                    </tr>
                    </thead>
                    <tbody class="data_user">
                    <?php if(is_array($poundage_list)): foreach($poundage_list as $key=>$vo): ?><tr>
                            <td><?php echo ($vo["name"]); ?></td>
                            <td><?php echo ($vo["product"]); ?></td>
                            <td><?php echo ($vo["number"]); ?></td>
                            <td><?php echo ($vo["phone"]); ?></td>
                            <td><?php echo (date("Y-m-d",$vo["create_time"])); ?></td>
                        </tr><?php endforeach; endif; ?>
                    </tbody>
                </table>
                <div class="page"><?php echo ($show_page); ?></div>
            </div><!--Widget Body-->
        </div><!--Widget-->
    </div>


    <div class="add_trading modal modal-darkorange">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="user" class="col-sm-3 control-label text-align-right"> 手机号：</label>
                        <input type="tel" placeholder="请输入用户手机号" class="form-control" name="user" id="user">
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label text-align-right">选择产品：</label>
                        <select id="product">
                            <option value="">请选择产品</option>
                            <?php if(is_array($product)): foreach($product as $key=>$vo): ?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["name"]); ?></option><?php endforeach; endif; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="number" class="col-sm-3 control-label text-align-right"> 交易手数：</label>
                        <input type="number" placeholder="请输入交易手数" class="form-control" name="number" id="number">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="modal_close btn btn-default" data-dismiss="modal">取消</button>
                    <button type="button" url="<?php echo U('Admin/push_info');?>" class="affirm_save btn btn-default">确认</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <input value="<?php echo U('Admin/download_template');?>" id="download-template-url" type="hidden">
    <input type="hidden" value="<?php echo U('Admin/add_trading_record');?>" url="<?php echo U('Admin/trading_record');?>" id="trading_record">
    <input value="<?php echo U('Admin/import_trading_record');?>" id="import-url" type="hidden">

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


    <script src="/stock_trade/Public/assets/js/datetime/daterangepicker.js"></script>
    <script>
        $(function(){
            $('#time').daterangepicker();
            $("#status option[value="+$("#status").attr('data')+"]").attr("selected", true);
            var url = $("#trading_record").attr('url');
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


                var phone = $.trim($("#phone").val());
                var name = $.trim($("#name").val());
                window.location.href=url+"?begin="+begin+"&end="+end+"&phone="+phone+"&name="+name;
            })

            $("#add_record").click(function(){
                $("#user").val(null);
                $("#number").val(null);
                $(".add_trading").modal({show:true})
            })

            var add_url = $("#trading_record").val();
            $(".affirm_save").click(function(){
                var user = $.trim($("#user").val());
                var product = $.trim($("#product").find("option:selected").text());
                var number = $.trim($("#number").val());
                if(number<0){
                    hint("warning",'提示','请仔细填写交易手数！');
                    return;
                }
                $.get(
                        add_url,
                        {
                            user:user,
                            product:product,
                            number:number
                        },
                        function(data){
                            if(data['code']==0){
                                hint('success',data['msg'],data['data'],true);
                            }else if(data['code']==1){
                                hint('warning',data['msg'],data['data']);
                            }else if(data['code']==2){
                                hint('warning',data['msg'],data['data']);
                            }
                        }
                )
            })

        })
    </script>
    <style>
    .modal-darkorange .import-btn{
        cursor: pointer;
        /*margin-bottom: 10px;*/
    }
    .modal-darkorange .file-bar{
        padding: 10px;
        font-size: 18px;
        font-weight: bold;
    }
    .modal-darkorange p{
        color:#777;
    }

</style>
<!--import Modal Templates-->
<div id="import-modal" style="display:none;">
    <input type="file" name="import" class="import-submit" style="display: none">
    <a class="import-btn">上传文件</a>
    <div class="file-bar"></div>
    <p>请上传规定格式的Excel文件,<a id="download-template">下载模板</a></p>
</div>
<!--End import Modal Templates-->
<script>
    $(document).on('click','a.import-btn',function(e){
        e.preventDefault();
        $('.modal-darkorange .import-submit').click();
    })
    $(document).on('change','.import-submit',function(e){
        $(this).siblings('.file-bar').text(this.files[0].name);
    })
    $('#import_excel').on('click',function(e){
        e.preventDefault();
        bootbox.dialog({
            message: $("#import-modal").html(),
            title: "导入文件",
            className: "modal-darkorange",
            buttons: {
                success: {
                    label: "导入",
                    className: "btn-blue",
                    callback: function () {
                        var formdata = new FormData ();
                        var url = $('#import-url').val();
                        formdata.append('import_file',$('.modal-darkorange .import-submit')[0].files[0]);
                        $.ajax({
                            url :url,
                            type: 'post',
                            data:formdata,
                            cache: false,
                            processData:false,
                            contentType:false,
                            success:function(data){
                                if(data.code == 0){
                                    hint('success',data.msg, data.data,true);
                                }else{
                                    hint('warning',data.msg,data.data);
                                }
                                return false;
                            }
                        })
                    }
                },
                "取消": {
                    className: "btn",
                    callback: function () {}
                }
            }
        });
        $('.modal-darkorange').find('#download-template').attr('href',$('#download-template-url').val());
    })
</script>


</body>
</html>