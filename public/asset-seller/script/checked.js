$(function(){
	$('#check-1').click(function () {
		if ($('#input-2').is(":checked")) {
			 $('#input-2').removeAttr("checked");
		}
    })
    $('#check-2').click(function () {
		if ($('#input-1').is(":checked")) {
			$('#input-1').removeAttr("checked");
		}
    })
})