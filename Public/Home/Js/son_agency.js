$(function(){
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
})
