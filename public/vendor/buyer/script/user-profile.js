function openfileDialog() {
    $("#fileLoader").click();

}
$('#fileLoader').change(function(){
    var input = this;
    var url = $(this).val();
    var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
    if (input.files && input.files[0]&& ( ext == "png" || ext == "jpeg" || ext == "jpg"))
    {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#userAvatar').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
    else
    {
        $.notify({
            content :'Please choose an image',
            alertType: "alert-warning",
            timeout: 2000
        });
    }
});


   $('#datepicker').datepicker({
       uiLibrary: 'bootstrap4',
       format: 'dd-mm-yyyy',
       defaultDate: null
    });
  $('#order').click(function(){
          $('#track-oder').addClass('d-none');
          $('#check-circle').removeClass('d-none');
    })
    $('#edit-accout').click(function(){
          $('#page-accout').addClass('d-none');
          $('#tab-mobi').removeClass('d-sm-none');
          $('#header-1').addClass('d-none');
          $('#header-2').removeClass('d-none');
    })
    $('#back').click(function(){
          $('#page-accout').removeClass('d-none');
          $('#tab-mobi').addClass('d-sm-none');
          $('#header-1').removeClass('d-none');
          $('#header-2').addClass('d-none');
    })
    $('#back-to').click(function(){
        $('#my-oder').addClass('active');
        $('#my-oder-detail').removeClass('active');
        $('#view-detail').removeClass('active');
        $('#home').removeClass('active');
        $("#my-oder").attr("aria-expanded","true");
        $("#my-oder-detail").attr("aria-expanded","flase");
        $("#home").attr("aria-expanded","flase");
    })
    $('#view-detail').click(function(){
        $('#my-oder-detail').addClass('active');
        $('#my-oder-detail').removeClass('fade');
        $('#my-oder').removeClass('active');
        $('#view-detail').addClass('active');
        $('#home').removeClass('active');
        $("#my-oder-detail").attr("aria-expanded","true");
        $("#my-oder").attr("aria-expanded","flase");
        $("#home").attr("aria-expanded","flase");
    })
    $('#li-my-oder').on({
      'click': function() {
          $('#icon-order').attr('src','vendor/buyer/Img/order-black.svg');
          $('#my-oder').addClass('active');
          $('#my-oder-detail').removeClass('active');
          $('#view-detail').removeClass('active');
          $('#home').removeClass('active');
          $("#my-oder").attr("aria-expanded","true");
          $("#home").attr("aria-expanded","flase");
          $("#my-oder-detail").attr("aria-expanded","flase");
      }
  });
  $('#account-tab').on({
      'click': function() {
          $('#icon-order').attr('src','vendor/buyer/Img/order-gray.svg');
          $('#home').addClass('active');
          $('#my-oder-detail').removeClass('active');          
          $('#my-oder').removeClass('active');
          $('#view-detail').removeClass('active');
          $("#home").attr("aria-expanded","true");
          $("#my-oder").attr("aria-expanded","flase");
          $("#my-oder-detail").attr("aria-expanded","flase");

      }
  });

$(document).ready(function() {
    $('select').on('change', function (e) {
        var select = $(e.currentTarget);
        if(select.attr("name")=='province_id'){
            getCitiesOfProvince(select.val());
            //refresh district
            $('#districts').html('').selectpicker('refresh');
        }else if(select.attr("name")=='regency_id'){
            getDistrictOfCity(select.val());
        }

    });
});

