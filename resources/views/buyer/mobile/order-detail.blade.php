@extends('buyer.mobile.layout')

@section('title', 'Shopping Cart')

@section('content')
{{--    <div id="header-2" class="header-bottom mobi-block">--}}
{{--        <header class="header-cart-mobi">--}}
{{--            <div class="container">--}}
{{--                <div class="container wrap-mdi d-flex tow-element">--}}
{{--                    <a id="back" href="{{ route('users.orders') }}">--}}
{{--                        <img src="{{ asset('vendor/buyer/Img/back.svg') }}" alt="">--}}
{{--                    </a>--}}
{{--                    <p class="text-center w-100">Order Details</p>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </header>--}}
{{--    </div>--}}
<div id="header-2" class="header-bottom mobi-block">
    <header class="header-cart-mobi" style="margin-bottom: 0;">
        <div class="container"  style="padding: 0 24px;">
            <div class="wrap-mdi d-flex tow-element">
                @include('buyer.mobile.partials.back-button')
                <p class="link-product text-center w-100" style="line-height: 21px;">Order Details</p>
            </div>
        </div>
    </header>
</div>
    <div class="content">
        <div class="container" style="padding-top: 20px;">
            <div class="d-flex justify-content-between">
                <div>
                    <p class="description-text color-gray">{{$order->id}}</p>
                    <p class="description-text color-gray">{{date("d-M-Y", strtotime($order->created_at))}}</p>
                </div>
                <div class="paid" style="margin-bottom: 0;padding: 5px 8px;">
                    <p class="product-subtitle" style="color: #30B6A4">PAID</p>
                </div>
            </div>
            <hr style="margin-bottom: 20px;">
            @foreach($products as $product)
            <div class="product d-flex justify-content-between mb-0">
                <div class="left d-flex">
                    <div class="wrap-img-invoice d-flex">
                        <span>1</span>
                        <img style="border-radius: 4px;" class="img-invoice" src="{{ asset($product->image) }}" alt="">
                    </div>
                    <div class="detail-product-yourcart detail-product-invoice" style="padding: 0;">
                        <span class="name-product color-primary truncate-overflow-one" style="margin-bottom: 5px;">{{ $product->name }}</span>
                        <h3 >{{priceDiscount($product->pivot->subtotal)}}</h3>
                        <p class="link-product" style="margin-top: 5px;font-family:Inter;">Qty: {{$product->pivot->quantity}}</p>
                    </div>
                </div>

            </div>
            <hr style="margin-top: 5px;margin-bottom: 10px;">
            @endforeach
        </div>
        <div class="col-12 payment-right" style="padding: 0 20px; margin-top: 25px;">
            <div class="d-flex justify-content-between " style="padding-bottom: 15px;">
                <p class="link-product" style="color: #222831;">Delivered to:</p>
            </div>
            <div class="payment-name mb-15px" style="margin-bottom: 15px">
                <p class="card-title-product" style="color: #222831;">{{$order->billing_name}}</p>
                <p class="link-product" >+{{$order->billing_phone}}</p>
            </div>
            <p class="p-invoice mb-30px description-text" style="max-width: 100%;margin-bottom: 30px;">
                {{$order->billing_address}}, {{$order->district()->first()->name}},
                {{$order->city()->first()->name}}, {{$order->province()->first()->name}}
            </p>
            <div class="method invoice" style="margin-bottom: 30px;">
                <p class="card-title-product" style="color: #222831;margin-bottom: 4px;">Delivery Method</p>
                <p class="description-text">Shukshuk Delivery</p>
            </div>
            <div class="invoice" style="margin-bottom: 30px;">
                <p class="card-title-product" style="color: #222831;margin-bottom: 4px;">Duration:</p>
                <p class="description-text">
                    @php
                        use Carbon\Carbon;
                        $duration= $order->shipping_option;
                        switch ($duration){
                              case 'REG':
                                   $date=Carbon::parse($order->created_at)->addDays(3)->format('d/m/Y');
                                   echo __('Regular (usually takes 2-3 days to arrive), expected arrive on').$date.'';
                                   break;
                              case 'SD':
                                   echo 'Same Day '.'('.$order->created_at->format('d/m/Y').')'.' package will arrive in the same day';
                                   break;
                              case 'ND':
                                  $nextDate=Carbon::parse($order->created_at)->addDay()->format('d/m/Y');
                                   echo 'Next Day '.'('.$nextDate.')'.' package will arrive tomorrow';
                                   break;
                              default:
                                   break;
                        }
                    @endphp
                </p>
            </div>
            <div class="mb-18px">
                <p class="card-title-product" style="color: #222831;margin-bottom: 4px;">Payment Method:</p>
                <p class="description-text" style="padding-bottom: 18px;">{{$order->payment->method}}</p>
            </div>
        </div>
        <p style="margin-bottom: 0;"></p>
        <div class="mobi-block order-detail-cart"style="background: #F6F8F8;">
            <div class="container" style="padding-top: 16px;">
                <div class="d-flex justify-content-between in-line">
                    <p class="link-product">Your Cart</p>
                    <h3 class="color-black card-title-product">{{moneyFormat($order->billing_subtotal)}}</h3>
                </div>
                <div class="d-flex justify-content-between in-line">
                    <p class="link-product">Shipping Fee</p>
                    <h3 class="color-black card-title-product">{{moneyFormat($order->billing_shipping_fee)}}</h3>
                </div>
                <div class="d-flex justify-content-between in-line">
                    <p class="link-product">Payment Fee</p>
                    <h3 class="color-black card-title-product">{{moneyFormat($paymentFee)}}</h3>
                </div>
                @if($order->billing_insurance_fee !=0)
                    <div class="d-flex justify-content-between in-line">
                        <p class="link-product">Insurance Fee</p>
                        <h3 class="color-black card-title-product">{{moneyFormat($order->billing_insurance_fee)}}</h3>
                    </div>
                @endif
                <hr style="margin-bottom: 20px;">
                <div class="d-flex justify-content-between wrap-total mb-24px">
                    <p class="link-product tax" style="color: #222831;">All price are inclusive Tax 10%</p>
                    <div>
                        <p class="link-product text-right">Total</p>
                        <h2>{{moneyFormat($BillingTotal)}}</h2>
                    </div>
                </div>
                <div id="track-oder" class="row small-row" style="padding-bottom: 20px;">
                    <div class="col-12 col-small d-flex justify-content-between" style="margin-top: 36px;">
                        <button id="order" class="d-flex justify-content-center btn-customer primary btn ml-2" role="button" disabled>
                            <img src="{{asset(("vendor/buyer/svg/mdi_check_circle.svg"))}}" class="store-icon"
                                 style="margin-right: 10px;margin-top: -2px;">
                            <p class="link-product" style="color: #FFFFFF;">Order Received</p>
                        </button>
                    </div>
                    <br/>
                    <div class="col-12 col-small d-flex justify-content-between">
                        <a class="btn-customer tertiary-icon btn" href="#" role="button">
                            <img src="{{ asset("vendor/buyer/Img/icon-strucking.svg") }}"style="margin-right: 5px">
                            <p>Track Order</p>
                        </a>
                    </div>
                    <br/>
                    <div class="col-12 col-small d-flex justify-content-between">
                        <a class="btn-customer tertiary-icon btn" href="#" role="button">
                            <img src="{{ asset("img/mdi_help.svg") }}">
                            <p>Need Help</p>
                        </a>
                    </div>
                    <br/>
                </div>
                <div id="check-circle" class="d-none">
                    <div class="d-flex justify-content-center d-none">
                        <div class="col-6">
                            <a class="btn-customer btn-icon completed btn" href="#" role="button" >
                                <img src="{{ asset("vendor/buyer/Img/mdi_check_circle.svg") }}" style="margin-right: 5px">
                                <p>completed</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('import_js')
@endsection
