@extends('layouts.buyer')

@section('title', 'Shopping Cart')

@section('extra-header')

@endsection

@section('page-id', 'store')
@section('content')
    <div class="content" style="margin-top: -48px;">
        <div class="container full-sm">
            <div class="row">
                <div class="col-3 col-collap web-block border-right-gray">
                    @include('buyer.partials.menu-left-store')
                </div>
                <div class="col-md-9 col-sm-12 col-collap">
                    <div class="tab-content">
                        <div id="Overview" class="tabcontent tab-pane fade show active">
                            <div class="container">
                                <div class="avatar-store">
                                    <div class="col-12 store-name">
                                        <div class="wrap-name">
                                            <div class="d-flex justify-content-center">
                                                <div class="col-10 avatar d-flex">
                                                    <img class="img-avatar img-responsive" src="{{ getStoreAvatarUrl($store->avatar_image) }}" alt="" style="width: 108px; height: 108px;" onerror="this.src='{{asset('img/not-found.jpg')}}'">
                                                    <div class="name-seller ">
                                                        <h1 class="truncate-overflow-one">{{$store->name}}</h1>
                                                        <p class="central">{{$store->address}}</p>
                                                        @if($store->rating>0)
                                                        <div class="star d-flex">
                                                            <h3>{{$store->rating}}</h3>
                                                            <img src="{{ asset("vendor/buyer/Img/start.svg") }}" alt="">
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-2 container wrap-heart">
                                                    <div class="d-flex justify-content-end">
                                                        <div class="d-flex heart-store">
                                                            <img onclick="addWhishlistStore(this, '{{ $store->id }}')"
                                                                 src="@if(!$isWishlist){{ asset("vendor/buyer/Img/heart-2.svg") }}@else {{ asset("vendor/buyer/Img/wishlist-checked.svg") }} @endif"
                                                                 alt="">
                                                            <h3>{{$store->wishlist->count()}}</h3>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                @if($store->is_cover_video)
                                                    <iframe class="img-responsive bg-cover" width="869" height="469"
                                                            allowfullscreen="allowfullscreen"
                                                            src="{{convertYoutube($store->cover_video)}}">
                                                    </iframe>
                                                @else
                                                    <img src="{{getStoreCoverUrl($store->cover_image)}}" class="img-responsive bg-cover"  onerror="this.src='{{asset('img/default.jpg')}}'">
                                                @endif
                                            </div>

                                            <br/>
                                            <p class="product-subtitle">@lang('Who are we?')</p>
                                            <p class="paragrap-store">
                                                <span id="showLess">{!! str_limit($store->description, 400, "") !!}</span>
                                                @if(strlen($store->description)>=400)
                                                    <span id="dots">...</span><span id="more">{!! $store->description !!}</span>
                                                    <span class="author read-more" onclick="myFunction()" id="myBtn">Read more</span></p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="Products" class="tabcontent sub-products">
                            <div class="container wrap-product-store">
                                <div class="product-store d-flex justify-content-between">
                                    <h2>@lang('All Products')</h2>
                                    <div class="web-block">
                                        <form action="" id="form-search-product" method="POST" class="form-inline my-2 my-lg-0 search-product">
                                            @csrf
                                            <input name="keyword" class="form-control mr-sm-2 input-menu ui-autocomplete-input" type="search" placeholder="@lang('Search In This Store')" aria-label="Search" autocomplete="off" role="textbox" aria-autocomplete="list" aria-haspopup="true">
                                            <input type="hidden" name="idStore" value="{{$store->id}}">
                                            <button style="padding: 10px;" class="btn search my-2 my-sm-0 " type="submit"><i class="fas fa-search" aria-hidden="true"></i></button>
                                        </form>
                                    </div>
                                </div>
                                <div class="row" id="productList">
                                    @foreach($products as $product)
                                        @include('buyer.partials.product.item-product-list')
                                    @endforeach
                                        @if($products->nextPageUrl())
                                            <a href="#" style="margin-top: 16px" class="button load-more web-block link-product">Load More</a>
                                        @endif
                                </div>

                            </div>
                        </div>

                        @foreach($cate as $cat)
                            <div id="{{$cat->name}}" class="tabcontent sub-products">
                                <div class="container wrap-product-store">
                                    <div class="product-store d-flex justify-content-between">
                                        <h2>{{$cat->name}}</h2>
                                        <div class="web-block">
                                            <form action="" method="POST" class="form-inline my-2 my-lg-0 search-product test search-product-cat">
                                                @csrf
                                                <input name="keyword" class="form-control mr-sm-2 input-menu ui-autocomplete-input" type="search" placeholder="Search In This Store " aria-label="Search" autocomplete="off" role="textbox" aria-autocomplete="list" aria-haspopup="true">
                                                <input type="hidden" name="idStore" value="{{$store->id}}">
                                                <input type="hidden" name="idCategory" value="{{$cat->id}}">
                                                <button style="padding: 10px;" class="btn search my-2 my-sm-0 " type="submit"><i class="fas fa-search" aria-hidden="true"></i></button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="row" id="productList{{$cat->id}}">
                                        @foreach($cat->products as $product)
                                            @include('buyer.partials.product.item-product-list')
                                        @endforeach
{{--                                        <div style="margin-left: 352px;">--}}
{{--                                            @if($products->nextPageUrl())--}}
{{--                                                <a href="#" class="button load-more web-block">Load More</a>--}}
{{--                                            @endif--}}
{{--                                        </div>--}}
                                    </div>

                                </div>
                            </div>
                        @endforeach
                        <div id="Promo" class="tabcontent"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('extra-footer')
    <script type="text/javascript">
        window.onpageshow = function(event) {
            if (event.persisted) {
                window.location.reload()
            }
        };
        var store_slug = "{{$store->slug}}";
        var store_name = "{{$store->name}}";
    </script>
    <script type="text/javascript" src="{{asset('vendor/buyer/script/store-detail.js')}}"></script>
    <script>
        function openMenu(evt, menuName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(menuName).style.display = "block";
            evt.currentTarget.className += " active";
        }
    </script>
    <script>
        var acc = document.getElementsByClassName("accordion");
        var i;

        for (i = 0; i < acc.length; i++) {
            acc[i].addEventListener("click", function() {
                this.classList.toggle("active");
                var panel = this.nextElementSibling;
                if (panel.style.display === "block") {
                    panel.style.display = "none";
                } else {
                    panel.style.display = "block";
                }
            });
        }
    </script>
    <script>
        $(function () {
            $('#form-search-product').submit(function (e) {
                e.preventDefault();
                // Gui request len server
                $.post('/store/search-products', $(this).serialize())
                    .then(function (resp) {
                        $('#productList').html(resp.html);
                    })
                ;
            });
        })
    </script>
    <script>
        $(function () {
            $('.search-product-cat').submit(function (e) {
                e.preventDefault();
                // Gui request len server
                var id=$(this).children('input[name="idCategory"]').val()
                $.post('/store/search-products-category', $(this).serialize())
                    .then(function (resp) {
                       $('#productList'+id).html(resp.html);
                    })
                ;
            });
        })
    </script>
@endsection
