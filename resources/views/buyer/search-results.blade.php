@extends('layouts.buyer')

@section('title', 'Shopping Cart')

@section('extra-css')
@endsection

@section('content')

    <div class="content">
        <div class="container web-block">
            <h1 class="title-wishlist web-block">@lang('Search Results')</h1>
            <ul class="nav tab-mobi">
                <li class="nav-item">
                    <a class="active color-gray mb-17px" data-toggle="tab" href="#tab-1">@lang('Products')</a>
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
                    <div class="row whishlist" id="productsRow">
                        @foreach($products as $product)
                            @include('buyer.partials.product.item-product-list')
                        @endforeach
                    </div>
                    <a href="#" class="button load-more">Load More</a>
                </div>
            </div>
            <div id="tab-2" class="tab-pane" role="tabpanel">
                <div class="store-product">
                    <div class="container">
                        <div class="row small-row" id="storeList">
                            @if (count($stores))
                                @foreach($stores as $store)
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
                                                        @if($store->rating>0)<h3>{{$store->rating}}</h3>@endif
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

@section('extra-footer')
    <script type="text/javascript">
        var page = 2;
        $('.load-more').click(function(e){
            e.preventDefault();
            loadMoreProducts();
        });
        function loadMoreProducts() {
            $.ajax(
                {
                    url: window.location.href + '&page=' + page,
                    type: "get",
                    datatype: "html"
                }).done(function(data){
                page++;
                loadViewProduct(data);
                if(data.next_page_url==null){
                    $('.load-more').hide();
                }
            }).fail(function(jqXHR, ajaxOptions, thrownError){
                $('.load-more').hide();
                $.notify({
                    content : 'Fully loaded of products',
                    alertType: "alert-success",
                    timeout: 4000
                });
            });
        }
        // load product in id featureProductsRow
        function loadViewProduct(data) {
            htmlCode="";
            $.each( data.data, function( key, value ) {
                htmlCode += printItemProduct(value);
            });

            $('#productsRow').append(htmlCode);
        }
    </script>
@endsection