@extends('layouts.buyer')

@section('title', 'Shopping Cart')

@section('extra-css')
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/buyer/Css/home.css')}}">
@endsection

@section('content')
    <div id="content">
        <div class="slider">
            <div class="container">
                    <div class="banner-beta">
                        <div id="carouselBanner" class="carousel-banner carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <li data-target="#carouselBanner"
                                    data-slide-to="0"
                                    class="active">
                                </li>
                                <li data-target="#carouselBanner"
                                    data-slide-to="1">
                                </li>
                            </ol>
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="{{asset('vendor/buyer/Img/banner.png')}}" style="width:100%;">
                                    <div class="carousel-caption content-banner background">
                                        <h1><a href="#" class="banner-title">Selamat datang! 👋</a></h1>
                                        <p class="banner-description-text">
                                            Shukshuk adalah online marketplace bagi individu dan UMKM yang mendukung transaksi jual-beli antar negara-negara di Asia. Kami hadir dengan misi untuk menyediakan ekosistem jual beli yang aman dan pengiriman yang lebih terjangkau hingga ke pelosok negeri.
                                        </p>
{{--                                        <p class="banner-note shukshuk-gray">*Selama kuota voucher masih tersedia</p>--}}
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <img src="{{asset('vendor/buyer/Img/banner2.svg')}}" style="width:100%;">
                                    <div class="carousel-caption content-banner">
                                        <h1><a href="#" class="banner-title">Bergabung Sebagai Penjual 🤝</a></h1>
                                        <p class="banner-description-text">
                                            Shukshuk siap menjadi bagian dari cerita perjalanan bisnismu. Yuk, berjualan dan bertumbuh bersama Shukshuk!
                                            <a href="https://drive.google.com/file/d/1UuEb1LULZ0lsnJ4FPsHtdG-Y_twTzHqv/view"
                                               target="_blank"
                                               class="shukshuk-accent"
                                            >
                                                -> Lihat cara daftar
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

            </div>
        </div>
        <div class="product-category">
            <div class="container">
                <h2 class="product-title" style="margin-bottom: 24px;">@lang('Selected Categories')</h2>
                <ul class="web-block nav tab-product" style="padding-bottom: 14px;border-bottom: 1px solid #E4E8E8;">
                    <li class="nav-item">
                        <a class="card-title color-gray" data-toggle="tab" href="#Category3">@lang('Food & Beverage')</a>
                    </li>
                    <li class="nav-item " id="click-Overview">
                        <a class="card-title active color-gray" data-toggle="tab" href="#Category1">@lang('Fashion')</a>
                    </li>
                    <li class="nav-item">
                        <a class="card-title color-gray" data-toggle="tab" href="#Category2">@lang('Entertainment & Hobbies')</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="Category1" role="tabpanel">
                        <div class="row web-flex">
                            @foreach($storesOfCate1 as $store)
                                @include('buyer.partials.store.item-selected-category')
                            @endforeach
                        </div>
                    </div>
                    <div class="tab-pane" id="Category2" role="tabpanel">
                        <div class="row web-flex">
                            @forelse($storesOfCate2 as $store)
                                @include('buyer.partials.store.item-selected-category')
                            @empty
                                <p class="shukshuk-gray w-100 text-center">We’re still curating for more sellers :)</p>
                            @endforelse
                        </div>
                    </div>
                    <div class="tab-pane" id="Category3" role="tabpanel">
                        <div class="row web-flex">
                            @foreach($storesOfCate3 as $store)
                                @include('buyer.partials.store.item-selected-category')
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="container mobi-block" style="padding: 0;margin-bottom: 35px;">
                    <div class="wrap-scroll">
                        <div id="next_nav">
                            <img src="{{ asset("vendor/buyer/Img/button-right.png") }}" alt="">
                        </div>
                        <div id="pre_nav">
                            <img src="{{ asset("vendor/buyer/Img/button-left.png") }}" alt="">
                        </div>
                        <div class="container-scroll">
                            <div id="nav">
                                <div class="d-flex">
                                    @foreach(getListCategoryParent() as $cat)
                                    <div class="item-category">
                                        <div class="category bg-category-1" style="padding-left: 15px;width: 248px">
                                            <a href="{{ route('product.category', [$cat->slug, 0,0]) }}">
                                                <div class="detail">
                                                    <h3 class="card-title" style="margin-bottom: 0">{{$cat->name}}</h3>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="seller-category">
            <div class="container">
                <h2 class="seller-title" style="margin-bottom: 24px;">@lang('Featured Shops')</h2>
                <div class="row">
                    @include('buyer.partials.home.shops-featured')
                </div>
                <div class="container mobi-block" style="padding: 0;">
                    <div class="wrap-scroll-seller">
                        <div id="next_nav-1">
                            <img src="{{ asset("vendor/buyer/Img/button-right.png") }}" alt="">
                        </div>
                        <div id="pre_nav-1">
                            <img src="{{ asset("vendor/buyer/Img/button-left.png") }}" alt="">
                        </div>
                        <div class="container-scroll">
                            <div id="nav-1">
                                <div class="row">
                                    <div class="item-seller d-flex">
                                        <div class="seller">
                                            <div class="info d-flex">
                                                <img src="{{ asset("vendor/buyer/Img/user.svg") }}" alt="">
                                                <h3>@lang('Individual')</h3>
                                            </div>
                                            <p class="description-text">{!! __('Personal Businesses,<br> Entrepreneurs & Micro Start-ups')!!}</p>
                                            <a href="#" class="d-flex">
                                                <span class="link-product">View all</span>
                                                <i class="fas fa-arrow-right" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="item-seller d-flex">
                                        <div class="seller">
                                            <div class="info d-flex">
                                                <img src="{{ asset("vendor/buyer/Img/seller-2.svg") }}" alt="">
                                                <h3>NGO</h3>
                                            </div>
                                            <p class="description-text">{!! __('Charities, Social Enterprises and other Non-Profits') !!}</p>
                                            <a href="#" class="d-flex">
                                                <span class="link-product">View all</span>
                                                <i class="fas fa-arrow-right" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="item-seller d-flex">
                                        <div class="seller">
                                            <div class="info info-coming d-flex">
                                                <img src="{{ asset("vendor/buyer/Img/seller-3.svg") }}" alt="">
                                                <h3>@lang('Small Medium Enterprise')</h3>
                                            </div>
                                            <p>@lang('Small Medium Enterprise')</p>
                                            <a href="#" class="d-flex coming-soon">
                                                <span>@lang('Coming Soon')</span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="item-seller d-flex">
                                        <div class="seller">
                                            <div class="info info-coming d-flex">
                                                <img src="{{ asset("vendor/buyer/Img/seller-4.svg") }}" alt="">
                                                <h3>@lang('Big Companies')</h3>
                                            </div>
                                            <p>@lang('Big Companies')</p>
                                            <a href="#" class="d-flex coming-soon">
                                                <span>@lang('Coming Soon')</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="featured-product">
            <div class="container">
                <h2 class="seller-title" style="margin-bottom: 24px;">@lang('Featured Product')</h2>
                <div class="row" id="featureProductsRow">
                    @foreach($featureProducts as $product)
                        @include('buyer.partials.product.item-product-list')
                    @endforeach
                </div>
                @if($featureProducts->nextPageUrl())
                <a href="#" class="button load-more link-product" style="margin-top: 0;">@lang('Load More')</a>
                @endif
            </div>
        </div>
        <div class="why-shukshuk">
            <div class="container">
                <div class="row web-flex">
                    <div class="col-md-3 d-flex align-items-center">
                        <h1 class="text-md-center text-xl-left banner-title">@lang('Why shukshuk?')</h1>
                    </div>
                    <div class="col-md-3 value">
                        <div class="card">
                            <img src="{{ asset("vendor/buyer/svg/Group 56.svg") }}">
                            <div class="card-body text-center">
                                <h2 class="product-title">@lang('Relationships')</h2>
                                <p class="description-text">@lang('We are all about building relationships')</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 value">
                        <div class="card">
                            <img src="{{ asset("vendor/buyer/svg/Group 55.svg") }}">
                            <div class="card-body text-center">
                                <h2 class="product-title">@lang('Stories')</h2>
                                <p class="description-text">@lang('We value getting to know the stories of our sellers and sharing them to the world')</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 value">
                        <div class="card">
                            <img src="{{ asset("vendor/buyer/svg/Group 54.svg") }}">
                            <div class="card-body text-center">
                                <h2 class="product-title">@lang('Integrity')</h2>
                                <p class="description-text">@lang('We believe in doing things right')</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mobi-block">
                    <div class="col-why">
                        <h1>Why shukshuk?</h1>
                    </div>
                    <div id="carouselWhy" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#carouselWhy" data-slide-to="0" class="active"></li>
                            <li data-target="#carouselWhy" data-slide-to="1"></li>
                            <li data-target="#carouselWhy" data-slide-to="2"></li>
                        </ol>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <div class="col-product value">
                                    <div class="card">
                                        <img src="{{ asset("vendor/buyer/Img/Ellipse.png") }}">
                                        <div class="card-body text-center">
                                            <h2 class="card-title">Relationships</h2>
                                            <p class="card-text">
                                                @lang('We are all about building relationships')
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="col-product value">
                                    <div class="card">
                                        <img src="{{ asset("vendor/buyer/Img/Ellipse.png") }}">
                                        <div class="card-body text-center">
                                            <h2 class="card-title">Stories</h2>
                                            <p class="card-text">
                                            @lang('We value getting to know the stories of our sellers and sharing them to the world')
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="col-product value">
                                    <div class="card">
                                        <img src="{{ asset("vendor/buyer/Img/Ellipse.png") }}">
                                        <div class="card-body text-center">
                                            <h2 class="card-title">Integrity</h2>
                                            <p class="card-text">
                                                @lang('We believe in doing things right')
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>
@endsection
@section('footer-custom','think-gray')

@section('extra-footer')
    <script src="vendor/buyer/script/home.js"></script>
    <script type="text/javascript">
        var page = 2;
        $('.load-more').click(function(e){
            e.preventDefault();
            loadMoreProducts();
        });
        function loadMoreProducts() {
            $.ajax(
                {
                    url: '?page=' + page,
                    type: "get",
                    datatype: "html"
                }).done(function(data){
                page++;
                $('#featureProductsRow').append(data.html);
            }).fail(function(jqXHR, ajaxOptions, thrownError){
                alert('No response from server');
            });
        }

    </script>
@endsection