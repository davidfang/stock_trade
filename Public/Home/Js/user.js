$(function(){
    var user;//操作对象
    $(".reset_password").click(function(){
        user = $(this).attr('user');
        $('.save_password').modal({show:true});
    })

    //取消清空输入框
    $(".modal_close").click(function(){
        $("#password").val(null);
        $("#verify_password").val(null);
    })

    $(".affirm_save").click(function(){
        var password = $.trim($("#password").val());
        var verify_password = $.trim($("#verify_password").val());
        if(password.length<6||password.length>16){
            hint('warning','提示','密码格式不正确！！！');
            return;
        }
        if(verify_password.length<6||verify_password.length>16){
            hint('warning','提示','密码格式不正确！！！');
            return;
        }
        if(password!=verify_password){
            hint('warning','提示','前后密码不一致！！！');
            return;
        }
        var url = $(this).attr('url');
        $(".modal_close").click();
        $.post(
            url,
            {
                user:user,
                password:hex_md5(password),
                verify_password:hex_md5(verify_password),
            },
            function(data){
                if(data['code']==0){
                    hint('success',data['msg'],data['data']);
                }else if(data['code']==1){
                    hint('warning',data['msg'],data['data']);
                }else if(data['code']==2){
                    hint('warning',data['msg'],data['data']);
                }
            }
        )
    })
    $("#seek").click(function(){
        var url = $(this).attr('url');
        var phone = $("#phone").val();
        var name = $("#name").val();
        if(phone==''){
            phone='all';
        }
        if(name==''){
            name='all';
        }
        window.location.href=url+"?phone="+phone+"&name="+name;
    })

    //删除代理
    /*$(".del").click(function(){
        var user = $(this).attr('user');
        var url = $("#del_agency").attr("url");
        bootbox.setDefaults("locale","zh_CN");
        bootbox.confirm("你确定要删除吗?", function (result) {
            if (!result) {
                return;
            }else{
                $.post(
                    url,
                    {
                        user:user
                    },
                    function(data){
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
    })*/

})
