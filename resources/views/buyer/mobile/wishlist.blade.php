@extends('buyer.mobile.layout')

@section('title', 'Wishlist')
@section('extra-header')
    <style>
       .padding-col-product{
           padding-bottom: 20px;
       }
    </style>
@endsection
@section('content')
<div id="header-1" class="header-bottom mobi-block mb-59px" style="margin-bottom: 60px;">
    <header class="header-cart-mobi heder-tab" style="margin-bottom: 0;padding-bottom: 16px!important;">
        <div class="container" style="padding: 0;">
            <div class="container wrap-mdi d-flex justify-content-between mb-30px align-items-center" style="padding-right: 24px;padding-left: 24px; ">
                @include('buyer.partials.mobile-cart-navbar')
                <p class="link-product text-center" style="padding-right: 12px;">Wishlist</p>
                @include('buyer.partials.mobile-menu-navbar')
            </div>
            <ul class="nav tab-mobi">
                <li class="nav-item" style="margin-left: 20px;margin-right: 24px;">
                    <a class="card-title color-gray active" data-toggle="tab" href="#tab-1"
                       style="padding-left: 24px;padding-right: 24px;">Product</a>
                </li>
                <li class="nav-item">
                    <a class="card-title color-gray" data-toggle="tab" href="#tab-2"
                       style="padding-left: 24px;padding-right: 24px;">Store</a>
                </li>
            </ul>
        </div>
    </header>
</div>
    <div class="content">
        <div class="tab-content">
            <div id="tab-1" class="tab-pane active show" role="tabpanel">
                <div class="container" style="padding: 0 12px;">
                    <div class="wrap-order-mobile">
                        <div class="row whishlist" >
                            @if (count($productWishlist))
                                @foreach($productWishlist as $product)
                                    @include('buyer.partials.product.item-product-list')
                                @endforeach
                            @else
                                <p>{{trans('messages.no_data_available')}}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div id="tab-2" class="tab-pane" role="tabpanel">
                <div class="store-product">
                    <div class="container">
                        <div class="row small-row" id="storeList">
                            @if (count($storeWishlist))
                                @foreach($storeWishlist as $store)
                                    <div class="col-sm-6 mb-2">
                                        <a href="{{ route('store.index', $store->slug) }}">
                                            <div class="card">
                                                <div>
                                                    <img src="{{getStoreAvatarUrl($store->avatar_image)}}" class="card-img-top">
                                                </div>
                                                <div class="card-body">
                                                    <div class="name-seller">
                                                        <h3 class="truncate-overflow-one mr-1">{{$store->name}}</h3>
                                                        <p class="central truncate-overflow-one">{{$store->address}}</p>
                                                    </div>
                                                    <div class="star d-flex">
                                                        <h3>{{$store->rating}}</h3>
                                                        <img src="{{ asset("vendor/buyer/Img/start.svg") }}" alt="">
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            @else
                                {{trans('messages.no_data_available')}}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('import_js')
    <script src="vendor/buyer/script/mobi/order-mobi.js"></script>
@endsection
