$(function(){
    $('.viewdetails').click(function(){
        $(this).addClass('d-none');
        var x = $(this).parent().parent().parent().next();
        x.removeClass('d-none');
    })
    $('.close-details').click(function(){
        var y= $(this).parent().parent();
        y.addClass('d-none');
         var detail=y.prev().children().next().next().children().next()
         .children().next().removeClass('d-none');
        console.log(detail);
    })
})