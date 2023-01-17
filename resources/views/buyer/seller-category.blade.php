@extends('layouts.buyer')

@section('title', 'Shukshuk')

@section('extra-header')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
@endsection

@section('content')

    <div class="content">
        <div class="header-body">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-sm-12 wrap-Ngo">
                        <nav class="web-block" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{$type}}</li>
                            </ol>
                        </nav>
                        <div class="wrap-title d-flex justify-content-between">
                            <h1>{{ucfirst($type)}} Seller</h1>
                            <img class="mobi-block" src="{{ asset("vendor/buyer/Img/info.svg") }}" alt="">
                        </div>
                        <p class="web-block">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat uis aute irure dolor in reprehenderit in voluptate.</p>
                        <p class="mobi-block mt-3 pl-3">Featured Seller</p>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="container">
                            <div class="wrap-scroll-seller">
                                <div class="next-margin" id="next_nav-Seller">
                                    <img src="{{ asset("vendor/buyer/Img/button-right.png") }}" alt="">
                                </div>
                                <div class="pre-margin" id="pre_nav-Seller">
                                    <img src="{{ asset("vendor/buyer/Img/button-left.png") }}" alt="">
                                </div>
                                <div class="container-scroll container-scroll-seller">
                                    <div class="scroll-seller" id="nav-seller" style="margin-left: 0;">
                                        <div class="d-flex">
                                            @foreach($featuredStore as $store)
                                                <div class="wrap-seller-info bg-info-1">
                                                    <div  class="heart-like heart mobi-block">
                                                        <img src="{{ asset("vendor/buyer/Img/heart-2.svg") }}" alt="">
                                                    </div>
                                                    <div class="col-md-6 col-sm-12 seller-info">
                                                        <img src="{{ getStoreAvatarUrl($store->avatar_image) }}" alt="">
                                                        <div class="wrap-info-store">
                                                            <h3 class="truncate-overflow-one">{{$store->name}}</h3>
                                                            <p class="central">{{$store->address}}</p>
                                                            <a class="web-block" href="{{ route('store.index', $store->slug) }}">Visit Store -&gt;</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach()
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="filter web-block">
            <div class="container">
                    @include('buyer.partials.form-filter', ['filterAction' => url('store/category/'.$type)])
            </div>
        </div>
        <div class="store-product">
            <div class="container">
                <div class="row small-row" id="storeList">
                    @foreach($stores as $store)
                    <div class="col-md-4 col-sm-6 col-sm-small">
                        <div class="detail-store">
                            <div class="mobi-block wrap-cart-seller">
                                <div  class="heart-like heart">
                                    <img src="{{ asset("vendor/buyer/Img/heart-2.svg") }}" alt="">
                                </div>
                                @if(!empty($store->proof_images) && isset($store->proof_images[0]))
                                    <img class="img-fluid" src="{{ getStoreProofImageUrl($store->proof_images[0]) }}" alt="">
                                @endif
                            </div>
                            <div class="wrap-name d-flex">
                                <img class="avatar web-block " src="{{ getStoreAvatarUrl($store->avatar_image) }}" alt="">
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
                            <p class="web-block truncate-overflow-three">{{$store->description}}</p>
                            <div class="row small-row img-store web-flex">
                                @if ($store->proof_images)
                                    @foreach($store->proof_images as $image)
                                        <div class="col-4 col-small">
                                            <img class="d-block w-100" src="{{ getStoreProofImageUrl($image) }}" alt="">
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <hr class="hidden-mobi">
                            <a href="{{ route('store.index', $store->slug) }}"><span class="text-center w-100 web-block">Visit Store</span></a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @if($stores->nextPageUrl())
            <a href="" class="button load-more web-block">Load More</a>
            @endif
        </div>
        <div class="mobi-block wrap-btn-filter">
            <a class="btn-customer Filter btn" href="#" role="button">
                <img src="{{ asset("vendor/buyer/Img/mdi_filter_list.svg") }}">
                <p>Filter</p>
            </a>
        </div>
    </div>

@endsection

@section('extra-footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
    <script type="text/javascript" src="{{ asset("vendor/buyer/script/individual.js") }}"></script>
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
                loadViewProduct(data);
            }).fail(function(jqXHR, ajaxOptions, thrownError){
                alert('No response from server');
            });
        }
        // load product in id featureProductsRow
        function loadViewProduct(data) {
            if(data.next_page_url == null){
                $('.load-more').hide();
            }
            htmlCode="";
            $.each( data.data, function( key, value ) {
                console.log(data.data);
                var storeAvatarPath = '{{STORE_AVATAR_PATH}}';
                var proof_images = value.proof_image ? JSON.parse(value.proof_image,true) : [];
                htmlCode += "<div class=\"col-md-4 col-sm-6 col-sm-small\">\n" +
                    "                        <div class=\"detail-store\">\n" +
                    "                            <div class=\"mobi-block wrap-cart-seller\">\n" +
                    "                                <div  class=\"heart-like heart\">\n" +
                    "                                    <img src=\""+config.img.wishlist+"\" alt=\"\">\n" +
                    "                                </div>\n" +
                    "                                <img class=\"img-fluid\" src=\""+config.routes.url+value.avatar_image+"\" alt=\"\">\n" +
                    "                            </div>\n" +
                    "                            <div class=\"wrap-name d-flex\">\n" +
                    "                                <img class=\"avatar web-block \" src=\""+config.routes.url+storeAvatarPath+value.avatar_image+"\" alt=\"\">\n" +
                    "                                <div class=\"warp-StoreName d-flex justify-content-between\">\n" +
                    "                                    <div class=\"name-seller\">\n" +
                    "                                        <h3 class=\"truncate-overflow-one mr-1\">"+value.name+"</h3>\n" +
                    "                                        <p class=\"central truncate-overflow-one\">"+value.address+"</p>\n" +
                    "                                    </div>\n" +
                    "                                    <div class=\"star d-flex\">\n" +
                    "                                        <h3>"+value.rating+"</h3>\n" +
                    "                                        <img src=\""+config.img.star+"\" alt=\"\">\n" +
                    "                                    </div>\n" +
                    "                                </div>\n" +
                    "                            </div>\n" +
                    "                            <p class=\"web-block truncate-overflow-three\">"+value.description+"</p>\n" +
                    "                            <div class=\"row small-row img-store web-flex\">\n";
                    var i = 0;
                    while (i < proof_images.length){
                        htmlCode += "                             <div class=\"col-4 col-small\">\n"+
                            "                                            <img class=\"d-block w-100\" src=\""+config.routes.url+proof_images[i]+"\" alt=\"\">\n"+
                            "                                        </div>\n";
                        i++;
                    }

                    htmlCode +=
                    "                            </div>\n" +
                    "                            <hr class=\"hidden-mobi\">\n" +
                    "                            <a href=\""+config.routes.store+value.slug+"\"><span class=\"text-center w-100 web-block\">Visit Store</span></a>\n" +
                    "                        </div>\n" +
                    "                    </div>";
            });

            $('#storeList').append(htmlCode);
        }
    </script>
@endsection