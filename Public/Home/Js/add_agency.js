$(function(){
    var verify_phone = /^1[3|4|5|7|8]\d{9}$/;//验证手机
    var verify_email = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;//验证邮箱
    var verify_id = /^\d{17}([0-9]|X|x)$/;//验证身份证号
    var post = true;
    $(".save_info").click(function(){
        post = true;
        try {
            var name = get_verify_data($("#name"),false,true,'姓名');
            var ID = get_verify_data($("#identity_card"),verify_id,true,'身份证号');
            var phone = get_verify_data($("#phone"),verify_phone,true,'手机号');
            var email = get_verify_data($("#email"),verify_email,false,'邮箱');
            var address = get_verify_data($("#address"),false,false,'地址');
        }catch(that){
            if(that){
                that.css('border', '1px solid red');
                that.focus();
            }
        }
        if(type==3){
            var superior = $("#two").val();
            var grade_id = 3;
        }else if(type==2){
            var superior = $("#one").val();
            var grade_id = 2;
        }else{
            var superior = 0;
            var grade_id = 1;
        }
        if(superior==-1){
            hint('warning','提示','请选择上级代理！');
            return;
        }
        var to_url = $(this).attr('to-url');
        var user = $(this).attr('user');
        if(user == ''){
            var url = $(this).attr('url');
        }else{
            var url = $(this).attr('save_url');
        }
        if(post){
            $.post(
                url,
                {
                    user:user,
                    name:name,
                    identity_card:ID,
                    phone:phone,
                    email:email,
                    address:address,
                    superior:superior,
                    grade_id:grade_id,
                    type:1,
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
    $(".eye").click(function(){
        $("#stock_psd").attr('type','text');
    })
    $(".eye").mouseleave(function(){
        $("#stock_psd").attr('type','password');
    })
    $("#one").change(function(){
        var user = $(this).val();
        if(type!=3||user==-1){
            return;
        }
        $.post(
            $("#get_son_grade").attr('url'),
            {
                user:user
            },function(data){
                $("#two").find("option[value!='-1']").remove();
                if(data['code']==0){
                    for(var item in data.data){
                        $("#two").append("<option value='"+data.data[item]['id']+"'>"+data.data[item]['name']+"</option>");
                    }
                }
            }
        )
    })
})