<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
{!! SEO::generate() !!}

<!-- Bootstrap CSS -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
{{--    <link rel="stylesheet" href="{{asset('css/reset.css')}}">--}}

    <link rel="stylesheet" href="{{ mix("/css/all.css") }}">

    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <script type="text/javascript" src="{{ asset("vendor/buyer/script/jquery-1.9.1.min.js") }}"></script>
    <script type="text/javascript" src="{{ asset("vendor/buyer/script/jquery.notify.js") }}"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="locale" content="{{ App::getLocale() }}"/>
    {{--    to update HTTPS Ajax Request--}}
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
@yield('extra-header')
@stack('stylesheets')
<!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-160361825-1"></script>
    <style type="text/css">
        .loading-container {
            background: rgba(255, 255, 255, 0.8);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 99999;
            height: 100%;
            width: 100%;
            overflow: hidden;
        }

        .loader,
        .loader:after {
            border-radius: 50%;
            width: 10em;
            height: 10em;
        }
        .loader {
            margin-top: -42px;
            margin-left: -42px;
            font-size: 10px;
            position: absolute;
            left: 50%;
            top: 50%;
            text-indent: -9999em;
            border-top: 0.8em solid rgba(65, 62, 193, 0.2);
            border-right: 0.8em solid rgba(65, 62, 193, 0.2);
            border-bottom: 0.8em solid rgba(65, 62, 193, 0.2);
            border-left: 0.8em solid rgba(65, 62, 193, 1);
            -webkit-transform: translateZ(0);
            -ms-transform: translateZ(0);
            transform: translateZ(0);
            -webkit-animation: load8 1.1s infinite linear;
            animation: load8 1.1s infinite linear;
        }
        @-webkit-keyframes load8 {
            0% {
                -webkit-transform: rotate(0deg);
                transform: rotate(0deg);
            }
            100% {
                -webkit-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }
        @keyframes load8 {
            0% {
                -webkit-transform: rotate(0deg);
                transform: rotate(0deg);
            }
            100% {
                -webkit-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

    </style>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-160361825-1');
    </script>

</head>
<body id="@yield('page-id')" class="@yield('body-class')">
<div class="loading-container" style="display: none;">
    <div class="loader">Loading...</div>
</div>
<div id="app">
    <div id="loader-spinner" style="display: none;">
        <div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
    </div>

    @include('buyer.partials.header')

    @yield('content')

    @include('buyer.partials.footer')

    @if (auth()->user())
        <count-unread user-id="{{auth()->user() ? auth()->user()->id : 0}}"></count-unread>
    @endif
</div>

@include('buyer.partials.auth.modal')

<script src="{{ mix('js/app.js') }}"></script>

<!-- Optional JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

<script type="text/javascript" src="{{ asset("vendor/buyer/script/kit.fontawesome.js") }}"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js" type="text/javascript"></script>
<script type="text/javascript" src="{{ asset("vendor/buyer/script/menu.js") }}"></script>
<script type="text/javascript" src="{{ asset("vendor/buyer/script/cart.js") }}"></script>
<script type="text/javascript" src="{{ asset("vendor/buyer/script/search-bar.js") }}"></script>
<script>
    // global app configuration object
    var config = {
        routes: {
            url: "{{url('')}}" + "/",
            productDetail: "{{ route('product.show', '') }}" + "/",
            store: "{{ route('store.index','') }}" + "/",
            wishlist: "{{ route('wishlist.add','') }}"  + "/",
            wishlistStore: "{{ route('wishlistStore.add','') }}"  + "/",
            checkout: "{{ route('checkout.store') }}",
            checkoutPage: "{{ route('checkout.index', '') }}",
            cities: "{{ route('address.cities', '') }}" +"/",
            districts: "{{ route('address.districts', '') }}" +"/",
            quickSearch: "{{ route('search.quick') }}" +"/",
            reviews: "{{ route('users.reviews') }}",
        },
        alert: {
            cart: {
                success: "Update cart successfully",
            }
        },
        img: {
            wishlist: "{{ asset("vendor/buyer/Img/heart-2.svg") }}",
            star: "{{ asset("vendor/buyer/Img/start.svg") }}",
        }
    };

    const Loader = {
      show() {
        $('#loader-spinner').show(100);
      },
      hide() {
        $('#loader-spinner').hide(100);
      }
    }
</script>
<script type="text/javascript">
    function updateCartStatus(data) {

        var code = "";
        var total = 0;
        var i =0;
        $.each( data, function( key, value ) {
            var variants = "";
            $.each(value.options.options, function (name, value){
                variants += name + ": " + value + ", ";
            });
            i++;
            code +=                 "                <span class=\"cart-count-item\">"+i+"</span>\n" +
                "<div class   =\"cart-item dis\">\n" +
                "            <div class=\"cart-name-product truncate-overflow-one\">\n" +
                "                <a href=\""+config.routes.productDetail+value.options.slug+"\"><span class=\"cart-name\">"+value.name+"</span></a>\n" +
                "            </div>\n" +
                "            <div class=\"d-flex amount-main\">\n" +
                "                <div class  =\"button-1 col main-reduction\"><img src=\""+config.routes.url+"vendor/buyer/Img/reduction.svg\" alt=\"\"></div>\n" +
                "                               <input name=\"rowId\" type=\"hidden\" value=\""+key+"\">"+
                "                <input name=\"qty\" type =\"text\" class=\"input number numbar-main\" value=\""+value.qty+"\">\n" +
                "                <div class  =\"col button-2 main-add\"><img src=\""+config.routes.url+"vendor/buyer/Img/add.svg\" alt=\"\"></div>\n" +
                "            </div>\n" +
                "           <div class=\"row no-gutters\"><div class=\"col-12\">"+
                variants+
                "           </div></div>"      +
                "           <div class=\"row no-gutters\">"+
                "               <div class=\"col-6\">";
            code += (value.options.discount>0)?"<p class=\"price old-price\">"+value.options.formatted_price+"</p>":"";
            code += "               <p class=\"price\">"+value.options.formatted_present_price+"</p>\n" +
                "               </div>";
            code += (value.options.discount>0)?"<div class=\"col-6 d-flex justify-content-end\">\n" +
                "                    <div class=\"sale-off text-center truncate-overflow-one\"><span style=\"font-size: 12px\">"+value.options.formatted_discount_amount+"</span></div>\n" +
                "                </div>":"";
            code += "           </div>";
            code += (i!=Object.keys(data).length)?"            <div class =\"dropdown-divider\"></div>\n":"";
            code += "        </div>";
            total += parseInt(value.subtotal);
        });


        var length = Object.keys(data).length;
        if(length == 0){
            $('.total-product').addClass('d-none');
            $('.detail-cart').addClass('d-none');
            $('#emptyCart').removeClass('d-none');
        }
        else{
            $.notify({
                content :config.alert.cart.success,
                alertType: "alert-success",
                timeout: 20000
            });
            $('.detail-cart').removeClass('d-none');
            $('.total-product').removeClass('d-none');
            $('#emptyCart').addClass('d-none');
        }
        $('#mainCart').html(code);
        $('#totalCart').html(moneyFormat(total));
        $('#showTotalItems').html(length);
        $('#showCartTotal').html(moneyFormat(total));
        $('#totalCartMobile').html(moneyFormat(total));

    }

    function showMoney(price, discount = 0) {
        discount = (discount/100).toFixed(0);
        return moneyFormat((price*(1-discount)).toFixed(0));
    }

    function moneyFormat(amount) {
        var currency = '{{env('MIX_APP_CURRENCY')}}';
        switch (currency){
            case 'Rp':
                return 'Rp ' + String(amount).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
            case 'KRW':
                return  String(amount).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.') + ' KRW';
            default:
                return String(amount).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
        }
        // return "Rp "+String(Number(price).toFixed(0)).replace(/(.)(?=(\d{3})+$)/g,'$1.');
    }

    function numberFormat(number) {
        return String(Number(number).toFixed(0)).replace(/(.)(?=(\d{3})+$)/g,'$1.')
    }

    function updateMobileCartStatus(data) {
        htmlCode = "";
        totalCartMobile = 0;
        $.each( data, function( key, value ) {
            htmlCode += "<div class=\"product d-flex justify-content-between align-items-center\">\n" +
                "                        <div class=\"left d-flex\">\n" +
                "                            <img class=\"img-your-cart img-cart-mobile\" src=\""+config.routes.url+value.options.thumbnail+"\" alt=\"\">\n" +
                "                            <div class=\"detail-product-yourcart\">\n" +
                "                                <div class=\"d-flex justify-content-between product__rp\">\n" +
                "                                    <a href=\""+config.routes.productDetail+value.options.slug+"\" class=\"name-product truncate-overflow-one\">"+value.name+"</a>\n" +
                "                                    <div class=\"truncate-overflow-one\">\n";
            htmlCode += (value.options.discount>0)?"<h3 class=\"old-price\">"+moneyFormat(value.options.oldPrice)+"</h3>\n":"";
            htmlCode += "                           <h3>"+moneyFormat(value.price)+"</h3>\n" +
                "                                    </div>" +
                "                                </div>\n" +
                "                                <div class=\"d-flex amount-main amount-details amount-cart\">\n" +
                "                                    <div class=\"button-1 col main-reduction\"><img src=\""+config.routes.url+"vendor/buyer/Img/reduction.svg\" alt=\"\"></div>\n" +
                "                                    <input name=\"rowId\" type=\"hidden\" value=\""+value.rowId+"\">\n" +
                "                                    <input name=\"qty\" type=\"text\" class=\"input number numbar-main\" value=\""+value.qty+"\">\n" +
                "                                    <div class=\"col button-2 main-add\"><img src=\""+config.routes.url+"vendor/buyer/Img/add.svg\" alt=\"\"></div>\n" +
                "                                </div>\n" +
                "                            </div>\n" +
                "                        </div>\n" +
                "                    </div>\n" +
                "                    <hr>";
            totalCartMobile += value.price*value.qty;


        });
        var length = Object.keys(data).length;
        if(length == 0){
        }
        else{
            $('.mobile-cart-content').html(htmlCode);
            $('#totalMobileCart').html(moneyFormat(totalCartMobile));
            $('#countCartMobile').html(length);
        }
    }
</script>
<script type="text/javascript" src="{{ asset('vendor/buyer/script/wishlist.js') }}"></script>
<script type="text/javascript">

    function printDiscount(discount) {
        if(discount<100){
            discount = discount+ '% off';
        }else{
            discount = '- ' + moneyFormat(discount);
        }
        return discount;
    }

    function printItemProductStore(value) {

        var url = location.protocol + "//" + location.host;
        var img =url+'/img/not-found.jpg';
        let htmlCode = "";
        var price=value.price;
        var disPrice=value.presentPrice;
        htmlCode += "<div class=\"col-product-store col-md-4 col-sm-6\">\n" +
            "                        <div class=\"card card-product\">\n" +
            "                            <a href=\""+config.routes.productDetail+value.slug+"\">\n" +
            "                                <img class=\"img-fluid card-img-top\" src=\""+config.routes.url+value.image+"\" alt=\"...\" onerror=\"this.src=\'"+img+"\'\">\n" +
            "</a>\n";
        htmlCode += (value.discount)?"                            <p class=\"sale-off text-center\">"+printDiscount(value.discount, value.discount_type)+"</p>\n":"";

        htmlCode += "                            <div class=\"card-body\">\n" +
            "                                <p class=\"card-text seller-name truncate-overflow-one\" style=\"margin-bottom: 0;\"><a href=\""+config.routes.store+value.store.slug+"\">"+value.store.name+"</a></p>\n" +
            "                                    <h3 class=\"truncate-overflow-two\" style=\"margin-bottom: 16px;\"><a class=\"link-product\" href=\""+config.routes.productDetail+value.slug+"\">"+value.name+"</a></h3>\n" +
            "                                <div class=\"d-flex\">\n";
        htmlCode += (value.discount)?"                                    <p class=\"text-sale-off truncate-overflow-one\">"+moneyFormat(value.price)+"</p>\n":"";
        if (disPrice !== price){
            htmlCode += "                                    <p class=\"card-text text-muted truncate-overflow-one card-title\"><a href=\"#\" style=\"color: #EB4242;\">"+showMoney(value.presentPrice)+"</a></p>\n" +
                "                                </div>\n" +
                "                            </div>\n" +
                "                        </div>\n" +
                "                    </div>";
        }else {
            htmlCode += "                                    <p class=\"card-text text-muted truncate-overflow-one card-title\"><a href=\"#\">"+showMoney(value.presentPrice)+"</a></p>\n" +
                "                                </div>\n" +
                "                            </div>\n" +
                "                        </div>\n" +
                "                    </div>";
        }

        return htmlCode;
    }
</script>
@yield('extra-footer')
@stack('scripts')
</body>
</html>
