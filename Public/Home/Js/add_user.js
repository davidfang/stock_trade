$(function(){
    var verify_phone = /^1[3|4|5|7|8]\d{9}$/;//验证手机
    var verify_email = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;//验证邮箱
    var verify_id = /^\d{17}([0-9]|X|x)$/;//验证身份证号
    var verify_bank_card = /^\d{16}|\d{19}$/;//验证银行卡号
    var post = true;
    $(".save_info").click(function(){
        post = true;
        try {
            var name = get_verify_data($("#name"),false,true,'姓名');
            var ID = get_verify_data($("#identity_card"),verify_id,true,'身份证号');
            var phone = get_verify_data($("#phone"),verify_phone,true,'手机号');
            var bank_card = get_verify_data($("#bank_card"),verify_bank_card,false,'银行卡号');
            var bank_address = get_verify_data($("#bank_address"),false,false,'开户行及网点');
            var email = get_verify_data($("#email"),verify_email,false,'邮箱');
            var address = get_verify_data($("#address"),false,false,'地址');
            var stock = get_verify_data($("#stock"),false,false,'股票账号');
            var stock_psd = get_verify_data($("#stock_psd"),false,false,'股票密码');
        }catch(that){
            if(that){
                that.css('border', '1px solid red');
                that.focus();
            }
        }
        if((stock==''&&stock_psd!='')||(stock!=''&&stock_psd=='')){
            hint('success','提示','股票信息不完善！');
            return;
        }
        var to_url = $(this).attr('to-url');
        var user = $(this).attr('user');
        if(user == ''){
            var url = $(this).attr('url');
        }else{
            var url = $(this).attr('save_url');
        }
        var post_data={
            user:user,
            name:name,
            identity_card:ID,
            phone:phone,
            email:email,
            address:address,
            stock:stock,
            stock_psd:stock_psd,
        }
        if(bank_card){
            post_data.bank_card=bank_card;
        }
        if(bank_address){
            post_data.bank_address=bank_address;
        }
        if(post){
            $.post(
                url,
                post_data,
                function(data){
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
        if(!that.length>0){
            return false;
        }
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
})