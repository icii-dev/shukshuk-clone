$(function(){
	$(document).ready(function (){
           $("#next_nav").on("click", function() {
              var $left = $("#nav").css('margin-left');
              var $newval = (parseInt($left) - 263);
              if ($newval <= -526) {
                $newval=-526;
              }
              $newVal=$newval+"px";
              $("#nav").css ({
                'margin-left' : $newval
              });
           });
           $("#pre_nav").on("click", function() {
              var $left = $("#nav").css('margin-left');
              var $newval = (parseInt($left) + 263);
              if ($newval>0) {
                $newval=0;
              }
              $newVal=$newval+"px";
              $("#nav").css ({
                'margin-left' : $newval
              });
           });
       });
      $(document).ready(function (){
            $("#next_nav-1").on("click", function() {
                var $left = $("#nav-1").css('margin-left');
                var $newval = (parseInt($left) - 263);
                if ($newval <= -789) {
                $newval=-789;
                }
                $newVal=$newval+"px";
                 $("#nav-1").css ({
                'margin-left' : $newval
                 });
            });
            $("#pre_nav-1").on("click", function() {
                var $left   = $("#nav-1").css('margin-left');
                var $newval = (parseInt($left) + 263);
                if ($newval>0) {
                $newval     =0;
                }
                $newVal     =$newval+"px";
                $("#nav-1").css ({
                'margin-left' : $newval
                });
            });
        })
})