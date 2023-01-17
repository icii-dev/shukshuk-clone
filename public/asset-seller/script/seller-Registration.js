$(function(){   
  $(document).ready(function() {
   $('#form-step-1').validate({
    rules: {
       firstname: "required",
        lastname: "required",
        email: "required",
        phone: "required",
        contry: "required",
        contry_1: "required",
        contry_2: "required",
    },
     messages: {
        firstname: "Cannot be empty",
        lastname: "Cannot be empty",
        email: "Cannot be empty",
        phone: "Cannot be empty",
        contry: "Cannot be empty",
        contry_1: "Cannot be empty",
        contry_2: "Cannot be empty",
    }
   });
    $('#form-step-2').validate({
    rules: {
       storename: "required",
        address: "required",
    },
     messages: {
        storename: "Cannot be empty",
        address: "Cannot be empty",
    }
   });
  });
   $('#btn-step1').click(function() {
        $("#form-step-1").valid(); //validate form 1
    });
   $('#btn-step2').click(function() {
        $("#form-step-2").valid(); //validate form 2
    });
   $('#btn-step1,#li-step-2 a').click(function(e) {
        if($("#form-step-1").valid()){
            $('.wrap-flag button').css("border","1px solid #ced4da");
            $('#item-step-2').addClass('active');
             $('#review-step-2').addClass('active');
             $('#item-step-1,#item-step-3').removeClass('active');
             $('#tab-1,#tab-3').removeClass('active');
             $('#tab-2').addClass('active');
             $("#tab-2").attr("aria-expanded","true");
             $("#tab-1,#tab-3").attr("aria-expanded","flase");                
             $('#review-step-1').removeClass('active');

        }
        else{
            $('.wrap-flag button').css("border","1px solid #EB4242");
            e.preventDefault();
            e.stopPropagation();        
        }        
    });
   $('#btn-step2,#li-step-3 a').click(function(e) {
        if($("#form-step-2").valid()){
            $('#item-step-3').addClass('active');
            $('#item-step-1,#item-step-2').removeClass('active');
            $('#tab-1,#tab-2').removeClass('active');
            $('#tab-3').addClass('active');
            $("#tab-3").attr("aria-expanded","true");
            $("#tab-1,#tab-2").attr("aria-expanded","flase");                
            $('#review-step-1').removeClass('active');
            $('#review-step-1').removeClass('active'); 
        }
        else{
            e.preventDefault();        
            e.stopPropagation();
        }        
    });

    // $('#btn-step1,#li-step-2 a').mouseover(function(){
    //     if($("#form-step-1").valid()){
    //         $("#btn-step1").attr("data-toggle", "tab");
    //         $("#li-step-2 a").attr("data-toggle", "tab");
    //         $('#btn-step1,#li-step-2,#review-step-2').click(function () {
    //             $('#item-step-2').addClass('active');
    //             $('#review-step-2').addClass('active');
    //             $('#item-step-1,#item-step-3').removeClass('active');
    //             $('#tab-1,#tab-3').removeClass('active');
    //             $('#tab-2').addClass('active');
    //             $("#tab-2").attr("aria-expanded","true");
    //             $("#tab-1,#tab-3").attr("aria-expanded","flase");                
    //             $('#review-step-1').removeClass('active');       
    //         });
    //     }
    // })
    //  $('#btn-step2,#li-step-3 a').mouseover(function(){
    //     if($("#form-step-2").valid()){
    //         $("#btn-step2").attr("data-toggle", "tab");
    //         $("#li-step-3 a").attr("data-toggle", "tab");
    //         $('#btn-step2,#li-step-3').click(function () {
    //             $('#item-step-3').addClass('active');
    //             $('#item-step-1,#item-step-2').removeClass('active');
    //             $('#tab-1,#tab-2').removeClass('active');
    //             $('#tab-3').addClass('active');
    //             $("#tab-3").attr("aria-expanded","true");
    //             $("#tab-1,#tab-2").attr("aria-expanded","flase");                
    //             $('#review-step-1').removeClass('active');
    //             $('#review-step-1').removeClass('active');       
    //         });
    //     }
    // })     
  // $(document).click( function ( e ){
  //       if($('#form-step-1 #firstname').hasClass('valid')&&$('#form-step-1 #lastname').hasClass('valid')
  //           &&$('#form-step-1 #email').hasClass('valid')&&$('#form-step-1 #phone').hasClass('valid')
  //           &&$('#form-step-1 #contry').hasClass('valid')){
  //               $('#btn-step1').mouseover(function(){
  //                   $("#btn-step1").attr("data-toggle", "tab");
  //                   $("#li-step-2 a").attr("data-toggle", "tab");
  //               })                
  //           $('#btn-step1,#li-step-2,#review-step-2').click(function () {
  //               $('#item-step-2').addClass('active');
  //               $('#review-step-2').addClass('active');
  //               $('#item-step-1,#item-step-3').removeClass('active');
  //               $('#tab-1,#tab-3').removeClass('active');
  //               $('#tab-2').addClass('active');
  //               $("#tab-2").attr("aria-expanded","true");
  //               $("#tab-1,#tab-3").attr("aria-expanded","flase");                
  //               $('#review-step-1').removeClass('active');       
  //           });  
  //       }
  //       if($('#form-step-2 #storename').hasClass('valid')&&$('#form-step-2 #address').hasClass('valid')){
  //           $("#btn-step2").attr("data-toggle", "tab");
  //           $("#li-step-3 a").attr("data-toggle", "tab");
  //           $('#btn-step2,#li-step-3').click(function () {
  //               $('#item-step-3').addClass('active');
  //               $('#item-step-1,#item-step-2').removeClass('active');
  //               $('#tab-1,#tab-2').removeClass('active');
  //               $('#tab-3').addClass('active');
  //               $("#tab-3").attr("aria-expanded","true");
  //               $("#tab-1,#tab-2").attr("aria-expanded","flase");                
  //               $('#review-step-1').removeClass('active');
  //               $('#review-step-1').removeClass('active');       
  //           });
  //       }   
  //   });
    $('#li-step-1,#review-step-1').click(function () {
      	$('#item-step-1').addClass('active');
        $('#review-step-1').addClass('active');
      	$('#item-step-3,#item-step-2').removeClass('active');
      	$('#tab-3,#tab-2').removeClass('active');
      	$('#tab-1').addClass('active');
      	$("#tab-1").attr("aria-expanded","true");
        $("#tab-2,#tab-3").attr("aria-expanded","flase");
        $('#review-step-1').removeClass('active');      	
    })
    $('#review-step-2').click(function () {
        $('#item-step-2').addClass('active');
        $('#review-step-2').addClass('active');
        $('#item-step-3,#item-step-1').removeClass('active');
        $('#tab-3,#tab-1').removeClass('active');
        $('#tab-2').addClass('active');
        $("#tab-2").attr("aria-expanded","true");
        $("#tab-1,#tab-3").attr("aria-expanded","flase");
        $('#review-step-1').removeClass('active');
        $('#review-step-2').removeClass('active');          
    })
})