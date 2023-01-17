@extends('buyer.mobile.layout')

@section('title', 'Shopping Cart')

@section('content')
<div id="header-1" class="header-bottom mobi-block mb-59px" style="margin-bottom: 30px;">
    <header class="header-cart-mobi heder-tab" style="margin-bottom: 0;padding-bottom: 16px!important;">
        <div class="container" style="padding: 0;">
            <div class="container wrap-mdi d-flex justify-content-between mb-30px align-items-center" style="padding-right: 24px;padding-left: 24px; ">
                @include('buyer.partials.mobile-cart-navbar')
                <p class="text-center">Order List</p>
                @include('buyer.partials.mobile-menu-navbar')
            </div>
            <ul class="nav tab-mobi">
                <li class="nav-item" style="margin-left: 20px;">
                    <a class="card-title color-gray active" data-toggle="tab" href="#tab-1"
                       style="padding-left: 12px;padding-right: 12px;">Active Order</a>
                </li>
                <li class="nav-item">
                    <a class="card-title color-gray" data-toggle="tab" href="#tab-2"
                       style="padding-left: 9px;padding-right: 9px;">History Order</a>
                </li>
            </ul>
        </div>
    </header>
</div>
    <div class="content">
        <div class="tab-content">
            <div id="tab-1" class="tab-pane active show" role="tabpanel">
                <div class="container">
                    <div class="wrap-order-mobile">
                        @foreach($orders as $order)
                            @if($order->status>1 && $order->products()->first())
                            <a class="product d-flex" href="{{ route('order.show', $order->id) }}">
                                <img class="d-block mr-3 order-product-thumbnail" onerror="this.src='{{asset('img/not-found.jpg')}}'"
                                     src="{{ asset($order->products()->first()->image) }}" alt="">
                                <div class="wrap-information w-100" >
                                    <div class="d-flex justify-content-between" style="padding-bottom: 8px;">
                                        <p class="description-text color-gray truncate-overflow-one">{{$order->id}}</p>
                                        <p class="description-text color-gray">{{date("m-d-Y", strtotime($order->created_at))}}</p>
                                    </div>
                                    <p  style="margin-left: 0; " class="color-black link-product truncate-overflow-one">{{$order->products()->first()->name}}</p>
                                    <p style="padding-top: 10px;" class="color-custom card-title-product">{{priceDiscount($order->products()->first()->pivot->subtotal)}}</p>
                                </div>
                            </a>
                            <hr>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            <div id="tab-2" class="tab-pane" role="tabpanel" style="padding-left:20px; padding-right: 20px;">
                @foreach($orders as $order)
                    @if($order->status<=1 && $order->products()->first())
                        <a class="product d-flex" href="{{ route('order.show', $order->id) }}">
                            <img class="d-block mr-3 order-product-thumbnail" onerror="this.src='{{asset('img/not-found.jpg')}}'"
                                 src="{{ asset($order->products()->first()->image) }}" alt="">
                            <div class="wrap-information w-100">
                                <div class="d-flex justify-content-between" style="padding-bottom: 8px;">
                                    <p class="description-text color-gray truncate-overflow-one">{{$order->id}}</p>
                                    <p class="description-text color-gray" style="white-space: nowrap;">{{date("d-M-Y", strtotime($order->created_at))}}</p>
                                </div>
                                <p style="margin-left: 0; " class="color-black link-product truncate-overflow-one">{{$order->products()->first()->name}}</p>
                                <p style="padding-top: 10px;" class="color-custom card-title-product">{{priceDiscount($order->products()->first()->pivot->subtotal)}}</p>
                            </div>
                        </a>
                        <hr>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section('import_js')
    <script src="vendor/buyer/script/mobi/order-mobi.js"></script>
@endsection
