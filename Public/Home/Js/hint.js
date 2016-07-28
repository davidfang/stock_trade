function hint(type,title,data,refresh){
    switch (type){
        case 'success':
            var that = $("#modal-success");
            alert_show(title,data,that,refresh);
            break;
        case 'danger':
            var that = $("#modal-danger");
            alert_show(title,data,that,refresh);
            break;
        case 'warning':
            var that = $("#modal-warning");
            alert_show(title,data,that,refresh);
            break;
        case 'info':
            var that = $("#modal-info");
            alert_show(title,data,that,refresh);
            break;
    }
}
function alert_show(title,data,that,refresh){
    if(that){
        that.find(".modal-title").text(title);
        that.find(".modal-body").text(data);
        that.modal({show:true});
        setTimeout(function(){
            that.find(".btn").click();
            if(refresh){
                location.reload();
            }
        },2000)
        that.find(".btn").click(function(){
            if(refresh){
                location.reload();
            }
        });
    }
}