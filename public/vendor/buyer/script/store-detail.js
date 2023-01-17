function myFunction() {
    var dots = document.getElementById("dots");
    var moreText = document.getElementById("more");
    var btnText = document.getElementById("myBtn");
    var showLess = document.getElementById("showLess");

    if (dots.style.display === "none") {
        dots.style.display = "inline";
        showLess.style.display = "inline";
        btnText.innerHTML = "Read more";
        moreText.style.display = "none";
    } else {
        dots.style.display = "none";
        showLess.style.display = "none";
        btnText.innerHTML = "Read less";
        moreText.style.display = "inline";
    }
}

var page = 2;
$('.load-more').click(function(e){
    e.preventDefault();
    loadMoreProducts();
});
function loadMoreProducts() {
    $.ajax(
        {
            url: '?page=' + page,
            type: "get",
            datatype: "html"
        }).done(function(data){
        page++;
        loadViewProduct(data);
        if(data.next_page_url == null){
            $('.load-more').hide();
        }
    }).fail(function(jqXHR, ajaxOptions, thrownError){
        alert('No response from server');
    });
}
// load product in id featureProductsRow
function loadViewProduct(data) {
    htmlCode="";
    $.each( data.data, function( key, value ) {
        value.store = {};
        value.store.slug = store_slug;
        value.store.name = store_name;
        htmlCode += printItemProductStore(value);
    });

    $('#productList').append(htmlCode);
}

function addWhishlistStore(img, idStore) {
    $.ajax({
        type: 'GET',
        url: config.routes.wishlistStore + idStore,
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
