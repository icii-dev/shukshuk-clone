@extends('layouts.buyer_payment_view')

@section('title', 'Shopping Cart')

@section('extra-header')

@endsection

@section('content')
    <div class="content">
        <div class="container" style="text-align: center; padding-top: 32px; padding-bottom: 120px">
            <h6 class="product-subtitle">@lang('Payment Successful')</h6>
            <br>
            <p>@lang('checkout success message')</p>
            <div class="mt-30px">
                <a style="margin-right: 12px;" class="btn primary" href="{{route('users.orders')}}">@lang('Go To My Orders')</a>
                <a class="btn btn-cancel" href="{{route('home')}}">@lang('Continue Shopping')</a>
            </div>
            <div class="mt-30px" style="color: #97A3A2;">@lang('You can find My Orders on the top left.')</div>
        </div>
        <div class="container">
            <div class="related-product related-product-standard web-block">
                <p class="mb-30px text-center product-subtitle">@lang('You May Also Like')</p>
                <div class="row">
                    @foreach($mightAlsoLike as $product)
                        @include('buyer.partials.product.item-product-list')
                    @endforeach
                    {{--                    end card view--}}
                </div>
            </div>

        </div>

    </div>

@endsection
@section('footer-custom','think-gray')
@section('extra-footer')
@endsection