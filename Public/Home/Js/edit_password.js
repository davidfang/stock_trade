$(function(){
    var post = true;
    $(".save_info").click(function(){
        post = true;
        var url = $(this).attr('url');
        var to_url = $(this).attr('to-url');
        try {
            var old_password = get_verify_data($("#old-password"),false,true,'旧密码');
            var new_password = get_verify_data($("#new-password"),false,true,'新密码');
            var verify_password = get_verify_data($("#verify-password"),false,true,'确认密码');
            if(old_password==new_password){
                hint('warning', '提示', '新旧密码不能相同！');
                return;
            }
            if(verify_password!=new_password){
                hint('warning', '提示', '前后密码不一致！');
                return;
            }
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
                    old_password:hex_md5(old_password),
                    new_password:hex_md5(new_password),
                    verify_password:hex_md5(verify_password),
                },function(data){
                    if(data['code']==0){
                        hint('success',data['msg'],data['data']);
                        setTimeout(function(){
                            window.location.href=to_url;
                        },2000)
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
        if(get_data.length<6){
            hint('warning','提示',info+'格式不正确！！！');
            post = false;
            throw that
        }else{
            that.css('border','1px solid #d5d5d5');
        }
        return get_data;
    }
})