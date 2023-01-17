

$(document).ready(function()
{
    getReviews();
    $("#rateYo").rateYo({
        rating: 5,
        fullStar: true,
    });

    $('#click-Overview').click(function() {
        $('#Reviews').removeClass('active');
    })
    $('.img-review').click(function(){
        if ($('#demo-image').hasClass('w-50')) {
            $('#demo-image').removeClass('w-50')
        }
        else($('#demo-image').addClass('w-50'));
    });

    function getReviews(pageUrl = null) {
        if(!pageUrl){
            pageUrl = urlReviews;
        }
        $.ajax({
            type: 'GET',
            url: pageUrl,
            datatype: "html",
            success: function(data){
                $('#reviewsList').html(data);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                $.notify({
                    content :'No response from server', timeout: 2000
                });

            }
        });
    }
    $(document).on('click', '.pagination a',function(event)
    {
        event.preventDefault();

        $('li').removeClass('active');
        $(this).parent('li').addClass('active');

        var pageUrl = $(this).attr('href');
        // var page=$(this).attr('href').split('page=')[1];
        getReviews(pageUrl);
    });

});


function showImageReview(imageID) {
    if ($('#'+imageID).hasClass('w-50')) {
        $('#'+imageID).removeClass('w-50')
    }
    else($('#'+imageID).addClass('w-50'));
}

//
//submit review
function openfileDialog() {
    $("#reviewImages").click();
}
$('#reviewImages').change(function(){
    var input = this;
    var url = $(this).val();
    var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
    if (input.files && input.files[0]&& ( ext == "png" || ext == "jpeg" || ext == "jpg"))
    {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#showImageReview').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
    else
    {
        $.notify({
            content :'Please choose an image',
            alertType: "alert-warning",
            timeout: 5000
        });
    }
});
function submitRevew() {
    let orderId = $('input[name=orderId]').val();
    let comment = $('textarea[name=commentOfRating]').val();
    let rating = $("#rateYo").rateYo("rating");

    let fd = new FormData();
    let imageFile = $('#reviewImages')[0].files[0];
    fd.append('images',imageFile);
    fd.append('orderId', orderId);
    fd.append('comment', comment);
    fd.append('rating', rating);
    postRating(fd);
}

function postRating(data){
    // var data = {
    //     "productID": productID,
    //     "comment":comment,
    //     "rating":rating,
    //     "images": imageFile,
    // };
    return $.ajax({
        type: "POST",
        url: config.routes.reviews,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
        },
        // The key needs to match your method's input parameter (case-sensitive).
        data: data,
        contentType: false,
        processData: false,
        success: function(data){
            console.log(data);
            $('#btnReview').prop('disabled', true);
            if(data.message){
                $.notify({
                    content :data.message,
                    alertType: "alert-success",
                    timeout: 5000
                });
            }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            var error = JSON.parse(XMLHttpRequest.responseText);
            console.log(error);
            if(error.message){
                $.notify({
                    content :error.message,
                    alertType: "alert-warning",
                    timeout: 5000
                });
            }

        }
    });
}