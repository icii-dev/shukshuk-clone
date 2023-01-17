@extends('buyer.mobile.layout')

@section('title', 'Store')
@section('page-id', 'store')
@section('content')
    <div id="header-2" class="header-bottom mobi-block">
        <div class="container wrap-product-store">
            <div class="product-store d-flex justify-content-between">
                <div>
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('vendor/buyer/Img/Logo.png') }}" alt="">
                    </a>
                    <form action="" id="form-search-product" class="form-inline my-2 my-lg-0 search-product">
                        @csrf
                        <input name="keyword" class="form-control mr-sm-2 input-menu ui-autocomplete-input" type="search" placeholder="Search In This Store " aria-label="Search" autocomplete="off" role="textbox" aria-autocomplete="list" aria-haspopup="true">
                        <input type="hidden" name="idStore" value="{{$store->id}}">
                        <button style="padding: 10px;" class="btn search my-2 my-sm-0 " type="submit"><i class="fas fa-search" aria-hidden="true"></i></button>
                    </form>
                    @include('buyer.partials.mobile-menu-navbar')
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="bg-cover w-100">
            @if($store->is_cover_video)
                <iframe class="img-responsive" width="100%"
                        src="{{convertYoutube($store->cover_video)}}">
                </iframe>
            @else
                <img src="{{getStoreCoverUrl($store->cover_image)}}" onerror="this.src='{{asset('img/default.jpg')}}'" style="width: 100%">
            @endif
                <div class="container" style="position: relative">
                <div class="d-flex justify-content-end">
                    <div class="heart-2 d-flex heart-store">
                        <img onclick="addWhishlistStore(this, '{{ $store->id }}')"
                             src="@if(!$isWishlist){{ asset("vendor/buyer/Img/heart-2.svg") }}@else {{ asset("vendor/buyer/Img/wishlist-checked.svg") }} @endif"
                             alt="">
                        <h3>{{$store->wishlist->count()}}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="container" style="margin-top: 76px">
            <div class="avatar-store">
                <div class="col-md-12 col-lg-7 col-xl-8 store-name">
                    <div class="wrap-name">
                        <div class="avatra d-flex">
                            <img class="img-avatar" src="{{ getStoreAvatarUrl($store->avatar_image) }}" alt="" onerror="this.src='{{asset('img/store-avatar/default-avatar.png')}}'">
                            <div class="name-seller">
                                <h1 class="truncate-overflow-one">{{$store->name}}</h1>
                                <p class="central">{{$store->address}}</p>
                                @if($store->rating > 0)
                                <div class="star d-flex">
                                    <h3>{{$store->rating}}</h3>
                                    <img src="{{ asset("vendor/buyer/Img/start.svg") }}" alt="">
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <h2>About Us</h2>
                    <p class="paragrap-store">
                        <span id="showLess">{!! str_limit($store->description, 400, "") !!}</span>
                        @if(strlen($store->description)>=400)
                            <span id="dots">...</span><span id="more">{!! $store->description !!}
                                    </span>
                            <span class="author read-more" onclick="myFunction()" id="myBtn">Read more</span></p>
                    @endif
                </div>
            </div>
        </div>
        <div class="container wrap-product-store">
            <div class="d-flex justify-content-between store-name">
                <h2 style="margin-left:15px; ">Products</h2>
            </div>
            <div class="product-store d-flex justify-content-between">
                <div class="row" id="productList">
                    @foreach($products as $product)
                        @include('buyer.partials.product.item-product-list')
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
@section('import_js')
    <script src="{{asset('vendor/buyer/script/mobi/order-mobi.js')}}"></script>
    <script type="text/javascript">
        var store_slug = "{{$store->slug}}";
        var store_name = "{{$store->name}}";
    </script>
    <script type="text/javascript" src="{{asset('vendor/buyer/script/store-detail.js')}}"></script>
    <script>
        $(document).ready(function(){
            $('#form-search-product').submit(function (e) {
                e.preventDefault();
                // Gui request len server
                $.post('/store/search-products', $(this).serialize())
                    .then(function (resp) {
                        $('#productList').html(resp.html);
                    })
                ;
            });
        });
    </script>
@endsection