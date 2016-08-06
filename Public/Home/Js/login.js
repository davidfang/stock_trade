$(function(){
    $(document).on('keypress', function(e){
        if(e.keyCode == 13){
            $('#submit-btn').click();
        }
    });
    $('#submit-btn').on('click', function(){
        var data = filter();

        if(typeof data == 'string'){
            L_alert(data);
        }else{
            do_post(data);
        }
    })
})

function filter(){
    var ac = L_trim($('#account').val());
    var pw = L_trim($('#passwd').val());
    var vy = L_trim($('#verify').val());
    if(null == vy || '' == vy){
        return '请输入验证码';
    }else if(null == ac || '' == ac){
        return '用户名不能为空';
    }else if(null == pw || '' == pw){
        return '密码不能为空';
    }
    pw = hex_md5(pw);
    return {
        verify : vy,
        account : ac,
        password: pw
    }
}
function L_trim(str){
    return str.replace(/(^\s*)|(\s*$)/g, "");
}
function L_alert(msg){
    msg = msg ? msg : '未知错误';
    $('.loginbox-warning').show();
    $('#warning-msg').text(msg);
    shake('#warning-msg');
}
function do_post(data){
    $('#submit-btn').attr('disabled',true);
    $.post($('#login-url').val() ,data, function(data){
        //console.log(data.code);
        if(data.code != 0){
            L_alert(data.data);
            $(".reloadverify").click();
            $('#submit-btn').attr('disabled',false);
        }else{
            window.location.href = $('#index-url').val();
        }
    });
}
function shake(o){
    var $panel = $(o);
    var box_left = 0;
    for(var i=1; 4>=i; i++){
        $panel.animate({left:box_left-(40-10*i) + 'px'},50);
        $panel.animate({left:box_left+(40-10*i) + 'px'},50);
    }
}
