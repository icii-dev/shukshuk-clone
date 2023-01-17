@extends('layouts.buyer_payment_view')

@section('title-payment', 'Shopping Cart')

@section('extra-header')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
@endsection
@section('page-id', 'gray')
@section('content')
    <div class="content">
        <div class="container">
            <checkout-payment route-checkout="{{route('checkout.index', 'cart')}}" checkout-id="{{ $checkoutId }}"
                              user-id="{{auth()->user() ? auth()->user()->id : 0}}">
            </checkout-payment>
        </div>
    </div>
@endsection

@section('extra-footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
    <script type="text/javascript" src="{{ asset('vendor/buyer/script/address.js') }}"></script>
    <script type="text/javascript" src="{{ asset("vendor/buyer/script/checkout.js") }}"></script>
@endsection
