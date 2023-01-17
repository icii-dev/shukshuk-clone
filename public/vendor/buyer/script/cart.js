$(document).ready(function () {
//cart event
$("#mainCart, #mainCartMobile").on("click",".button-1", function() {
    var $button = $(this);
    var $parent = $button.parent();
    var oldValue = $parent.find('input[name=qty]').val();
    var rowId = $parent.find('input[name=rowId]').val();
    var newVal = parseFloat(oldValue) - 1;

    if(newVal<=0){
        removeItem(rowId);
    }else{
        $parent.find('input[name=qty]').val(newVal);
        updateQtyCart(rowId, newVal);
    }

});


$("#mainCart, #mainCartMobile").on("click",".button-2", function() {
    var $button = $(this);
    var $parent = $button.parent();
    var oldValue = $parent.find('input[name=qty]').val();
    var rowId = $parent.find('input[name=rowId]').val();
    var newVal = parseFloat(oldValue) + 1;
    // $parent.find('input[name=qty]').val(newVal);
    let callBack = updateQtyCart(rowId, newVal);
    if(callBack.status==200){
        $parent.find('input[name=qty]').val(newVal);
    };
});

// add to cart by input enter
    $("#mainCart, #mainCartMobile").on("keypress","input[name=qty]", function(e) {
        if ( e.keyCode == 13 ) {
            e.preventDefault();
            var rowId = $(this).parent().find('input[name=rowId]').val();
            var qty = $(this).val();
            updateQtyCart(rowId, qty);
        }
    });

});

function updateQtyCart(rowId, qty) {
    var data = { "rowId": rowId, "qty":qty};
    return $.ajax({
        type: "POST",
        url: config.routes.url + "api/cart/update",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
        },
        // The key needs to match your method's input parameter (case-sensitive).
        data: JSON.stringify({ data: data }),
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function(data){
            updateCartStatus(data);
            updateMobileCartStatus(data);
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            var error = JSON.parse(XMLHttpRequest.responseText);
            error.errors.forEach(function (status) {
                $.notify({
                    content :status,
                    alertType: "alert-warning",
                    timeout: 2000
                });
            });

        }
    });
}

function removeItem(rowId) {
    var data = { "rowId": rowId};
    return $.ajax({
        type: "POST",
        url: config.routes.url + "api/cart/remove",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
        },
        // The key needs to match your method's input parameter (case-sensitive).
        data: JSON.stringify({ data: data }),
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function(data){
            updateCartStatus(data);
            updateMobileCartStatus(data);
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            var error = JSON.parse(XMLHttpRequest.responseText);
            $.notify({
                content :error.status, timeout: 2000
            });

        }
    });
}

//don't disable cart when click
$(document).on('click', '#mainCart', function (e) {
    e.stopPropagation();
});