<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="locale" content="{{ App::getLocale() }}"/>

    {!! SEO::generate() !!}
    <meta name="csrf-token" content="{{ csrf_token() }}" />
{{--    to update HTTPS Ajax Request--}}
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('asset-common/css/bootoast.min.css') }}" rel="stylesheet" type="text/css"/>

    <link rel="stylesheet" href="{{ asset('asset-seller/font/Inter/style.css') }}">

    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="{{mix('css/seller-all.css')}}">
    @stack('stylesheets')
    <style>
        .menu-li-active svg.menu-left-icon>path, .menu-li-active svg.menu-left-icon>g>path{
            stroke: #30B6A4;
        }

    </style>
</head>
<body id="white" class="d-flex flex-column min-vh-100 @yield('body-class')">
<div class="wrap" id="app">
    @include('seller.shared._header')
{{--    @include('seller.shared._header_banner')--}}
    <div class="content" style="margin-bottom: -15px;">
        <div class="container full-sm">
            <div class="row" style="border-top: 1px solid #E4E8E8;">
                <div class="col-2 col-collap web-block" style="margin-top: 24px;">
                    @include('seller.shared._main_nav')
                </div>
{{--                <div class="col-1 col-collap invisible-col"></div>--}}
                <div class="col-md-10 col-sm-12 col-collap" style="border-left: 1px solid #E4E8E8;margin-top: 9px;">
                    <div class="container">
                        @if ($message = Session::get('success'))
                            <div class="success-message mb-4">
                                <strong>{{ $message }}</strong>
                            </div>
                        @endif
                    </div>
                    @yield('content')

                    <div class="modal" id="popup-message">
                        <div class="modal-dialog">
                            <div class="modal-content">

                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title"></h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>

                                <!-- Modal body -->
                                <div class="modal-body">
                                    <div class="text-center mb-3" style="font-size: 1.5em;">
                                        @if ($message = Session::get('message'))
                                            {{ $message }}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (auth()->user())
        <count-unread user-id="{{auth()->user() ? auth()->user()->id : 0}}"></count-unread>
    @endif
</div>
@include('seller.shared._modal')
<div class="wrapper flex-grow-1"></div>
<hr>
@include('buyer.partials.footer')

<script
        src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>
<script src="{{ mix('js/app.js') }}"></script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
<script src="{{ asset('asset-common/js/bootoast.min.js') }}"></script>
<script src="{{ asset('asset-seller/script/JsBarcode.code128.min.js')}}"></script>
<script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.js"></script>

<script src="https://kit.fontawesome.com/695093ff3f.js"></script>
<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
{{--<script type="text/javascript" src="{{ asset('asset-seller/script/menu.js') }}"></script>--}}
<script src="{{ asset('asset-common/js/common.js') }}" type="text/javascript"></script>
<script src="{{asset('vendor/buyer/script/loading.js')}}" type="text/javascript"></script>
<script type="text/javascript" src="{{ asset("vendor/buyer/script/menu.js") }}"></script>
<script>

    $(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });

    function formatMoney(input) {
        return (input/1000).toFixed(3);
    }

    $(function () {
        // Active menu
        var url = window.location.pathname,
            urlRegExp = new RegExp(url.replace(/\/$/,'') + "$");

        $('.js-seller-main-nav a').each(function(){
            // and test its normalized href against the url pathname regexp
            if(urlRegExp.test(this.href.replace(/\/$/,''))){
                console.log(url + '----' + urlRegExp);
                $(this).parent().addClass('menu-li-active');
            }
        });

        @if (Session::get('message'))
        $('#popup-message').modal('show');
        @endif
    })
</script>

<script>
    function selectBank(value){
        $("input[name='bank_id'][value='"+value+"']").prop('checked', true);
    }

    function withdraw() {
        startLoading();
        $.ajax({
            type: "POST",
            url: "{{route('seller.disbursement.withdraw')}}",
            // The key needs to match your method's input parameter (case-sensitive).
            data: $('#withDrawForm').serialize(),
            dataType: "json",
            success: function(data){
                $('#withdrawModal').modal('toggle');
                $('#withDrawForm')[0].reset();
                bootoast.toast({
                    message: "Withdraw Success!",
                    type: 'success',
                    position: 'rightBottom'
                });
                //update
                $('#storeBalance').html(data.storeBalance);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                var responseText = JSON.parse(XMLHttpRequest.responseText);
                var errors = responseText.errors;
                $.each( errors, function( key, value ) {
                    bootoast.toast({
                        message: value,
                        type: 'danger',
                        position: 'rightBottom'
                    });
                });

            }
        }).always(function() { //use this
            stopLoading();
        });
    }

    function startLoading() {
        $('html').append('<div id="ajaxForm">\n' +
            '    <div class="loader">\n' +
            '        <div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>\n' +
            '    </div>\n' +
            '</div>');
    }
    function stopLoading() {
        $('#ajaxForm').remove();
    }


</script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.ui/1.8.18/jquery-ui.js"></script>
<script src="{{asset('asset-seller/script/search-bar.js')}}"></script>
<script>
    //config
    // global app configuration object
    var config = {
        routes: {
            url: "{{url('')}}" + "/",
            productDetail: "{{ route('seller.product.edit', '') }}" + "/",
            wishlist: "{{ route('wishlist.add','') }}"  + "/",
            wishlistStore: "{{ route('wishlistStore.add','') }}"  + "/",
            quickSearch: "{{ route('search.quick.in-store', auth()->user()->store->id) }}" +"/",
        }
    };
    //autocomplete to search

</script>


@yield('scripts')
@stack('scripts-2')

</body>
</html>
