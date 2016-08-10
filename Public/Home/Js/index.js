$(function(){
    var width = $("#carousel_img").width();
    var height = $("#carousel_img").height();
    var that = $("#planetmap").find('area');
    //var count_area = that.length;
    var max_row = 4;
    var max_line = 12;
    var row_spacing = height/max_row;
    var line_spacing = width/max_line;
    for(var i = 0;i < max_row;i++){
        for(var j = 0;j < max_line;j++){
            var row1 = i*row_spacing;
            var line1 = j*line_spacing;
            var row2 = (i+1)*row_spacing;
            if(i==max_row-1&&j==9){
                var line2 = (j+3)*line_spacing;
            }else{
                var line2 = (j+1)*line_spacing;
            }
            that.eq(i*max_line+j).attr('coords','"'+line1+','+row1+','+line2+','+row2+'"');
            if(i==max_row-1&&j==9){
                break;
            }
        }
    }
})