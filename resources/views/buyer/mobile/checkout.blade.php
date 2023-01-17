@extends('buyer.mobile.layout')

@section('title', 'Shopping Cart')


@section('content')

    <div class="content">
        <div id="header-1" class="header-bottom mobi-block mb-59px">
            <header class="header-cart-mobi heder-tab">
                <div class="container">
                    <div class="container wrap-mdi d-flex tow-element" style="padding: 0;">
                        @include('buyer.mobile.partials.back-button')
                        <p class="text-center w-100 link-product">@lang('Delivery Information')</p>
                    </div>
                </div>
            </header>
        </div>
        <div class="container">
            <checkout buy-now-cart="{{$isBuynow ? 1 : 0}}" ref-id="{{$ref}}"></checkout>
        </div>
    </div>
@endsection

@section('extra-footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
    <script type="text/javascript" src="{{ asset('vendor/buyer/script/address.js') }}"></script>
    <script type="text/javascript" src="{{ asset("vendor/buyer/script/checkout.js") }}"></script>
@endsection

