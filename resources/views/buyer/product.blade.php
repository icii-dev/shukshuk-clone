@extends('layouts.buyer')

@section('title', 'Shopping Cart')

@section('extra-header')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset("vendor/buyer/Css/pgwslidershow.css") }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
    <style>
        .card {
            margin-bottom: 15px;
        }

        .icon-action {
            margin-top: 5px;
            float: right;
            font-size: 80%;
        }
        .list-group-item{
            border-top: 0px;
            border-left: 0px;
            border-right: 0px;
            padding: 0px;
        }
        .list-group-item .title {
            margin-top: 5px;
            margin-bottom: 12px;
            font-weight: 600;
            padding: 0px;
        }
        .filter-content{
            padding-bottom: 20px;
        }
    </style>
@endsection
@php
    $idReviews = $product->id;
@endphp
@section('content')

    <div class="content menu-fixed">
        <div class="container web-block">
            <div class="row d-flex justify-content-between cart-fixed align-items-center">
                <div class="text col">
                    <p class="link-product">{{$product->name}}</p>
                </div>
                <div class="button col-xl-8 col-md-8">
                    <div class="row small-row float-right">
{{--                        <div class="collap-small" style="padding-right: 0">--}}
{{--                            <chat-button class="btn-customer tertiary-icon btn" store-id="{{$product->store->id}}" product-url="{{route('product.show', ['id' => $product->slug])}}" user-id="{{auth()->user() ? auth()->user()->id : 0}}" >--}}
{{--                                <img src="{{ asset('vendor/buyer/svg/mdi_email.svg') }}">--}}
{{--                                <p>@lang('Message Seller')</p>--}}
{{--                            </chat-button>--}}
{{--                        </div>--}}
                        <div class="collap-small" style="padding-right: 0">
                            <a class="btn-customer tertiary-icon btn" href="javascript:history.go(0)" role="button" onclick="addWhishlist(this, '{{ $product->id }}')">
                                <img src="@if(!$isWishlist){{ asset("vendor/buyer/Img/heart-2.svg") }}@else {{ asset("vendor/buyer/Img/wishlist-checked.svg") }} @endif"
                                     alt="">
                                <p>@if(!$isWishlist)@lang('Add to Wishlist') @else @lang('Remove Wishlist') @endif</p>
                            </a>
                        </div>
                        <div class="collap-small" style="padding-right: 0">
                            <a onclick="addToCart()" id="addToCart" class="add-card-product btn">
                                <img src="{{ asset("vendor/buyer/Img/cart-primary.svg") }}" alt="">
                                <span style="padding-left: 4px;">@lang('Add to Cart')</span>
                            </a>
                        </div>
                        <div class="collap-small" style="padding-right: 0">
                            <a class="btn-customer primary btn" onclick="buyNow(event)" href="#" role="button">@lang('Buy Now')</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="cart-fixed mobi-block">
            <div class="container">
                <div class="row flex-row-reverse">
                    <div class="col-4 collap-small"><a class="w-100 primary btn" onclick="buyNow()" href="#" role="button">Buy Now</a></div>
                    <div class="col-4 collap-small">
                        <a onclick="addToCart()" class="add-product d-flex">
                            <span>Add to Cart</span>
                        </a>
                    </div>
                    <div class="col-4 collap-small"><a class="w-100 btn-gray btn" href="#" role="button">Ask Seller</a></div>

                </div>
            </div>
        </div>
        <div class="container">
            <nav class="web-block" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="link-product" href="{{route('home')}}">Home</a></li>
                    <li class="breadcrumb-item"><a class="link-product" href="{{route('product.category', [$product->categories[0]->slug, 0 , 0])}}">{{$product->categories[0]->name}}</a></li>
                    {{--                    <li class="breadcrumb-item active" aria-current="page">Tea</li>--}}
                </ol>
            </nav>
            <div class="detail-product">

                <div class="row small-row">
                    <div class="col-md-4 detail">
                        <ul class="pgwSlider">
                            @if ($product->images)
                                @foreach($product->images as $image)
                                    @if(!file_exists(public_path($image)))
                                        @continue;
                                    @endif
                                    <li><img style="max-width: 360px" src="{{ asset($image) }}" onerror="this.src='public/img/no-photo.jpg'"></li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                    <div class="col-md-8 col-lg-7 col-sm-12 details-standard">
                        <ul class="nav tab-product" style="padding-bottom: 14px;border-bottom: 1px solid #E4E8E8;">
                            <li class="nav-item " id="click-Overview">
                                <a class="card-title active color-gray" data-toggle="tab" href="#Overview">@lang('Overview')</a>
                            </li>
                            <li class="nav-item">
                                <a class="card-title color-gray" data-toggle="tab" href="#Reviews">@lang('Reviews')</a>
                            </li>
                        </ul>
                        <div class="modal modal-star fade" id="received-star" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <h2 class="text-center mb-3">Order Received Confirmation</h2>
                                        <p class="text-center mb-1">Help us improve our services by rating this product:</p>
                                        <div id="rateYo" class="w-100 justify-content-center d-flex mb-3"></div>
                                        <div class="form-group">
                                            <label class="color-gray">Billing Address</label>
                                            <textarea name="commentOfRating" class="form-control" placeholder="This product is so good and the seller is very very recommended." rows="5"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <img id="showImageReview" class="w-50 mb-1">
                                            <button type="button" class="btn-customer btn-blue btn col-12" onclick="openfileDialog();">Upload Product Image</button>
                                            <input class="d-none" type="file" id="reviewImages" name="images" title="Load File">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn-cancel btn col-3" data-dismiss="modal">Cancel</button>
                                        <a onclick="submitRevew()" class="btn btn-secondary btn col-3" data-dismiss="modal">Submit</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane active overview-product" id="Overview" role="tabpanel" aria-labelledby="Overview">
                                @if(is_mobile())
                                    <div class="heart-2 d-flex heart-absolute">
                                        <img onclick="addWhishlist(this, '{{ $product->id }}')"
                                             src="@if(!$isWishlist){{ asset("vendor/buyer/Img/heart-2.svg") }}@else {{ asset("vendor/buyer/Img/wishlist-checked.svg") }} @endif"
                                             alt="">
                                        <h3>{{$product->wishlist->count()}}</h3>
                                    </div>
                                @endif

                                <h1 class="card-title">{{$product->name}}</h1>
                                <input name="idProductDetail" type="hidden" value="{{$product->id}}">
                                <span class="color-primary"><a href="{{ route('store.index',$product->store->slug) }}">{{$product->store->name}}</a></span>
                                <div class="star-peview-over d-flex mb-2 mt-8px">
                                    @if($product->rating_count > 0)
                                        <div class="star d-flex" data-toggle="modal" data-target="@if(Auth::check()) #received-star @else #modalLogin @endif">
                                            <?php
                                            showStars($product->rating_cache);
                                            ?>
                                        </div>
                                        <p class="rate" onclick="openTabReview()">{{$product->rating_cache}}</p>
                                        <p class="color-primary mr-12px" onclick="openTabReview()">
                                            ({{$product->rating_count}} Reviews)
                                        </p>
                                    @endif
                                    <div class="row">
                                        <div class="ml-12px">
                                            <span class="color-gray" style="font-size: 16px">&bull;</span>
                                            <span class="color-black-text">
                                                <span id="itemsLeft">
                                                    @if(empty($product->options->count())) 1000 @endif
                                                </span>
                                                items left
                                            </span>
                                        </div>
                                        @if($product->sold>0)
                                        <div class="ml-12px">
                                            <span class="color-gray" style="font-size: 16px">&bull;</span>
                                            <span class="color-black-text">{{$product->sold}} products sold</span>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                {{--price ans sale--}}
                                <div class="sale d-flex">
                                    <h3 class="product-title js-product-detail-origin-price {{$product->discount > 0 ? 'd-none' : ''}}" style="margin-bottom: 32px;">
                                        @if ($product->options->count() === 0 && $product->variants->first()->has_discount)
                                            {{ $product->variants->first() ? $product->variants->first()->formatted_price : '' }}
                                        @endif
                                    </h3>
                                    <h2 class="product-title js-product-detail-present-price" style="margin-bottom: 32px">
                                        {!! $product->price_range['present_range'] !!}
                                    </h2>
                                    @if ($product->options->count() === 0 && $product->variants->first()->has_discount)
                                    <p class="sale-off text-center product-title js-product-detail-discount-amount" style="margin-bottom: 32px;">
                                        {{ $product->variants->first() ? $product->variants->first()->formatted_discount_amount : '' }}
                                    </p>
                                    @endif
                                </div>
                                    {{--price ans sale--}}
                                <form id="productOptions">
                                    <div class="row">
                                        @foreach($product->options as $option)
                                            <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                                <label style="margin-bottom: 0" class="color-gray">{{$option->name}}</label>
                                                <div class="wrap-select">
                                                    <select name="{{$option->name}}" class="selectpicker js-product-option-picker" title="Choose {{$option->name}}">
                                                        @foreach($option->values as $value)
                                                            <option value="{{$value->id}}">{{$value->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <img class="img-select" src="{{ asset("vendor/buyer/Img/arrow-black.svg") }}" alt="">
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-4 only">
                                            <div class="form-group col-md-12 wrap-amount">
                                                <label class="link-product color-gray">@lang('Quantity')</label>
                                                <div class="d-flex amount-main amount-details" id="amountDetail">
                                                    <div class="button-1 col main-reduction"><img src="{{ asset("vendor/buyer/Img/reduction.svg") }}" alt=""></div>
                                                    <input name="qtyProductDetail" type="text" class="input number numbar-main" value="1">
                                                    <div class="col button-2 main-add"><img src="{{ asset("vendor/buyer/Img/add.svg") }}" alt=""></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-8 note-seller">
                                            <label class="color-gray link-product">@lang('Notes To Seller')</label>
                                            <input class="col-8 form-control h-48px" type="text" name="note" placeholder="S (4 pcs), M (10 pcs), L (6 pcs)">
                                        </div>
                                    </div>

                                    <div class="row d-none" id="shippingFeeContent">
                                        <div class="form-group col-lg-4 col-md-6">
                                            <label class="color-gray">@lang('Shipping Availability')</label>
                                            <div class="wrap-select">
                                                <select name="shipping-district"
                                                        class="selectpicker"
                                                        title="">
                                                </select>
                                                <img class="img-select" src="{{ asset("vendor/buyer/Img/arrow-black.svg") }}" alt="">
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-4 col-md-6">
                                            <label class="color-gray">@lang('Shipping Fee')</label>
                                            <p id="shippingFee" class="mt-12px"></p>
                                        </div>
                                    </div>
                                </form>

                                    <div class="list-group filter-wrap">
                                        <article class="list-group-item">
                                            <div class="">
                                                <a href="#" data-toggle="collapse" data-target="#collapse1" aria-expanded="true" class="">
                                                    <i class="icon-action fa fa-chevron-down"></i>
                                                    <h6 class="color-gray link-product">@lang('Product Description')</h6>
                                                </a>
                                            </div>
                                            <div class="filter-content collapse" id="collapse1">
                                                {!! $product->description !!}
                                            </div> <!-- collapse -filter-content  .// -->
                                        </article>
                                    </div> <!-- card.// -->

                                    <div class="list-group filter-wrap">
                                        <article class="list-group-item mt-12px">
                                            <div class="">
                                                <a href="#" data-toggle="collapse" data-target="#collapse2" aria-expanded="true" class="">
                                                    <i class="icon-action fa fa-chevron-down"></i>
                                                    <h6 class="color-gray link-product">@lang('Product Weight & Dimension')</h6>
                                                </a>
                                            </div>
                                            <div class="filter-content collapse" id="collapse2">
                                                <p>Weight: {{$product->weight}} grams</p>
                                                <p>Dimension: {{$product->length}} x {{$product->width}} x {{$product->height}} cm</p>
                                            </div> <!-- collapse -filter-content  .// -->
                                        </article>
                                    </div> <!-- card.// -->
                            </div>
                            <div class="tab-pane" id="Reviews" role="tabpanel" aria-labelledby="Reviews">
                                @if($percentageOfRatings)
                                    @include('buyer.partials.product.reviews-tab')
                                @else
                                    <div class="wrap-review">
                                        <p>Be the first to review this product.</p>
                                        <p>If you have purchased this product, please go to your order and rate it</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="heart-2 d-flex heart-absolute">
                    <img onclick="addWhishlist(this, '{{ $product->id }}')"
                         src="@if(!$isWishlist){{ asset("vendor/buyer/Img/heart-2.svg") }}@else {{ asset("vendor/buyer/Img/wishlist-checked.svg") }} @endif"
                         alt="">
                    <h3>{{$product->wishlist->count()}}</h3>
                </div>
            </div>
            <div class="related-product related-product-standard web-block">
                <p class="product-subtitle" style="margin-bottom: 24px">@lang('Related Product')</p>
                <div class="row">
                    @foreach($mightAlsoLike as $mightAlsoLikeProduct)
                        @include('buyer.partials.product.item-product-list', ['product' => $mightAlsoLikeProduct])
                    @endforeach
                    {{--                    end card view--}}
                </div>
            </div>
        </div>
    </div>

@endsection
@section('footer-custom','think-gray')
@section('extra-footer')
    <script>
        const currentProduct = @json($product);
        const currentProductVariants = @json($product->variants);
        console.log(currentProduct);
        const currencyMoney = currentProduct.price_range.currency;
    </script>
    <script type="text/javascript" src="{{mix('js/product-detail.js')}}"></script>
    <script type="text/javascript">
        // url use in reviews.js
        const urlReviews = '{{route('product.reviews',$idReviews)}}';

        $(document).ready(function() {
            window.pgwSlider = $('.pgwSlider').pgwSlideshow(
                {
                    displayControls: false
                }
            );
        });
    </script>
    <script type="text/javascript">
        $.ajax({
            type: 'POST',
            url: "/ajax/product/get-shipping-fee",
            async: true,
            dataType: 'json',
            data: {
                "storeId": "{{$product->store->id}}",
                "weight": "{{$product->weight}}"
            },
            success: function(data){
                if(data){
                    $('#shippingFeeContent').removeClass('d-none');
                    $('select[name=shipping-district]').append('<option value="'+data.districtName+'">'+data.districtName+'</option>');
                    $('select[name=shipping-district]').selectpicker('refresh');
                    $('#shippingFee').html(data.fee)
                    console.log(data);
                }

            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                var error = JSON.parse(XMLHttpRequest.responseText);
                error.errors.forEach(function (status) {
                    $.notify({
                        content :status,
                        alertType: "alert-warning",
                        timeout: 8000
                    });
                });
            }
        });
    </script>
    <script>
        $(document).on('click', '.list-group-item', function(e){
            var $this = $(this);
            if($this.find('i').hasClass('fa-chevron-up')) {
                $this.find('i').removeClass('fa-chevron-up').addClass('fa-chevron-down');
            } else {
                $this.find('i').removeClass('fa-chevron-down').addClass('fa-chevron-up');
            }
        })
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>
{{--    <script type="text/javascript" src="{{ asset("vendor/buyer/script/pgwslider.js") }}"></script>--}}
{{--    <script type="text/javascript" src="{{ asset("vendor/buyer/script/product-detail.js") }}"></script>--}}
{{--    <script type="text/javascript" src="{{ asset("vendor/buyer/script/reviews.js") }}"></script>--}}

@endsection
