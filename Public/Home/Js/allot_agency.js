$(function(){
    var user;//操作对象
    $(".allot_agency").click(function(){
        user = $(this).attr('user');
        $('.allot_modal').modal({show:true});
    })

    $(".affirm_save").click(function(){
        var grade_id = $("#there").val();
        if(grade_id==-1){
            hint('warning','提示','请选择上级代理！');
            return;
        }
        var url = $(this).attr('url');
        $(".modal_close").click();
        $.post(
            url,
            {
                user:user,
                superior:grade_id
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

    $("#one,#two").change(function(){
        var object = $(this).attr('data');
        var user = $(this).val();
        if(user==-1){
            return;
        }
        $.post(
            $("#get_son_grade").attr('url'),
            {
                user:user
            },function(data){
                if(object=='one'){
                    $("#two").find("option[value!='-1']").remove();
                    $("#there").find("option[value!='-1']").remove();
                    var edit_obj = 'two';
                }else{
                    $("#there").find("option[value!='-1']").remove();
                    var edit_obj = 'there';
                }
                if(data['code']==0){
                    for(var item in data.data){
                        $("#"+edit_obj).append("<option value='"+data.data[item]['id']+"'>"+data.data[item]['name']+"</option>");
                    }
                }
            }
        )
    })

})
