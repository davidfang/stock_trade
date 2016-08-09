$(function(){
    var url = $("#del_agency").val();
    $("#grade_id option[value="+$("#grade_id").attr('data')+"]").attr("selected", true);
    $(".subordinate").click(function(){
        var user = $(this).attr('user');
        var grade = $(this).attr('grade');
        window.location.href = $("#seek").attr("url")
            +"?grade=" +grade
            +"&user="+user;
    })
    $("#seek").click(function(){
        var grade_id = $("#grade_id").val();
        var phone = $("#phone").val()?$("#phone").val():'all';
        var name = $("#name").val()?$("#name").val():'all';
        window.location.href = $("#seek").attr("url")
            +"?grade_id=" +grade_id
            +"&phone="+phone
            +"&name="+name;
    })
    $(".del_grade").click(function(){
        var grade = $(this).attr('user');
        bootbox.setDefaults("locale","zh_CN");
        bootbox.confirm("你确定要删除吗?", function (result) {
            if (!result) {
                return;
            } else {
                $.post(
                    url,
                    {
                        user: grade
                    },
                    function (data) {
                        if (data['code'] == 0) {
                            hint('success', data['msg'], data['data'], true);
                        } else if (data['code'] == 1) {
                            hint('warning', data['msg'], data['data']);
                        } else if (data['code'] == 2) {
                            hint('warning', data['msg'], data['data']);
                        }
                    }
                )
            }
        })
    })
})
