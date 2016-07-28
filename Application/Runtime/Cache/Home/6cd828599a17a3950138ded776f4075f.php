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
        .form-control{
            width: 50%;
            display: inline-block;
        }
        .control-label{
            line-height: 34px;
            margin-bottom: 0px;
        }
        #begin,#end{
            width: 23%;
        }
        .push_modal select{
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
                <span class="widget-caption">提成信息</span>
            </div><!--Widget Header-->
            <div class="widget-body">
                <div class="table-toolbar operation">
                    <div class="btn-group">
                        <a type="button" class="add_push btn btn-default" href="javascript:void (0);">
                            <i class=""></i>添加
                        </a>
                    </div>
                </div>
                <table class="table_data table table-striped table-hover table-bordered">
                    <thead>
                    <tr role="row">
                        <th>代理</th>
                        <th>产品</th>
                        <th>次数限定</th>
                        <th>提成金额（元）</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody class="data_user">
                    <?php if(is_array($push_info)): foreach($push_info as $key=>$vo): ?><tr>
                            <td>
                                <?php if($vo["grade_id"] == 1): ?>一级代理
                                <?php elseif($vo["grade_id"] == 2): ?>
                                    二级代理
                                <?php elseif($vo["grade_id"] == 3): ?>
                                    三级代理<?php endif; ?>
                            </td>
                            <td><?php echo ($vo["name"]); ?></td>
                            <td><?php echo ($vo["begin"]); ?>~<?php echo ($vo["end"]); ?></td>
                            <td><?php echo ($vo["money"]); ?></td>
                            <td>
                                <a obj="<?php echo ($vo["id"]); ?>" class="save_push" href="javascript:void(0);">编辑</a>
                                <a obj="<?php echo ($vo["id"]); ?>" class="del_push" href="javascript:void(0);">删除</a>
                            </td>
                        </tr><?php endforeach; endif; ?>
                    </tbody>
                </table>
                <div class="page"><?php echo ($show_page); ?></div>
            </div><!--Widget Body-->
        </div><!--Widget-->
    </div>

    <input type="hidden" url="<?php echo U('Admin/del_agency');?>" id="del_agency">

    <div class="push_modal modal modal-darkorange">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label class="col-sm-3 control-label text-align-right form_label">选择代理：</label>
                        <select id="grade">
                            <option value="-1">请选择代理</option>
                            <option value="1">一级代理</option>
                            <option value="2">二级代理</option>
                            <option value="3">三级代理</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label text-align-right form_label">选择产品：</label>
                        <select id="product">
                            <option value="-1">请选择产品</option>
                            <?php if(is_array($product)): foreach($product as $key=>$vo): ?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["name"]); ?></option><?php endforeach; endif; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="begin" class="col-sm-3 control-label text-align-right"> 提成手数：</label>
                        <input type="number" placeholder="请输入开始手数" class="form-control" name="begin" id="begin">
                        <label style=" font-size: 26px;margin-bottom: 0px;">~</label>
                        <input type="number" placeholder="请输入结束手数" class="form-control" name="end" id="end">
                    </div>

                    <div class="form-group">
                        <label for="money" class="col-sm-3 control-label text-align-right"> 提成金额(元)：</label>
                        <input type="number" placeholder="请输入提成金额" class="form-control" name="money" id="money">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="modal_close btn btn-default" data-dismiss="modal">取消</button>
                    <button type="button" url="<?php echo U('Admin/push_info');?>" class="affirm_save btn btn-default">确认</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


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
        var obj = '';//修改或删除对象
        var url = $("#affirm_save").attr('url');    //操作地址
        $(".add_push").click(function(){
            obj = '';
            $(".push_modal").modal({show:true});
            $(".modal-title").text('添加设置');

            $("#grade option[value='-1']").attr("selected", true);
            $("#product option[value='-1']").attr("selected", true);

            $("#begin").val(null);
            $("#end").val(null);
            $("#money").val(null);
        })
        $(".save_push").click(function(){
            obj = $(this).attr('obj');
            $.post(
                url,
                {
                    set_id:obj,
                    type:'look'
                },function(data){
                    $("#grade option[value="+data.data['grade_id']+"]").attr("selected", true);
                    $("#product option[value="+data.data['product_id']+"]").attr("selected", true);
                    $("#begin").val(data.data['begin']);
                    $("#end").val(data.data['end']);
                    $("#money").val(data.data['money']);
                }
            )
            $(".push_modal").modal({show:true});
            $(".modal-title").text('修改设置');
        })

        var post=true;
        $(".affirm_save").click(function(){
            var post = true;
            var grade_id = $("#grade").val();
            var product_id = $("#product").val();
            var begin = get_data($("#begin"),true,'开始手数');
            var end = get_data($("#end"),true,'结束手数');
            var money = get_data($("#money"),true,'提成金额');
            if(grade_id==-1){
                hint('warning','提示','请选择代理！');
                post = false;
            }
            if(product_id==-1){
                hint('warning','提示','请选择产品！');
                post = false;
            }
            if(begin>end){
                hint('warning','提示','提成手数设定有误！');
                post = false;
            }
            if(!post){
                return;
            }
            $.post(
                    url,
                    {
                        set_id:obj,
                        grade_id:grade_id,
                        product_id:product_id,
                        begin:begin,
                        end:end,
                        money:money,
                    },function(data){
                        if(data['code']==0){
                            hint('success',data['msg'],data['data'],true);
                            $(".modal_close").click();
                        }else if(data['code']==1){
                            hint('warning',data['msg'],data['data']);
                        }else{
                            hint('warning','提示','未知错误！');
                        }
                    }
            )
        })

        function get_data(obj,neq_zero,info){
            var get_data = $.trim(obj.val());
            if(get_data==''){
                hint('warning','提示',info+'未设置！');
                post=false;
            }
            if(neq_zero){
                if(get_data<=0){
                    hint('warning','提示',info+'设置有误！');
                    post=false;
                }
            }else{
                if(get_data<0){
                    hint('warning','提示',info+'设置有误！');
                    post=false;
                }
            }
            return get_data;
        }

        $(".del_push").click(function(){
            var obj = $(this).attr('obj');
            bootbox.setDefaults("locale","zh_CN");
            bootbox.confirm("你确定要删除吗?", function (result) {
                if (!result) {
                    return;
                }else{
                    $.post(
                        url,
                        {
                            set_id:obj,
                            type:'del'
                        },function(data){
                            if(data['code']==0){
                                hint('success',data['msg'],data['data'],true);
                            }else if(data['code']==1){
                                hint('warning',data['msg'],data['data']);
                            }else{
                                hint('warning','提示','未知错误！');
                            }
                        }
                    )
                }
            })
        })

    </script>


</body>
</html>