$(function(){
    var verify_phone = /^1[3|4|5|7|8]\d{9}$/;//验证手机
    var verify_email = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;//验证邮箱
    var verify_id = /^\d{17}([0-9]|X|x)$/;//验证身份证号
    //获取手机验证码
    $("#verify_button").click(function(){
        var url = $(this).attr('url');
        var phone = $.trim($("#phone").val());
        if(phone==''){
            hint('warning','提示','请输入手机号。');
            return;
        }
        $.post(
            url,
            {
              phone:phone,
            },
            function(data){
                if(data['code']==0){
                    $("#verify_button").attr('disabled',true);
                    $("#verify_button").removeClass('btn-azure');
                    $("#verify_button").addClass('btn-default');
                    var timer=60;
                    var get_verify_timer = setInterval(function(){
                        $("#verify_button").val(timer+'s 后重新获取');
                        timer--;
                        if(timer==-1){
                            clearInterval(get_verify_timer);
                            $("#verify_button").attr('disabled',false);
                            $("#verify_button").removeClass('btn-default');
                            $("#verify_button").addClass('btn-azure');
                            $("#verify_button").val('获取验证码');
                        }
                    },1000)
                }else{
                    hint('warning','提示','验证码获取失败！！！')
                }
            }
        )
    })
    var post = true;
    $("#register").click(function(){
        post = true;
        var url = $(this).attr('url');
        try {
            var phone = get_verify_data($("#phone"),verify_phone,true,'手机号');
            var password = get_verify_data($("#password"),false,true,'密码');
            var verify_password = get_verify_data($("#password_verify"),false,true,'确认密码');
            if(password.length<6||password.length>16){
                hint('warning', '提示','密码格式有误！！！');
                $("#password").focus();
                $("#password").css('border', '1px solid red');
                return;
            }
            if(password!=verify_password){
                hint('warning', '提示','密码不一致！！！');
                $("#password_verify").focus();
                $("#password_verify").css('border', '1px solid red');
                return;
            }
            var name = get_verify_data($("#name"),false,true,'姓名');
            var ID = get_verify_data($("#ID"),verify_id,true,'身份证号');
            var email = get_verify_data($("#email"),verify_email,true,'邮箱');
            var address = get_verify_data($("#address"),false,true,'地址');
            var verify_text = get_verify_data($("#verify_text"),false,true,'验证码');
        }catch(that){
            if(that){
                that.css('border', '1px solid red');
                that.focus();
            }
        }
        if(post){
            $.post(
                url,
                {
                    phone:phone,
                    name:name,
                    identity_card:ID,
                    email:email,
                    address:address,
                    password:hex_md5(password),
                    password:hex_md5(verify_password),
                    verify_text:verify_text,
                },function(data){
                    if(data['code']==0){
                        hint('success',data['msg'],data['data']);
                    }else if(data['code']==1){
                        hint('warning',data['msg'],data['data']);
                    }else if(data['code']==2){
                        hint('warning',data['msg'],data['data']);
                    }
                }
            )
        }
    })

    function get_verify_data(that,condition,must,info){
        var get_data = $.trim(that.val());
        if(must && get_data==''){
            hint('warning', '提示', info+'为必填项！！！');
            post = false;
            throw that
        }else{
            that.css('border','1px solid #d5d5d5');
        }
        if(condition && get_data!=''){
            var condition = new RegExp(condition);
            if(!condition.test(get_data)){
                hint('warning','提示',info+'信息填写有误！！！');
                post = false;
                throw that
            }else{
                that.css('border','1px solid #d5d5d5');
            }
        }
        return get_data;
    }
})