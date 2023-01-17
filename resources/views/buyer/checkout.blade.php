@extends('layouts.buyer_payment_view')

@section('title', 'Shopping Cart')

@section('extra-header')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
@endsection
@section('page-id', 'gray')
@section('content')
    <div class="content">

        <div class="container">
            <checkout buy-now-cart="{{$isBuynow ? 1 : 0}}" ref-id="{{$ref}}"></checkout>
        </div>
    </div>
{{--    <div>--}}
{{--        @include('buyer.user_address._create-user-address-form')--}}
{{--    </div>--}}

{{--    <div class="tabs-container">--}}
{{--        <ul class="nav step hidden-mobi d-flex justify-content-center ">--}}
{{--            <li id="item-step-1" class="item-step nav-item detail-step-w20 detail-step step-active">--}}
{{--                <a class="item-step nav-link d-flex" data-toggle="tab" href="#step1">--}}
{{--                    <span class="d-block rounded-circle number">1</span>--}}
{{--                    <span class="text">@lang('Delivery Information')</span>--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <li id="item-step-2" class="item-step nav-item detail-step detail-step-w20">--}}
{{--                <a class="nav-link d-flex"  href="#step2">--}}
{{--                    <span class="d-block rounded-circle number">2</span>--}}
{{--                    <span class="text">Payment Method</span>--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <li id="item-step-3" class="item-step nav-item detail-step ">--}}
{{--                <a class="nav-link d-flex" href="#step3">--}}
{{--                    <span class="d-block rounded-circle number">3</span>--}}
{{--                    <span class="text">Complete Order</span>--}}
{{--                </a>--}}
{{--            </li>--}}
{{--        </ul>--}}
{{--        <div class="tab-content">--}}
{{--            <div id="step1" class="tab-pane active">--}}
{{--                <div class="container">--}}
{{--                    <div class="information">--}}
{{--                        <div class="row">--}}
{{--                            @if(!is_mobile())--}}
{{--                                <div class="col-xl-6 col-md-7 web-block">--}}
{{--                                    <div class="your-cart">--}}
{{--                                        <h2 class="title">Your Cart</h2>--}}
{{--                                        <div id="checkoutCart">--}}
{{--                                            @foreach($cartGrouped as $group)--}}
{{--                                                <!-- Store information -->--}}
{{--                                                <div>--}}
{{--                                                    <p>{{ Arr::get($group, '0.options.store.name') }}</p>--}}
{{--                                                </div>--}}
{{--                                                <!-- #Store information -->--}}

{{--                                                @foreach($group as $cartItem)--}}
{{--                                                    <div class="product d-flex justify-content-between">--}}
{{--                                                        <div class="left d-flex">--}}
{{--                                                            <img class="img-your-cart" src="{{ asset(Arr::get($cartItem, 'options.thumbnail')) }}" alt="">--}}
{{--                                                            <div class="detail-product-yourcart">--}}
{{--                                                                <a href="{{ route('product.show', Arr::get($cartItem, 'options.slug')) }}" class="name-product truncate-overflow-one">{{Arr::get($cartItem, 'name')}}</a>--}}
{{--                                                                <div class="col-lg-8 col-md-12 wrap-amount">--}}
{{--                                                                    <div class="d-flex amount-main amount-details">--}}
{{--                                                                        <div class="button-1 col main-reduction"><img src="{{ asset("vendor/buyer/Img/reduction.svg") }}" alt=""></div>--}}
{{--                                                                        <input name="rowId" type="hidden" value="{{$cartItem['rowId']}}">--}}
{{--                                                                        <input name="qty" type="text" class="input number numbar-main" value="{{$cartItem['qty']}}">--}}
{{--                                                                        <div class="col button-2 main-add"><img src="{{ asset("vendor/buyer/Img/add.svg") }}" alt=""></div>--}}
{{--                                                                    </div>--}}
{{--                                                                </div>--}}
{{--                                                                <div class="checkout-product-option">--}}
{{--                                                                    @foreach(Arr::get($cartItem, 'options.options', []) as $key=>$option)--}}
{{--                                                                        <span @if ($loop->first) @else class="ml-3" @endif>{{$key}}: {{$option}}</span>--}}
{{--                                                                    @endforeach--}}
{{--                                                                </div>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                        <div class="col-md-3 rigfht-sale">--}}
{{--                                                            @if(Arr::get($cartItem, 'options.discount', 0) > 0)--}}
{{--                                                                <p class="text-sale text-right">{{moneyFormat(Arr::get($cartItem, 'options.oldPrice'))}}</p>--}}
{{--                                                            @endif--}}
{{--                                                            <h3 class="text-right">{{moneyFormat(Arr::get($cartItem, 'price'))}}</h3>--}}
{{--                                                            @if(Arr::get($cartItem, 'options.discount', 0) > 0)--}}
{{--                                                                <p class="sale-off text-center">{{showDiscountValue(Arr::get($cartItem, 'options.discount'))}}</p>--}}
{{--                                                            @endif--}}
{{--                                                        </div>--}}

{{--                                                        <p>Ship how here????</p>--}}
{{--                                                    </div>--}}
{{--                                                @endforeach--}}
{{--                                            @endforeach--}}
{{--                                        </div>--}}
{{--                                        <div class="text-total d-flex justify-content-between">--}}
{{--                                            <p class="color-gray">All price are inclusive Tax 10%</p>--}}
{{--                                            <h3>Total</h3>--}}
{{--                                        </div>--}}
{{--                                        <h1 class="text-right" id="checkoutCartTotal">{{moneyFormat($cartTotal)}}</h1>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            @endif--}}
{{--                            <div class="col-md-5 col-sm-12 mt-4  mt-md-0">--}}
{{--                                <div class="from-information">--}}
{{--                                    <form id="form-step1" class="form-step1-1">--}}
{{--                                        <div class="form-group row no-gutters">--}}
{{--                                            <label class="col-12 col-md-6 person mb-text">Contact Person</label>--}}
{{--                                            <div class="col-12 col-md-6 wrap-check label-checkout">--}}
{{--                                                @if(Auth::user())--}}
{{--                                                    <label class="custom-control custom-checkbox">--}}
{{--                                                        <input name="saveContact" type="checkbox" class="custom-control-input" @if(isset($userAddress)) checked @endif>--}}
{{--                                                        <span class="custom-control-label"></span>--}}
{{--                                                        <span class="custom-text">Same As My Contact</span>--}}
{{--                                                    </label>--}}
{{--                                                @endif--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="group-input">--}}
{{--                                            <div class="form-group">--}}
{{--                                                <input id="name" name="recipient_name" type="text" class="form-control" placeholder="Recipient's name"--}}
{{--                                                       value="@if(isset($userAddress->recipient_name)){{$userAddress->recipient_name}}@endif">--}}
{{--                                            </div>--}}
{{--                                            <div class="form-group">--}}
{{--                                                <input id="phone" name="phone" type="text" class="form-control"  placeholder="Phone Number"--}}
{{--                                                       value="@if(isset($userAddress->phone)){{$userAddress->phone}}@endif">--}}
{{--                                            </div>--}}
{{--                                            <div class="form-group">--}}
{{--                                                <input name="note" type="text" class="form-control"  placeholder="Note (Optional)">--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="form-group row no-gutters">--}}
{{--                                            <label class="col-12 col-md-5 person mb-text">Shipping Address</label>--}}
{{--                                            <div class="col-12 col-md-7 wrap-check label-checkout">--}}
{{--                                                @if(Auth::user())--}}
{{--                                                    <label class="custom-control custom-checkbox">--}}
{{--                                                        <input name="saveAddress" type="checkbox" class="custom-control-input" @if(isset($userAddress)) checked @endif>--}}
{{--                                                        <span class="custom-control-label"></span>--}}
{{--                                                        <span class="custom-text">Same As Billing Address</span>--}}
{{--                                                    </label>--}}
{{--                                                @endif--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="form-group">--}}
{{--                                            <textarea id="address" name="address" class="form-control" placeholder="Address" rows="3">@if(isset($userAddress->addresses)){{$userAddress->addresses}}@endif</textarea>--}}
{{--                                        </div>--}}
{{--                                        <div class="form-group">--}}
{{--                                            <div class="wrap-select">--}}
{{--                                                <select class="selectpicker" title="Province" name="province" style="width:auto;" >--}}
{{--                                                    @foreach($provinces as $province)--}}
{{--                                                        <option value="{{$province->id}}"--}}
{{--                                                                @if(isset($userAddress->province_id) && $province->id == $userAddress->province_id)--}}
{{--                                                                selected--}}
{{--                                                                @endif--}}
{{--                                                        >{{$province->name}}</option>--}}
{{--                                                    @endforeach--}}
{{--                                                </select>--}}
{{--                                                <img class="img-select" src="{{ asset("vendor/buyer/Img/arrow-black.svg") }}" alt="">--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="form-group">--}}
{{--                                            <div class="wrap-select">--}}
{{--                                                <select class="selectpicker" title="Cities" id="cities" name="city" style="width:auto;">--}}
{{--                                                    @if(isset($userAddress->province_id))--}}
{{--                                                        @foreach(App\Model\AddressCity::where('province_id',$userAddress->province_id)->get() as $city)--}}
{{--                                                            <option value="{{$city->id}}"--}}
{{--                                                                    @if($city->id == $userAddress->regency_id)--}}
{{--                                                                    selected--}}
{{--                                                                    @endif--}}
{{--                                                            >{{$city->name}}</option>--}}
{{--                                                        @endforeach--}}
{{--                                                    @endif--}}
{{--                                                </select>--}}
{{--                                                <img class="img-select" src="{{ asset("vendor/buyer/Img/arrow-black.svg") }}" alt="">--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="form-group">--}}
{{--                                            <div class="wrap-select">--}}
{{--                                                <select class="selectpicker" title="District" id="districts" name="district" style="width:auto;">--}}
{{--                                                    @if(isset($userAddress->province_id))--}}
{{--                                                        @foreach(App\Model\AddressDistrict::where('regency_id',$userAddress->regency_id)->get() as $district)--}}
{{--                                                            <option value="{{$district->id}}"--}}
{{--                                                                    @if($district->id == $userAddress->district_id)--}}
{{--                                                                    selected--}}
{{--                                                                    @endif--}}
{{--                                                            >{{$district->name}}</option>--}}
{{--                                                        @endforeach--}}
{{--                                                    @endif--}}
{{--                                                </select>--}}
{{--                                                <img class="img-select" src="{{ asset("vendor/buyer/Img/arrow-black.svg") }}" alt="">--}}
{{--                                            </div>--}}
{{--                                        </div>--}}

{{--                                        <div class="delivery">--}}
{{--                                            <p>Delivery Method</p>--}}
{{--                                            <h2>Shukshuk Delivery</h2>--}}
{{--                                            <div class="wrap-select">--}}
{{--                                                <select class="selectpicker" title="Select Delivery" name="delivery">--}}
{{--                                                    <option value="">Select delivery methods</option>--}}
{{--                                                    @foreach(getListDeliveryUnit() as $deliveryId => $deliveryName)--}}
{{--                                                        <option value="{{$deliveryId}}">{{$deliveryName}}</option>--}}
{{--                                                    @endforeach--}}
{{--                                                </select>--}}
{{--                                                <img class="img-select" src="{{ asset("vendor/buyer/Img/arrow-black.svg") }}" alt="">--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <input type="hidden" name="isBuynow" value="{{$isBuynow}}">--}}
{{--                                        <a  id="btn-step1" class="btn-customer primary btn col-xl-5 col-sm-6 web-block" href="#step2"  href="#step2" >Continue</a>--}}
{{--                                    </form>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="mobi-block grand-total">--}}
{{--                    <div class="container">--}}
{{--                        <div class="d-flex justify-content-between in-line">--}}
{{--                            <p>Your Cart</p>--}}
{{--                            <h3>{{moneyFormat(Cart::instance('shopping')->subtotal())}}</h3>--}}
{{--                        </div>--}}
{{--                        <div class="d-flex justify-content-between in-line">--}}
{{--                            <p>Shipping Fee</p>--}}
{{--                            <h3>Free Shipping</h3>--}}
{{--                        </div>--}}
{{--                        <hr>--}}
{{--                        <div class="d-flex justify-content-between wrap-total">--}}
{{--                            <p class="color-gray tax">All price are inclusive Tax 10%</p>--}}
{{--                            <div>--}}
{{--                                <p class="text-right">Total</p>--}}
{{--                                <h2>{{moneyFormat($cartTotal)}}</h2>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <a id="btn-step1-mobi" class="btn-customer primary btn col-12 mobi-block" href="#step2" role="tab">Continue To Payment</a>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div id="step2" class="tab-pane fade">--}}
{{--                <div class="container">--}}
{{--                    <div class="payment payment-info">--}}
{{--                        <div class="row">--}}
{{--                            <div class="col-xl-6 col-md-7 web-block">--}}
{{--                                <div class="your-cart">--}}
{{--                                    <h2 class="title">Your Cart</h2>--}}
{{--                                    <div id="contentCartTab2">--}}
{{--                                        @foreach($cart as $cartItem)--}}
{{--                                            <div class="product d-flex justify-content-between">--}}
{{--                                                <div class="col-md-9 left d-flex">--}}
{{--                                                    <img class="img-your-cart" src="{{ asset($cartItem->options->thumbnail) }}" alt="">--}}
{{--                                                    <div class="detail-product-yourcart">--}}
{{--                                                        <a href="{{route('product.show', $cartItem->options->slug)}}" class="name-product truncate-overflow-one">{{$cartItem->name}}</a>--}}
{{--                                                        <p class="qty mt-4">Qty: {{$cartItem->qty}}</p>--}}
{{--                                                        <div class="d-flex text mt-4 option">--}}
{{--                                                            @foreach($cartItem->options->options as $key=>$value)--}}
{{--                                                                <p @if ($loop->first) @else class="ml-3" @endif>{{$key}}: {{$value}}</p>--}}
{{--                                                            @endforeach--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                                <div class="col-md-3 rigfht-sale">--}}
{{--                                                    <h3 class="text-right">{{moneyFormat($cartItem->total)}}</h3>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        @endforeach--}}
{{--                                    </div>--}}
{{--                                    <div class="text-method d-flex justify-content-between">--}}
{{--                                        <p>Delivery Method:</p>--}}
{{--                                        <p>Shukshuk Delivery</p>--}}
{{--                                    </div>--}}
{{--                                    <div class="text-method d-flex justify-content-between">--}}
{{--                                        <p>Duration:</p>--}}
{{--                                        <p>One-Day Shipping</p>--}}
{{--                                    </div>--}}
{{--                                    <div class="text-method d-flex justify-content-between">--}}
{{--                                        <p>Delivery Fee:</p>--}}
{{--                                        <p>free ship</p>--}}
{{--                                    </div>--}}
{{--                                    <div class="text-total d-flex justify-content-between">--}}
{{--                                        <div>--}}
{{--                                            <p class="color-gray">All price are inclusive Tax 10%</p>--}}
{{--                                            <div class="form-group d-flex promo-code">--}}
{{--                                                <input type="text" class="form-control code" id="formGroupExampleInput" placeholder="Promo Code">--}}
{{--                                                <a class="btn-customer btn-yourcart btn col-5" href="#" role="button">Apply</a>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="total-selectcart">--}}
{{--                                            <h3>Total</h3>--}}
{{--                                            <h1 class="text-right" id="checkoutCartTotalTab2">{{moneyFormat($cartTotal)}}</h1>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-md-5 col-sm-12 payment-right">--}}
{{--                                <div class="change d-flex justify-content-between">--}}
{{--                                    <p>Delivered to:</p>--}}
{{--                                    <a id="change-address" class="pain d-flex hidden-mobi" href="#step1" role="tab">--}}
{{--                                        <img src="{{ asset("vendor/buyer/Img/pain.svg") }}" alt="">--}}
{{--                                        <span>Change Shipping Address</span>--}}
{{--                                    </a>--}}
{{--                                </div>--}}
{{--                                <div class="payment-name" id="checkName">--}}

{{--                                </div>--}}
{{--                                <p class="p-payment" id="checkAddress">--}}

{{--                                </p>--}}
{{--                                <div class="mobi-block">--}}
{{--                                    <a id="change-address" class="pain d-flex" href="#step1" data-toggle="tab" role="tab">--}}
{{--                                        <img src="{{ asset("vendor/buyer/Img/pain.svg") }}" alt="">--}}
{{--                                        <span>Change Shipping Address</span>--}}
{{--                                    </a>--}}
{{--                                </div>--}}
{{--                                <div class="method web-block">--}}
{{--                                    <div class="form-group">--}}
{{--                                        <label>Complete Order:</label>--}}
{{--                                        <a id="btn-step2" class="btn-customer primary-icon btn col-xl-6 col-md-8" href="#step3"  role="tab">--}}
{{--                                            <img src="{{ asset("vendor/buyer/Img/block.svg") }}">--}}
{{--                                            <p>Pay Now</p>--}}
{{--                                        </a>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="mobi-block grand-total">--}}
{{--                    <div class="container">--}}
{{--                        <div class="d-flex justify-content-between in-line">--}}
{{--                            <p>Your Cart</p>--}}
{{--                            <h3>{{moneyFormat(Cart::instance('shopping')->subtotal())}}</h3>--}}
{{--                        </div>--}}
{{--                        <div class="d-flex justify-content-between in-line">--}}
{{--                            <p>Shipping Fee</p>--}}
{{--                            <h3>Free Shipping</h3>--}}
{{--                        </div>--}}
{{--                        <hr>--}}
{{--                        <div class="d-flex justify-content-between wrap-total">--}}
{{--                            <p class="color-gray tax">All price are inclusive Tax 10%</p>--}}
{{--                            <div>--}}
{{--                                <p class="text-right">Total</p>--}}
{{--                                <h2>{{moneyFormat($cartTotal)}}</h2>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="mobi-block">--}}
{{--                            <a id="paynow-mobile" class="btn-customer primary-icon btn col-12" href="#step3" data-toggle="tab" role="tab">--}}
{{--                                <img src="{{ asset("vendor/buyer/Img/block.svg") }}">--}}
{{--                                <p>Pay Now</p>--}}
{{--                            </a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div id="step3" class="tab-pane fade">--}}

{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}


{{--    <div class="tabs-container">--}}
{{--        <ul class="nav step hidden-mobi d-flex justify-content-center ">--}}
{{--            <li id="item-step-1" class="item-step nav-item detail-step-w20 detail-step step-active">--}}
{{--                <a class="item-step nav-link d-flex" data-toggle="tab" href="#step1">--}}
{{--                    <span class="d-block rounded-circle number">1</span>--}}
{{--                    <span class="text">@lang('Delivery Information')</span>--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <li id="item-step-2" class="item-step nav-item detail-step detail-step-w20">--}}
{{--                <a class="nav-link d-flex"  href="#step2">--}}
{{--                    <span class="d-block rounded-circle number">2</span>--}}
{{--                    <span class="text">Payment Method</span>--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <li id="item-step-3" class="item-step nav-item detail-step ">--}}
{{--                <a class="nav-link d-flex" href="#step3">--}}
{{--                    <span class="d-block rounded-circle number">3</span>--}}
{{--                    <span class="text">Complete Order</span>--}}
{{--                </a>--}}
{{--            </li>--}}
{{--        </ul>--}}
{{--        <div class="tab-content">--}}
{{--            <div id="step1" class="tab-pane active">--}}
{{--                <div class="container">--}}
{{--                    <div class="information">--}}
{{--                        <div class="row">--}}
{{--                            @if(!is_mobile())--}}
{{--                            <div class="col-xl-6 col-md-7 web-block">--}}
{{--                                <div class="your-cart">--}}
{{--                                    <h2 class="title">Your Cart</h2>--}}
{{--                                    <div id="checkoutCart">--}}
{{--                                        @foreach($cart as $cartItem)--}}
{{--                                            <div class="product d-flex justify-content-between">--}}
{{--                                                <div class="left d-flex">--}}
{{--                                                    <img class="img-your-cart" src="{{ asset($cartItem->options->thumbnail) }}" alt="">--}}
{{--                                                    <div class="detail-product-yourcart">--}}
{{--                                                        <a href="{{ route('product.show', $cartItem->options->slug) }}" class="name-product truncate-overflow-one">{{$cartItem->name}}</a>--}}
{{--                                                        <div class="col-lg-8 col-md-12 wrap-amount">--}}
{{--                                                            <div class="d-flex amount-main amount-details">--}}
{{--                                                                <div class="button-1 col main-reduction"><img src="{{ asset("vendor/buyer/Img/reduction.svg") }}" alt=""></div>--}}
{{--                                                                <input name="rowId" type="hidden" value="{{$cartItem->rowId}}">--}}
{{--                                                                <input name="qty" type="text" class="input number numbar-main" value="{{$cartItem->qty}}">--}}
{{--                                                                <div class="col button-2 main-add"><img src="{{ asset("vendor/buyer/Img/add.svg") }}" alt=""></div>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                        <div class="checkout-product-option">--}}
{{--                                                            @foreach($cartItem->options->options as $key=>$option)--}}
{{--                                                            <span @if ($loop->first) @else class="ml-3" @endif>{{$key}}: {{$option}}</span>--}}
{{--                                                            @endforeach--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                                <div class="col-md-3 rigfht-sale">--}}
{{--                                                    @if($cartItem->options->discount>0)--}}
{{--                                                        <p class="text-sale text-right">{{moneyFormat($cartItem->options->oldPrice)}}</p>--}}
{{--                                                    @endif--}}
{{--                                                    <h3 class="text-right">{{moneyFormat($cartItem->price)}}</h3>--}}
{{--                                                    @if($cartItem->options->discount>0)--}}
{{--                                                        <p class="sale-off text-center">{{showDiscountValue($cartItem->options->discount)}}</p>--}}
{{--                                                    @endif--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        @endforeach--}}
{{--                                    </div>--}}
{{--                                    <div class="text-total d-flex justify-content-between">--}}
{{--                                        <p class="color-gray">All price are inclusive Tax 10%</p>--}}
{{--                                        <h3>Total</h3>--}}
{{--                                    </div>--}}
{{--                                    <h1 class="text-right" id="checkoutCartTotal">{{moneyFormat($cartTotal)}}</h1>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            @endif--}}
{{--                            <div class="col-md-5 col-sm-12 mt-4  mt-md-0">--}}
{{--                                <div class="from-information">--}}
{{--                                    <form id="form-step1" class="form-step1-1">--}}
{{--                                        <div class="form-group row no-gutters">--}}
{{--                                            <label class="col-12 col-md-6 person mb-text">Contact Person</label>--}}
{{--                                            <div class="col-12 col-md-6 wrap-check label-checkout">--}}
{{--                                                @if(Auth::user())--}}
{{--                                                <label class="custom-control custom-checkbox">--}}
{{--                                                    <input name="saveContact" type="checkbox" class="custom-control-input" @if(isset($userAddress)) checked @endif>--}}
{{--                                                    <span class="custom-control-label"></span>--}}
{{--                                                    <span class="custom-text">Same As My Contact</span>--}}
{{--                                                </label>--}}
{{--                                                @endif--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="group-input">--}}
{{--                                            <div class="form-group">--}}
{{--                                                <input id="name" name="recipient_name" type="text" class="form-control" placeholder="Recipient's name"--}}
{{--                                                       value="@if(isset($userAddress->recipient_name)){{$userAddress->recipient_name}}@endif">--}}
{{--                                            </div>--}}
{{--                                            <div class="form-group">--}}
{{--                                                <input id="phone" name="phone" type="text" class="form-control"  placeholder="Phone Number"--}}
{{--                                                       value="@if(isset($userAddress->phone)){{$userAddress->phone}}@endif">--}}
{{--                                            </div>--}}
{{--                                            <div class="form-group">--}}
{{--                                                <input name="note" type="text" class="form-control"  placeholder="Note (Optional)">--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="form-group row no-gutters">--}}
{{--                                            <label class="col-12 col-md-5 person mb-text">Shipping Address</label>--}}
{{--                                            <div class="col-12 col-md-7 wrap-check label-checkout">--}}
{{--                                                @if(Auth::user())--}}
{{--                                                <label class="custom-control custom-checkbox">--}}
{{--                                                    <input name="saveAddress" type="checkbox" class="custom-control-input" @if(isset($userAddress)) checked @endif>--}}
{{--                                                    <span class="custom-control-label"></span>--}}
{{--                                                    <span class="custom-text">Same As Billing Address</span>--}}
{{--                                                </label>--}}
{{--                                                @endif--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="form-group">--}}
{{--                                            <textarea id="address" name="address" class="form-control" placeholder="Address" rows="3">@if(isset($userAddress->addresses)){{$userAddress->addresses}}@endif</textarea>--}}
{{--                                        </div>--}}
{{--                                        <div class="form-group">--}}
{{--                                            <div class="wrap-select">--}}
{{--                                                <select class="selectpicker" title="Province" name="province" style="width:auto;" >--}}
{{--                                                        @foreach($provinces as $province)--}}
{{--                                                            <option value="{{$province->id}}"--}}
{{--                                                                    @if(isset($userAddress->province_id) && $province->id == $userAddress->province_id)--}}
{{--                                                                    selected--}}
{{--                                                                    @endif--}}
{{--                                                            >{{$province->name}}</option>--}}
{{--                                                        @endforeach--}}
{{--                                                </select>--}}
{{--                                                <img class="img-select" src="{{ asset("vendor/buyer/Img/arrow-black.svg") }}" alt="">--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="form-group">--}}
{{--                                            <div class="wrap-select">--}}
{{--                                                <select class="selectpicker" title="Cities" id="cities" name="city" style="width:auto;">--}}
{{--                                                    @if(isset($userAddress->province_id))--}}
{{--                                                        @foreach(App\Model\AddressCity::where('province_id',$userAddress->province_id)->get() as $city)--}}
{{--                                                            <option value="{{$city->id}}"--}}
{{--                                                                    @if($city->id == $userAddress->regency_id)--}}
{{--                                                                    selected--}}
{{--                                                                    @endif--}}
{{--                                                            >{{$city->name}}</option>--}}
{{--                                                        @endforeach--}}
{{--                                                    @endif--}}
{{--                                                </select>--}}
{{--                                                <img class="img-select" src="{{ asset("vendor/buyer/Img/arrow-black.svg") }}" alt="">--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="form-group">--}}
{{--                                            <div class="wrap-select">--}}
{{--                                                <select class="selectpicker" title="District" id="districts" name="district" style="width:auto;">--}}
{{--                                                    @if(isset($userAddress->province_id))--}}
{{--                                                        @foreach(App\Model\AddressDistrict::where('regency_id',$userAddress->regency_id)->get() as $district)--}}
{{--                                                            <option value="{{$district->id}}"--}}
{{--                                                                    @if($district->id == $userAddress->district_id)--}}
{{--                                                                    selected--}}
{{--                                                                    @endif--}}
{{--                                                            >{{$district->name}}</option>--}}
{{--                                                        @endforeach--}}
{{--                                                    @endif--}}
{{--                                                </select>--}}
{{--                                                <img class="img-select" src="{{ asset("vendor/buyer/Img/arrow-black.svg") }}" alt="">--}}
{{--                                            </div>--}}
{{--                                        </div>--}}

{{--                                        <div class="delivery">--}}
{{--                                            <p>Delivery Method</p>--}}
{{--                                            <h2>Shukshuk Delivery</h2>--}}
{{--                                            <div class="wrap-select">--}}
{{--                                                <select class="selectpicker" title="Select Delivery" name="delivery">--}}
{{--                                                    <option value="">Select delivery methods</option>--}}
{{--                                                    @foreach(getListDeliveryUnit() as $deliveryId => $deliveryName)--}}
{{--                                                        <option value="{{$deliveryId}}">{{$deliveryName}}</option>--}}
{{--                                                    @endforeach--}}
{{--                                                </select>--}}
{{--                                                <img class="img-select" src="{{ asset("vendor/buyer/Img/arrow-black.svg") }}" alt="">--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <input type="hidden" name="isBuynow" value="{{$isBuynow}}">--}}
{{--                                        <a  id="btn-step1" class="btn-customer primary btn col-xl-5 col-sm-6 web-block" href="#step2"  href="#step2" >Continue</a>--}}
{{--                                    </form>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="mobi-block grand-total">--}}
{{--                    <div class="container">--}}
{{--                        <div class="d-flex justify-content-between in-line">--}}
{{--                            <p>Your Cart</p>--}}
{{--                            <h3>{{moneyFormat(Cart::instance('shopping')->subtotal())}}</h3>--}}
{{--                        </div>--}}
{{--                        <div class="d-flex justify-content-between in-line">--}}
{{--                            <p>Shipping Fee</p>--}}
{{--                            <h3>Free Shipping</h3>--}}
{{--                        </div>--}}
{{--                        <hr>--}}
{{--                        <div class="d-flex justify-content-between wrap-total">--}}
{{--                            <p class="color-gray tax">All price are inclusive Tax 10%</p>--}}
{{--                            <div>--}}
{{--                                <p class="text-right">Total</p>--}}
{{--                                <h2>{{moneyFormat($cartTotal)}}</h2>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <a id="btn-step1-mobi" class="btn-customer primary btn col-12 mobi-block" href="#step2" role="tab">Continue To Payment</a>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div id="step2" class="tab-pane fade">--}}
{{--                <div class="container">--}}
{{--                    <div class="payment payment-info">--}}
{{--                        <div class="row">--}}
{{--                            <div class="col-xl-6 col-md-7 web-block">--}}
{{--                                <div class="your-cart">--}}
{{--                                    <h2 class="title">Your Cart</h2>--}}
{{--                                    <div id="contentCartTab2">--}}
{{--                                        @foreach($cart as $cartItem)--}}
{{--                                            <div class="product d-flex justify-content-between">--}}
{{--                                                <div class="col-md-9 left d-flex">--}}
{{--                                                    <img class="img-your-cart" src="{{ asset($cartItem->options->thumbnail) }}" alt="">--}}
{{--                                                    <div class="detail-product-yourcart">--}}
{{--                                                        <a href="{{route('product.show', $cartItem->options->slug)}}" class="name-product truncate-overflow-one">{{$cartItem->name}}</a>--}}
{{--                                                        <p class="qty mt-4">Qty: {{$cartItem->qty}}</p>--}}
{{--                                                        <div class="d-flex text mt-4 option">--}}
{{--                                                            @foreach($cartItem->options->options as $key=>$value)--}}
{{--                                                                <p @if ($loop->first) @else class="ml-3" @endif>{{$key}}: {{$value}}</p>--}}
{{--                                                            @endforeach--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                                <div class="col-md-3 rigfht-sale">--}}
{{--                                                    <h3 class="text-right">{{moneyFormat($cartItem->total)}}</h3>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        @endforeach--}}
{{--                                    </div>--}}
{{--                                    <div class="text-method d-flex justify-content-between">--}}
{{--                                        <p>Delivery Method:</p>--}}
{{--                                        <p>Shukshuk Delivery</p>--}}
{{--                                    </div>--}}
{{--                                    <div class="text-method d-flex justify-content-between">--}}
{{--                                        <p>Duration:</p>--}}
{{--                                        <p>One-Day Shipping</p>--}}
{{--                                    </div>--}}
{{--                                    <div class="text-method d-flex justify-content-between">--}}
{{--                                        <p>Delivery Fee:</p>--}}
{{--                                        <p>free ship</p>--}}
{{--                                    </div>--}}
{{--                                    <div class="text-total d-flex justify-content-between">--}}
{{--                                        <div>--}}
{{--                                            <p class="color-gray">All price are inclusive Tax 10%</p>--}}
{{--                                                <div class="form-group d-flex promo-code">--}}
{{--                                                    <input type="text" class="form-control code" id="formGroupExampleInput" placeholder="Promo Code">--}}
{{--                                                    <a class="btn-customer btn-yourcart btn col-5" href="#" role="button">Apply</a>--}}
{{--                                                </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="total-selectcart">--}}
{{--                                            <h3>Total</h3>--}}
{{--                                            <h1 class="text-right" id="checkoutCartTotalTab2">{{moneyFormat($cartTotal)}}</h1>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-md-5 col-sm-12 payment-right">--}}
{{--                                <div class="change d-flex justify-content-between">--}}
{{--                                    <p>Delivered to:</p>--}}
{{--                                    <a id="change-address" class="pain d-flex hidden-mobi" href="#step1" role="tab">--}}
{{--                                        <img src="{{ asset("vendor/buyer/Img/pain.svg") }}" alt="">--}}
{{--                                        <span>Change Shipping Address</span>--}}
{{--                                    </a>--}}
{{--                                </div>--}}
{{--                                <div class="payment-name" id="checkName">--}}

{{--                                </div>--}}
{{--                                <p class="p-payment" id="checkAddress">--}}

{{--                                </p>--}}
{{--                                <div class="mobi-block">--}}
{{--                                    <a id="change-address" class="pain d-flex" href="#step1" data-toggle="tab" role="tab">--}}
{{--                                        <img src="{{ asset("vendor/buyer/Img/pain.svg") }}" alt="">--}}
{{--                                        <span>Change Shipping Address</span>--}}
{{--                                    </a>--}}
{{--                                </div>--}}
{{--                                <div class="method web-block">--}}
{{--                                    <div class="form-group">--}}
{{--                                        <label>Complete Order:</label>--}}
{{--                                        <a id="btn-step2" class="btn-customer primary-icon btn col-xl-6 col-md-8" href="#step3"  role="tab">--}}
{{--                                            <img src="{{ asset("vendor/buyer/Img/block.svg") }}">--}}
{{--                                            <p>Pay Now</p>--}}
{{--                                        </a>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="mobi-block grand-total">--}}
{{--                    <div class="container">--}}
{{--                        <div class="d-flex justify-content-between in-line">--}}
{{--                            <p>Your Cart</p>--}}
{{--                            <h3>{{moneyFormat(Cart::instance('shopping')->subtotal())}}</h3>--}}
{{--                        </div>--}}
{{--                        <div class="d-flex justify-content-between in-line">--}}
{{--                            <p>Shipping Fee</p>--}}
{{--                            <h3>Free Shipping</h3>--}}
{{--                        </div>--}}
{{--                        <hr>--}}
{{--                        <div class="d-flex justify-content-between wrap-total">--}}
{{--                            <p class="color-gray tax">All price are inclusive Tax 10%</p>--}}
{{--                            <div>--}}
{{--                                <p class="text-right">Total</p>--}}
{{--                                <h2>{{moneyFormat($cartTotal)}}</h2>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="mobi-block">--}}
{{--                            <a id="paynow-mobile" class="btn-customer primary-icon btn col-12" href="#step3" data-toggle="tab" role="tab">--}}
{{--                                <img src="{{ asset("vendor/buyer/Img/block.svg") }}">--}}
{{--                                <p>Pay Now</p>--}}
{{--                            </a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div id="step3" class="tab-pane fade">--}}

{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}


@endsection

@section('extra-footer')
            <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
            <script type="text/javascript" src="{{ asset('vendor/buyer/script/address.js') }}"></script>
            <script type="text/javascript" src="{{ asset("vendor/buyer/script/checkout.js") }}"></script>
@endsection
