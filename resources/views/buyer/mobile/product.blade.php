@extends('buyer.mobile.layout')

@section('extra-header')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset("vendor/buyer/Css/pgwslider.css") }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
@endsection
@php
    $idReviews = $product->id;
@endphp
@section('content')
    <div id="header-1" class="header-bottom mobi-block mb-59px">
        <header class="header-cart-mobi heder-tab" style="margin-bottom: 0;padding-bottom: 16px!important;">
            <div class="container" style="padding: 0;">
                <div class="container wrap-mdi d-flex justify-content-between mb-30px align-items-center" style="padding-right: 24px;padding-left: 24px; ">
                    @include('buyer.mobile.partials.back-button')
                    <p class="link-product truncate-overflow-one" style="padding-right: 12px;">{{$product->name}}</p>
                    <div style="margin-right: -24px;">
                        @include('buyer.partials.mobile-cart-navbar')
                    </div>
                </div>
                <ul class="nav tab-mobi">
                    <li class="nav-item" style="margin-left: 20px;margin-right: 4px;">
                        <a class="card-title color-gray active" data-toggle="tab" href="#Overview"
                        style="padding-left: 24px;padding-right: 24px;">@lang('Overview')</a>
                    </li>
                    <li class="nav-item">
                        <a class="card-title color-gray" data-toggle="tab" href="#Reviews"
                           style="padding-left: 24px;padding-right: 24px;">@lang('Reviews')</a>
                    </li>
                </ul>
            </div>
        </header>
    </div>
    <!-- End Menu -->
    <!-- Bottom Bar Product Mobile-->
    <div class="cart-fixed ">
        <div class="container">
            <div class="row flex-row-reverse">
                <div class="col-4 collap-small"><a class="w-100 primary btn" onclick="buyNow()" href="#" role="button">@lang('Buy Now')</a></div>
                <div class="col-4 collap-small">
                    <a onclick="addToCart()" class="add-product d-flex">
                        <span>@lang('Add to Cart')</span>
                    </a>
                </div>
                <div class="col-4 collap-small"><a class="w-100 btn-gray btn" href="#" role="button">@lang('Ask Seller')</a></div>

            </div>
        </div>
    </div>
    <!-- End Bottom Bar -->
    <!-- Content -->
    <div class="content menu-fixed">
            <div class="detail-product">
                <div class="row small-row">
                    <div class="col-md-8 col-lg-7 col-sm-12 details-standard">
                        <!-- Review Modal -->
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
                        <!-- End Review Modal -->
                        <div class="tab-content">
                            <!-- Overview -->
                            <div class="tab-pane active overview-product" id="Overview" role="tabpanel" aria-labelledby="Overview">
                                @if(is_mobile())
                                    <div class="heart-2 d-flex heart-absolute" style="top: 20px;left: 20px;">
                                        <img onclick="addWhishlist(this, '{{ $product->id }}')"
                                             src="@if(!$isWishlist){{ asset("vendor/buyer/Img/heart-2.svg") }}@else {{ asset("vendor/buyer/Img/wishlist-checked.svg") }} @endif"
                                             alt="">
                                        <h3>{{$product->wishlist->count()}}</h3>
                                    </div>
                                @endif
                                <div class="siler-mobi ">
                                    <div id="productImageSlide" class="carousel slide" data-ride="carousel">
                                        <ul class="carousel-indicators">
                                            @if($product->images)
                                                @foreach($product->images as $index=>$image)
                                                    <li data-target="#productImageSlide" data-slide-to="{{$index}}"></li>
                                                @endforeach
                                            @endif
                                        </ul>
                                        <div class="carousel-inner">
                                            @foreach($product->images as $image)
                                                <div class="carousel-item @if ($loop->first) active @endif">
                                                    <img class="d-block w-100" src="{{ asset($image) }}" alt="" onerror="this.src='{{asset('img/not-found.jpg')}}'">
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <h1 class="product-subtitle" style="line-height: 121%">{{$product->name}}</h1>
                                <input name="idProductDetail" type="hidden" value="{{$product->id}}">
                                <span class="color-primary"><a href="{{ route('store.index',$product->store->slug) }}">{{$product->store->name}}</a></span>
                                <div class="star-peview-over d-flex " style="margin-bottom: 18px;">
                                    @if($product->rating_count > 0)
                                        <div class="star d-flex" data-toggle="modal" data-target="@if(Auth::check()) #received-star @else #modalLogin @endif">
                                            <?php
                                            showStars($product->rating_cache);
                                            ?>
                                        </div>
                                        <p class="rate" onclick="openTabReview()">{{$product->rating_cache}}</p>
                                        <p class="color-primary" onclick="openTabReview()">
                                            ({{$product->rating_count}} Reviews)
                                        </p>
                                    @endif
                                </div>

                                <form class="row" id="productOptions">
                                    @foreach($product->options as $option)
                                        <div class="form-group col-lg-4 col-md-6 col-sm-12" style="padding: 0;">
                                            <label style="margin-bottom: 10px;" class="color-gray">{{$option->name}}</label>
                                            <div>
                                                <select name="{{$option->name}}" class="selectpicker js-product-option-picker" title="Choose {{$option->name}}">
                                                    @foreach($option->values as $value)
                                                        <option value="{{$value->id}}">{{$value->name}}</option>
                                                    @endforeach
                                                </select>
                                                <img class="img-select" style="top: 50px;" src="{{ asset("vendor/buyer/Img/arrow-black.svg") }}" alt="">
                                            </div>
                                        </div>
                                    @endforeach

                                        <div class="col-lg-4 col-md-6 col-sm-6 only">
                                            <span class="link-product color-gray">Quantity</span>
                                            <div class="col-md-12 wrap-amount">
                                                <div class="d-flex amount-main amount-details" id="amountDetail" style="margin-left: 0!important;">
                                                    <div class="button-1 col main-reduction"><img src="{{ asset("vendor/buyer/Img/reduction.svg") }}" alt=""></div>
                                                    <input name="qtyProductDetail" type="text" class="input number numbar-main" value="1">
                                                    <div class="col button-2 main-add"><img src="{{ asset("vendor/buyer/Img/add.svg") }}" alt=""></div>
                                                </div>
                                            </div>
                                        </div>
                                </form>
                                    <div class="sale d-flex">
                                        <h3 class="product-title js-product-detail-origin-price  {{$product->options->count() > 0 ? 'd-none' : ''}}" style="margin-bottom: 32px;">
                                            @if ($product->options->count() === 0 && $product->variants->first()->has_discount)
                                                {{ $product->variants->first() ? $product->variants->first()->formatted_price : '' }}
                                            @endif
                                        </h3>
                                        <h2 class="product-title js-product-detail-present-price {{$product->options->count() > 0 ? 'd-none' : ''}}" style="margin-bottom: 32px">
                                            @if ($product->options->count() === 0)
                                                {{ $product->variants->first() ? $product->variants->first()->formatted_present_price : '' }}
                                            @endif
                                        </h2>

                                        <p class="sale-off text-center product-title js-product-detail-discount-amount  {{$product->options->count() > 0 ? 'd-none' : ''}}" style="margin-bottom: 32px;">
                                            @if ($product->options->count() === 0 && $product->variants->first()->has_discount)
                                                {{ $product->variants->first() ? $product->variants->first()->formatted_discount_amount : '' }}
                                            @endif
                                        </p>
                                    </div>
                                <div class="form-group note-seller">
                                    <label class="color-gray link-product">Notes To Seller</label>
                                    <input class="col-8 form-control h-48px" type="text" name="note" placeholder="S (4 pcs), M (10 pcs), L (6 pcs)">
                                </div>
                                <span class="link-product color-gray">Product Description</span>
                                <p class="description-text"><span id="showLess">{!! str_limit($product->description, 400, "") !!}</span>
                                    <span id="dots">...</span><span id="more">{!! $product->description !!}
                                    </span>
                                </p>
                                <span class="author read-more description-text" onclick="myFunction()" id="myBtn">Read More</span>
                            </div>
                            <!-- End Overview -->
                            <div class="tab-pane" id="Reviews" role="tabpanel" aria-labelledby="Reviews">
                                @if($percentageOfRatings)
                                    @include('buyer.partials.product.reviews-tab')
                                @else
                                    <div class="wrap-review">
                                        <p>Be the first to review this product.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
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
      const currencyMoney = currentProduct.price_range.currency;
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>
    <script type="text/javascript" src="{{ asset("vendor/buyer/script/product-detail.js") }}"></script>
    <script type="text/javascript" src="{{ asset("vendor/buyer/script/reviews.js") }}"></script>
    <script type="text/javascript">
        // url use in reviews.js
        const urlReviews = '{{route('product.reviews',$idReviews)}}';

    </script>
@endsection
