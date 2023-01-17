function addWhishlist(img, idProduct) {
    $.ajax({
        type: 'GET',
        url: config.routes.wishlist + idProduct,
        async: true,
        dataType: 'json',
        success: function(data){
            var $parent = $(img).parent();
            countWishlist = parseInt($parent.find('h3').html());
            if(data.isAdd){
                countWishlist ++;
                $('#wishlist').html(parseInt($('#wishlist').html())+1);
                img.src = config.routes.url + "vendor/buyer/Img/wishlist-checked.svg";
            }else {
                countWishlist --;
                $('#wishlist').html(parseInt($('#wishlist').html())-1);
                img.src = config.routes.url + "vendor/buyer/Img/heart-2.svg";
            }
            $parent.find('h3').html(countWishlist);
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            var error = JSON.parse(XMLHttpRequest.responseText);
            error.errors.forEach(function (status) {
                $.notify({
                    content :status,
                    alertType: "alert-warning",
                    timeout: 8000
                });
            });
        }
    });
}