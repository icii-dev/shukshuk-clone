@extends('layouts.buyer')

@section('title', 'Shopping Cart')

@section('extra-css')
@endsection

@section('content')

    <div class="content">
        <div class="container web-block">
            <h1 class="title-wishlist web-block">Wishlist</h1>
            <ul class="nav tab-mobi">
                <li class="nav-item">
                    <a class="active color-gray mb-17px" data-toggle="tab" href="#tab-1">Product</a>
                </li>
                <li class="nav-item">
                    <a class="color-gray mb-17px" data-toggle="tab" href="#tab-2">Store</a>
                </li>
            </ul>
            <hr class="mb-33px">
        </div>
        <div class="tab-content">
            <div id="tab-1" class="tab-pane active show" role="tabpanel">
                <div class="container container-whishlish">
                    <div class="row whishlist">
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
            <div id="tab-2" class="tab-pane" role="tabpanel">
                <div class="store-product">
                    <div class="container">
                        <div class="row small-row" id="storeList">
                            @if (count($storeWishlist))
                            @foreach($storeWishlist as $store)
                                <div class="col-md-4" style="margin-bottom: 32px;">
                                    <div class="card detail-store h-100" style="padding-bottom: 0">
                                        <div class="card-head d-flex">
                                            <img class="avatar"
                                                  src="{{ getStoreAvatarUrl($store->avatar_image) }}" alt="">
                                            <div class="warp-StoreName d-flex justify-content-between">
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
                                        <div class="card-body d-flex flex-column" style="padding: 0">
                                            <p>{{$store->description}}</p>
                                            <div class="mt-auto d-flex justify-content-center" style="border-top: 1px solid #E4E8E8; padding-top: 24px; padding-bottom: 28px">
                                                <a href="{{ route('store.index', $store->slug) }}">Visit Store</a>
                                            </div>
                                        </div>
                                    </div>
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
