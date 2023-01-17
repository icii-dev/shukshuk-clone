@extends('buyer.mobile.layout')

@section('title', 'Messenger')

@section('content')
    <div id="header-2" class="header-bottom mobi-block">
                <header class="header-cart-mobi">
                    <div class="container">
                        <div class="container wrap-mdi d-flex tow-element">
                            @include('buyer.mobile.partials.back-button')
                            <p class="text-center w-100">Messenger</p>
                        </div>
                    </div>
                </header>
            </div>
    <div class="content">
        <div class="container">
            @if (auth()->user())
                <messenger user-id="buyer-{{auth()->user()->id}}"></messenger>
            @endif
        </div>
    </div>
@endsection
@section('import_js')
    <script src="{{asset('vendor/buyer/script/mobi/order-mobi.js')}}"></script>
@endsection
