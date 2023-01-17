@extends('layouts.buyer')

@section('title', 'Shopping Cart')

@section('extra-header')
@endsection

@section('content')
    <div class="mobi-block mobi-step-3">
        <div class="Payment-Success h-100">
            <a id="close-step" href="{{route('home')}}" class="close">
                <img src="{{ asset("vendor/buyer/Img/close.svg") }}" alt="">
            </a>
            <div class="main-success">
                <img class="truck" src="{{ asset("vendor/buyer/Img/Truck.png") }}" alt="">
                <h2 class="text-center product-subtitle">Payment Success</h2>
                <p class="text-center  description-text">Imperdiet potenti aenean tortor magna et viverra ut. Libero nisi curabitur tincidunt in commodo in integer.</p>
            </div>
            <div class="col-12 btn-position">
                <a class="btn btn-primary btn-buy w-100" href="{{ route('users.orders') }}" role="button">Go To My Order</a>
            </div>
        </div>
    </div>
@endsection

@section('extra-footer')
    <script type="text/javascript">
        $("footer").remove();
    </script>
@endsection
