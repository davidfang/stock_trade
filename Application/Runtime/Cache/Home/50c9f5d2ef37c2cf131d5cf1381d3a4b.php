<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<!--Head-->
<head>
    <meta charset="utf-8" />
    <title>股票管理系统-登录页</title>

    <meta name="description" content="login page" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <!--Basic Styles-->
    <link href="/stock_trade/Public/assets/css/bootstrap.min.css" rel="stylesheet" />

    <!--Beyond styles-->
    <link id="beyond-link" href="/stock_trade/Public/assets/css/beyond.min.css" rel="stylesheet" />
    <link href="/stock_trade/Public/assets/css/animate.min.css" rel="stylesheet" />
    <link id="skin-link" href="" rel="stylesheet" type="text/css" />

    <link href="/stock_trade/Public/Home/Css/login.css" rel="stylesheet" />
</head>
<!--Head Ends-->
<!--Body-->
<body>
<div class="login-container animated fadeInDown">
    <div class="loginbox bg-white">
        <div class="loginbox-title">股票管理系统</div>
        <div class="loginbox-social"></div>
        <div class="loginbox-or">
            <div class="or-line"></div>
            <div class="or">登录</div>
        </div>
        <div class="loginbox-warning">
            <p id="warning-msg"></p>
        </div>
        <div class="loginbox-textbox">
            <input type="text" class="form-control" id="account" placeholder="账号" />
        </div>
        <div class="loginbox-textbox">
            <input type="password" class="form-control" id="passwd" placeholder="密码" />
        </div>
        <div class="loginbox-textbox">
            <input type="text" class="form-control" id="verify" placeholder="验证码" />
        </div>
        <div class="loginbox-textbox">
            <img class="verifyimg reloadverify" alt="点击切换" src="<?php echo U('Login/verify');?>" onClick="this.src=this.src+'?'+Math.random()">
        </div>

        <div class="loginbox-submit">
            <input type="button" class="btn btn-primary btn-block" id="submit-btn" value="登录">
        </div>
        <div class="loginbox-forgot">
            <a href="<?php echo U('Login/register');?>">注册>></a>
        </div>
    </div>
</div>

<input type="hidden" id="login-url" value="<?php echo U('login_verify');?>">
<input type="hidden" id="index-url" value="<?php echo U('Index/index');?>">

<!--Basic Scripts-->
<script src="/stock_trade/Public/assets/js/jquery-2.0.3.min.js"></script>
<script src="/stock_trade/Public/assets/js/bootstrap.min.js"></script>
<script src="/stock_trade/Public/assets/js/bootbox/bootbox.js"></script>
<script src="/stock_trade/Public/Staick/md5.js"></script>
<!--Extend Scripts-->
<script src="/stock_trade/Public/Home/Js/login.js"></script>
<script>

</script>
</body>
<!--Body Ends-->
</html>