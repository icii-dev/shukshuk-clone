$(document).ready(function() {
    $('.selectpicker').selectpicker({
        size: '10'
    });
    var formSt1 = $("#form-step1");
    formSt1.validate({
        errorPlacement: function($error, $element) {
            if($element.is('select')){
                // console.log($element);
                $error.appendTo($element.closest(".wrap-select"));
                $element.closest(".wrap-select").addClass('error');
            }else {
                // the default error placement for the rest
                $error.insertAfter($element);

            }
        },
        success: function(element) {
            element.closest('.wrap-select').removeClass('error');
        },
            rules: {
                recipient_name: "required",
                phone: {
                    required: true,
                    minlength: 5
                },
                address: {
                    required: true,
                    minlength: 2
                },
                province:"required",
                city:"required",
                district:"required",
                delivery:"required",
            },
            messages: {                        
                name: "Full name cannot be empty",
                phone:"Phone Number must be longer than 5 characters",
                address: {
                    required: "Address cannot be empty",
                    minlength: "Address must be longer than 2 characters"
                },
                phone: {
                    required: "Number Phone cannot be empty ",
                    minlength: "Phone Number must be longer than 5 characters"
                },
                province:"Country cannot be empty",
                district:"Country cannot be empty",
                delivery:"Delivery cannot be empty",
            }
        });
        $("#show-credit-card").validate({
            rules: {
                name: "required",
                visa: "required",
                
            },
            messages: {                        
                name: "Name cannot be empty",
                visa: "Cannot be empty"
            }
        });
    $('select').on('change', function (e) {
        var select = $(e.currentTarget);

        if(select.hasClass('error')){
            formSt1.valid();
        }
        if(select.attr("name")=='province'){
            getCitiesOfProvince(select.val());
            //refresh district
            $('#districts').html('').selectpicker('refresh');
        }else if(select.attr("name")=='city'){
            getDistrictOfCity(select.val());
        }



    });
    $('#item-step-2, #btn-step1, #btn-step1-mobi').click(function () {

        if(!formSt1.valid()){
            console.log("error");
            setTimeout(function(){
                // activaTab('#step1');
                // $('#step3,#step2').removeClass('active');
                $("#item-step-2 a,#btn-step1,#btn-step1-mobi").removeAttr("data-toggle", "tab");
                $('#item-step-2').removeClass('step-active');
                $('#item-step-1').addClass('step-active');
            }, 200);

        }else {

            $('#btn-step1, #btn-step1-mobi').removeClass('active');
            $('#item-step-2').addClass('step-active');
            $('#item-step-1,#item-step-3').removeClass('step-active');
            $("#item-step-2 a, #btn-step1,#btn-step1-mobi").attr("data-toggle", "tab");
            activaTab('#step2');

        }
    });

    $('#item-step-1, #change-address').click(function () {
        $('#item-step-1').addClass('step-active');
        $('#step2,#step3').removeClass('active');
        $('#item-step-2,#item-step-3').removeClass('step-active');
        activaTab('#step1');
    });

    $('#btn-step2, #paynow-mobile').click(function () {
        $(this).addClass('btn-disabled');
        uploadCheckoutForm()
            .success(function (data) {
                $.notify({
                    content :'Order Success!',
                    alertType: "alert-success",
                    timeout: 5000,
                });
            });
    });

    function uploadCheckoutForm() {
        var input = {};
        $("form#form-step1 :input").each(function() {
            if($(this).is(':checkbox')){
                input[$(this).attr("name")] = ($(this).is(':checked'))?'1':'0';
            }else {
                input[$(this).attr("name")] = $(this).val();
            }
        });

        return $.ajax({
            type: "POST",
            url: config.routes.checkout,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
            },
            // The key needs to match your method's input parameter (case-sensitive).
            data: JSON.stringify(input),
            contentType: "application/json; charset=utf-8",
            success: function(data){
                window.location.href = data.invoice_url;
                // createInfoBill(data);
                // updateCartStatus([]);
                // updateMobileCartStatus([]);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                $.notify({
                    content :errorThrown,
                    alertType: "alert-warning",
                    timeout: 6000,
                });
                var error = JSON.parse(XMLHttpRequest.responseText);
                $.each(error.errors, function (key ,value) {
                    $.notify({
                        content :value,
                        alertType: "alert-warning",
                        timeout: 8000,
                    });
                });
                if(error.hasOwnProperty('reload')){
                    setTimeout(function(){location.reload();}, 2000);
                }

            }
        });
    }

    function createInfoBill(data) {
        $('#step3').html(data);
        $('#item-step-3').addClass('step-active');
        $('#item-step-2').removeClass('step-active');
        activaTab('#step3');
    }

    function activaTab(tab){

        if(tab=='#step2'){
            $('#step1,#step3').removeClass('active');
            $('#checkName').html('<h2>'+$('[name="recipient_name"]', formSt1).val()+'</h2>\n' +
                '                                    <p>+'+$('[name="phone"]', formSt1).val()+'</p>');
            $('#checkAddress').html($('[name="address"]', formSt1).val().replace(/\n/g,"<br>")
                +'<br>'+$('[name="district"]', formSt1).find("option:selected").text()
                +', ' + $('[name="city"]', formSt1).find("option:selected").text()
                +', ' + $('[name="province"]', formSt1).find("option:selected").text()
            );
        }
        $('a[href="'+tab+'"]').tab('show');
        $(tab).tab('show');
    };
    

    $('#credit-card').click(function(){
        if ($('#credit-card button').attr("title")=="Credit Cards")
          {$('#show-credit-card').removeClass('d-none');
           $('#show-btn-payment').removeClass('d-none');
           $('#continue-disabled').addClass('d-none');
           $('#continue-disabled-mobi').addClass('d-none')}
        else{
          $('#show-credit-card').addClass('d-none');
          $('#continue-disabled').removeClass('d-none');
          $('#continue-disabled-mobi').removeClass('d-none');
          $('#show-btn-payment').addClass('d-none')
        }
    });

    //********************
    //cart event

    $("#checkoutCart").on("click",".button-1", function() {
        var $button = $(this);
        var $parent = $button.parent();
        var oldValue = $parent.find('input[name=qty]').val();
        var rowId = $parent.find('input[name=rowId]').val();
        var newVal = parseFloat(oldValue) - 1;
        var data;
        if(newVal<=0){
            data = removeItem(rowId);
        }else{
            $parent.find('input[name=qty]').val(newVal);
            data = updateQtyCart(rowId, newVal);

        }

        data.success(function (data) {
            updateCartCheckout(data);
        });

    });


    $("#checkoutCart").on("click",".button-2", function() {
        var $button = $(this);
        var $parent = $button.parent();
        var oldValue = $parent.find('input[name=qty]').val();
        var rowId = $parent.find('input[name=rowId]').val();
        var newVal = parseFloat(oldValue) + 1;
        $parent.find('input[name=qty]').val(newVal);

        var data = updateQtyCart(rowId, newVal);
        data.success(function (data) {
            updateCartCheckout(data);
        });
    });

