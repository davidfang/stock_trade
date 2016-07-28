<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<!--Head-->
<head>
    <meta charset="utf-8" />
    <title>注册</title>

    <meta name="description" content="register page" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" href="/stock_trade/Public/assets/img/favicon.png" type="image/x-icon">

    <!--Basic Styles-->
    <link href="/stock_trade/Public/assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="/stock_trade/Public/assets/css/font-awesome.min.css" rel="stylesheet" />

    <!--Beyond styles-->
    <link id="beyond-link" href="/stock_trade/Public/assets/css/beyond.min.css" rel="stylesheet" />
    <link href="/stock_trade/Public/assets/css/demo.min.css" rel="stylesheet" />
    <link href="/stock_trade/Public/assets/css/animate.min.css" rel="stylesheet" />

    <style>
        #register{
            width: 100% !important;
            margin-top: 10px !important;
        }
        .login{
            display: inline-block;
            float: right;
            margin: 15px 40px;
        }
        #verify_text{
            width: 60%;
            display: inline-block;
        }
        #verify_button{
            float: right;
        }
    </style>

</head>
<!--Head Ends-->
<!--Body-->
<body>
<div class="register-container animated fadeInDown">
    <div class="registerbox bg-white" style="height: 650px!important;">
        <div class="registerbox-title">注册</div>

        <div class="registerbox-caption ">请填写您的资料信息</div>
        <div class="registerbox-textbox">
            <input type="tel" class="form-control" placeholder="手机号" id="phone" />
        </div>
        <div class="registerbox-textbox">
            <input type="password" class="form-control" placeholder="密码（6-16位）" id="password" />
        </div>
        <div class="registerbox-textbox">
            <input type="password" class="form-control" placeholder="确认密码" id="password_verify" />
        </div>
        <hr class="wide" />
        <div class="registerbox-textbox">
            <input type="text" class="form-control" placeholder="姓名" id="name" />
        </div>
        <div class="registerbox-textbox">
            <input type="text" class="form-control" placeholder="身份证号" id="ID" />
        </div>
        <div class="registerbox-textbox">
            <input type="email" class="form-control" placeholder="email" id="email" />
        </div>
        <div class="registerbox-textbox">
            <input type="text" class="form-control" placeholder="地址" id="address" />
        </div>
        <div class="registerbox-textbox">
            <input type="text" class="form-control" id="verify_text" placeholder="验证码" />
            <input type="button" class="btn btn-azure shiny" url="<?php echo U('Login/get_phone_verify');?>" id="verify_button" value="获取验证码" />
        </div>
        <div class="registerbox-submit">
            <input type="button" class="btn btn-primary pull-right" value="注册" url="<?php echo U('Login/register_verify');?>" id="register" />
        </div>
        <div class="loginbox-forgot login">
            <a href="<?php echo U('Login/login');?>">登陆>></a>
        </div>
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

<!--Basic Scripts-->
<script src="/stock_trade/Public/assets/js/jquery-2.0.3.min.js"></script>
<script src="/stock_trade/Public/assets/js/bootstrap.min.js"></script>

<!--Beyond Scripts-->
<script src="/stock_trade/Public/assets/js/beyond.min.js"></script>
<script src="/stock_trade/Public/Home/Js/register.js"></script>
<script src="/stock_trade/Public/Home/Js/hint.js"></script>
<script src="/stock_trade/Public/Staick/md5.js"></script>

</body>
<!--Body Ends-->
</html>