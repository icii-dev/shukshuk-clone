$(function(){
	$('.on-off').click(function(){
		if ($('.on-off').hasClass("on-show"))
			{$('.on-off').removeClass('on-show');}
 		else{
 			$('.on-off').addClass('on-show');
 		}
 		if($('.wrap-parameter').hasClass('d-none')){$('.wrap-parameter').removeClass('d-none')}
 		else{$('.wrap-parameter').addClass('d-none')}
    });

});