// add to cart by input enter
    $("#checkoutCart").on("keypress","input[name=qty]", function(e) {
        if ( e.keyCode == 13 ) {
            e.preventDefault();
            var rowId = $(this).parent().find('input[name=rowId]').val();
            var qty = $(this).val();
            var data = updateQtyCart(rowId, qty);
            data.success(function (data) {
                updateCartCheckout(data);
            });
        }
    });

    function updateCartCheckout(data) {
        var htmlCode = "";
        var htmlCodeTab2 = "";
        var total = 0;
        $.each( data, function( key, value ) {
            htmlCode += '<div class="product d-flex justify-content-between">\n' +
                '                                                <div class="left d-flex">\n' +
                '                                                    <img class="img-your-cart" src="'+config.routes.url+value.options.thumbnail+'" alt="">\n' +
                '                                                    <div class="detail-product-yourcart">\n' +
                '                                                        <a href="'+config.routes.productDetail+value.options.slug+'" class="name-product">'+value.name+'</a>\n' +
                '                                                        <div class="col-lg-8 col-md-12 wrap-amount">\n' +
                '                                                            <div class="d-flex amount-main amount-details">\n' +
                '                                                                <div class="button-1 col main-reduction"><img src="'+config.routes.url+'vendor/buyer/Img/reduction.svg" alt=""></div>\n' +
                '                                                                <input name="rowId" type="hidden" value="'+value.rowId+'">\n' +
                '                                                                <input name="qty" type="text" class="input number numbar-main" value="'+value.qty+'">\n' +
                '                                                                <div class="col button-2 main-add"><img src="'+config.routes.url+'vendor/buyer/Img/add.svg" alt=""></div>\n' +
                '                                                            </div>\n' +
                '                                                        </div>\n' +
                '                                                        <div class="checkout-product-option">\n';
            var i = 0;
                $.each( value.options.options, function( key, value ) {
                    htmlCode += '                                                            <span ';
                    htmlCode += (i>0)?'class="ml-3"':'';
                    htmlCode += '>Size: XL</span>\n';
                    i++;
                });
            htmlCode +=    '                                                        </div>\n' +
                '                                                    </div>\n' +
                '                                                </div>\n' +
                '                                                <div class="rigfht-sale">\n';
            htmlCode += (value.options.discount>0)?'<p class="text-sale text-right">'+moneyFormat(value.options.oldPrice)+'</p>':'';
            htmlCode += '                                                    <h3 class="text-right">'+moneyFormat(value.price)+'</h3>\n';
            htmlCode += (value.options.discount>0)?'<p class="sale-off text-center">'+value.options.discount+'% off</p>':'';
            htmlCode += '                                                </div>\n' +
                '                                            </div>';
            htmlCodeTab2 += '<div class="product d-flex justify-content-between">\n' +
                '                                                <div class="col-md-9 left d-flex">\n' +
                '                                                    <img class="img-your-cart" src="'+config.routes.url+value.options.thumbnail+'" alt="">\n' +
                '                                                    <div class="detail-product-yourcart">\n' +
                '                                                        <span class="name-product truncate-overflow-one">'+value.name+'</span>\n' +
                '                                                        <p class="qty mt-4">Qty: '+value.qty+'</p>\n' +
                '                                                        <div class="d-flex text mt-4 option">\n';
            i = 0;
            $.each( value.options.options, function( key, value ) {
                htmlCodeTab2 += '                                                            <p ';
                htmlCodeTab2 += (i>0)?'class="ml-3"':'';
                htmlCodeTab2 += '>'+key+': '+value+'</p>\n';
                i++;
            });
            htmlCodeTab2 += '                                                        </div>\n' +
                '                                                    </div>\n' +
                '                                                </div>\n' +
                '                                                <div class="col-md-3 rigfht-sale">\n' +
                '                                                    <h3 class="text-right">'+moneyFormat(value.price*value.qty)+'</h3>\n' +
                '                                                </div>\n' +
                '                                            </div>';
            total += value.price*value.qty;
        });
        $('#checkoutCart').html(htmlCode);
        $('#checkoutCartTotal').html(moneyFormat(total));

        $('#contentCartTab2').html(htmlCodeTab2);
        $('#checkoutCartTotalTab2').html(moneyFormat(total));
    }
});


