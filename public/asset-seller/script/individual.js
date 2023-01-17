$(function(){
	$(document).ready(function (){
	    $("#next_nav-Seller").on("click", function() {
	        var $left = $("#nav-seller").css('margin-left');
	        var $width  = $("#nav-seller .wrap-seller-info").css('width');
	        var $maxwidth = parseInt($width)*2+32
	        var $newval = (parseInt($left) - parseInt($width)-16);
	        if ($newval < -$maxwidth) {
	        $newval=0;
	        }
	        $newVal=$newval+"px";
	         $("#nav-seller").css ({
	        'margin-left' : $newval
	         });
	    });
	    $("#pre_nav-Seller").on("click", function() {
	        var $left   = $("#nav-seller").css('margin-left');
	        var $width  = $("#nav-seller .wrap-seller-info").css('width');
	         var $maxwidth = parseInt($width)*2+32
	        var $newval = (parseInt($left) + parseInt($width)+16);
	        if ($newval>0) {
	        $newval     =-$maxwidth;
	        }
	        $newVal     =$newval+"px";
	        $("#nav-seller").css ({
	        'margin-left' : $newval
	        });
	    });
	})
})
