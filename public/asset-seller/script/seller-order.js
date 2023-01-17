$(function(){
	$('.li-tab').click(function () {
		$('.li-tab').removeClass('active');
		$(this).addClass('active');

    })
    $('#check-2').click(function () {
		if ($('#input-1').is(":checked")) {
			$('#input-1').removeAttr("checked");
		}
    })
    
})