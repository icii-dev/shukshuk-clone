@extends('layouts.buyer')

@section('title', 'Shopping Cart')

@section('extra-header')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
    <style>
        .btn.disabled, .btn:disabled {
            opacity: .65 !important;
        }
    </style>
@endsection

@section('page-id', 'gray')
@section('content')
    <div class="content">
        <div class="container full-sm">
            <div class="row">
                <div class="col-3 col-collap web-block">
                    @include('buyer.partials.menu-left-user')
                </div>
                <div class="col-md-9 col-sm-12 col-collap">
                    <div class="container tab-pane">
                        <div class="col-md-12 col-sm-12 col-collap">
                            <div class="personal-information details-oder">
                                <ul class="nav">
                                    <li>
                                        <a  href="{{ route('users.orders') }}" class="back link-product" id="back-to" style="margin-bottom: 32px;">&larr; @lang('Back To My Order')</a>
                                    </li>
                                </ul>
                                <div class="payment payment-invoice payment-order">
                                    <div class="row no-gutters border-end">
                                        <div class="col-12">
                                            <div class="your-cart">
                                                <div class="head d-flex justify-content-between border-bottom">
                                                    <h3 class="title">{{$order->id}}</h3>
                                                    @php
                                                        $status = $order->payment->status;
                                                        switch ($status){
                                                            case ($status == 'FAILED' || $status == 'EXPIRED'):
                                                                $classOrderstatus = 'paid-status-error';
                                                                break;
                                                            case 'PENDING':
                                                                $classOrderstatus = 'paid-status-warning';
                                                                break;
                                                            case 'PAID':
                                                                $classOrderstatus = 'paid-status-paid';
                                                                break;
                                                            default:
                                                                $classOrderstatus = '';
                                                                break;
                                                        }
                                                    @endphp
                                                    <div class="paid {{$classOrderstatus}}">
                                                        @if($order->payment->status == \App\Model\Payment::STATUS_PENDING)
                                                            <span>@lang('To Pay')</span>
                                                        @else
                                                            <span>@lang($order->payment->status)</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="d-flex border-bottom justify-content-start">
                                                        <a href="{{ route('store.index', $order->store->slug) }}" style="padding-left: 27px;margin-right: 16px; margin-bottom: 16px" class="truncate-overflow-one">
                                                            <img src="{{asset('vendor/buyer/Img/store-icon.svg')}}" class="store-icon"/> {{$order->store->name}}</a>
{{--                                                    <div style="border-left: 1px solid #97A3A2;height: 16px;--}}
{{--                                                    margin-right: 16px;">--}}
{{--                                                    </div>--}}
{{--                                                    <div class="col-4" style="padding: 0">--}}
{{--                                                        <chat-button style="padding: 0" class="btn-chat-order tertiary-icon" store-id="{{$order->store->id}}" user-id="{{auth()->user() ? auth()->user()->id : 0}}" product-url="{{route('product.show', ['id' => $products[0]->slug])}}">--}}
{{--                                                            <img src="{{asset('vendor/buyer/svg/mdi_chat_bubble_outline.svg')}}" class="store-icon"/>@lang('Message Seller')</chat-button>--}}
{{--                                                    </div>--}}

                                                </div>
                                                @foreach($products as $product)
                                                    <div class="product d-flex justify-content-between row no-gutters border-bottom">
                                                        <div class="col-md-9 left d-flex"style="padding-left: 56px;padding-bottom: 44px">
                                                            <img class="img-your-cart" src="{{ asset($product->image) }}" alt="" onerror="this.src='{{asset('img/not-found.jpg')}}'">
                                                            <div class="detail-product-yourcart" style="margin-top: 10px;padding-left: 0">
                                                                <a href="{{route('product.show', $product->slug)}}" class="name-product truncate-overflow-one">{{$product->name}}</a>
                                                                <p class="link-product" style="margin-top: 8px;font-family: 'Inter';">Qty: {{$product->pivot->quantity}}</p>
                                                                <div class="d-flex text link-product" style="margin-top: 8px;">
                                                                    @foreach(json_decode($product->pivot->options) as $key=>$value)
                                                                        <p style="font-family: 'Inter';" @if ($loop->first) @else class="ml-3" @endif>{{$key}}: {{$value}}</p>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 rigfht-sale">
                                                            <h3 class="text-right" style="padding-right: 24px;">{{moneyFormat($product->pivot->subtotal)}}</h3>
                                                        </div>
                                                        <div class="link-product" style="padding-left:56px;padding-bottom:16px;margin-top:-37px;">Note: @if($product->pivot->note) {{$product->pivot->note}} @else - @endif</div>
                                                    </div>

                                                @endforeach
                                                <div class="custom-pad text-method d-flex justify-content-between">
                                                    <p class="color-gray link-product">@lang('Payment Method'):</p>
                                                    <p class="link-product" style="color: #222831">{{$order->payment->method}}</p>
                                                </div>
                                                <div class="custom-pad invoice d-flex justify-content-between">
                                                    <p class="color-gray">@lang('Duration'):</p>
                                                    <p class="link-product" style="color: #222831" style="padding-right: 24px;">
                                                        @php
                                                            use Carbon\Carbon;
                                                            $duration= $order->shipping_option;
                                                            switch ($duration){
                                                                  case 'REG':
                                                                       $date=Carbon::parse($order->created_at)->addDays(3)->format('d/m/Y');
                                                                       echo __('Regular (usually takes 2-3 days to arrive), expected arrive on').' '.$date.'';
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
                                                <div class="custom-pad text-method d-flex justify-content-between">
                                                    <p class="color-gray link-product">@lang('Payment fee'):</p>
                                                    <p class="link-product" style="color: #222831">{{moneyFormat($paymentFee)}}</p>
                                                </div>
                                                @if($order->billing_insurance_fee !=0)
                                                    <div class="custom-pad text-method d-flex justify-content-between">
                                                        <p class="color-gray link-product">@lang('Insurance fee'):</p>
                                                        <p class="link-product" style="color: #222831">{{moneyFormat($order->billing_insurance_fee)}}</p>
                                                    </div>
                                                @endif
                                                <div class="custom-pad text-method d-flex justify-content-between">
                                                    <p class="color-gray link-product">@lang('Delivery Fee'):</p>
                                                    <p class="link-product" style="color: #222831">{{moneyFormat($order->billing_shipping_fee)}}</p>
                                                </div>
                                                <div class="text-total d-flex justify-content-between custom-pad border-bottom" style="padding: 18px 0;">
                                                    <p class="color-gray link-product">@lang('Total Paid')</p>
                                                    <h3 class="text-right money-invoice card-title-product">
                                                        {{moneyFormat($BillingTotal)}}</h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 custom-pad">
                                            <div class="change d-flex justify-content-between">
                                                <p class="color-gray link-product">@lang('Shipping Address')</p>
                                            </div>
                                            <div>
                                                <p class="link-product" style="color: #222831;">{{$order->billing_name}} ({{$order->billing_phone}})</p>
                                            </div>
                                            <p class="p-invoice link-product" style="color: #222831;">
                                                    {{$order->billing_address}}, {{$order->district()->first()->name}},
                                                    {{$order->city()->first()->name}}, {{$order->province()->first()->name}}
                                            </p>
                                            <div class="col-12 custom-alert">
                                                <div><img src="{{asset('img/icon/alert-triangle.svg')}}"> @lang('Make sure there is a consignee at your shipping address')</div>
                                                <p class="description-text">@lang('If you miss delivery after 3 attempts, the item will be returned to the seller and you will be charged the delivery fee for the return of the item.')</p>
                                            </div>
                                        </div>

                                    </div>
                                    <div id="track-oder">
                                        <div class="d-flex justify-content-between"style="margin-bottom: 16px;margin-top: 16px">
                                            <div class="col-3">
                                                <p class="color-gray link-product">@lang('Tracking Number'):</p>
                                                <p>{{$orderTracking}}</p>
                                            </div>
                                            @if($order->status != \App\Model\Order::STATUS_CANCELLED)
                                                <div class="col-9 row d-flex justify-content-end" style="margin-right: 9px;">
                                                    @if($canCancelOrder)
                                                    <div class="col-4 col-small">
                                                        <a class="btn-customer tertiary-icon btn" style="border: 1px solid #EB4242;" href="{{route('order.cancel', $order->id)}}" role="button">
{{--                                                            <img src="{{ asset("img/mdi_help.svg") }}">--}}
                                                            <p class="link-product" style="color: #EB4242 !important;">@lang('Cancel your order')</p>
                                                        </a>
                                                    </div>
                                                    @endif
                                                    <div class="col-4 col-small">
                                                        <a class="btn-customer tertiary-icon btn" href="https://anteraja.id/id/tracking" role="button" target="_blank"
                                                        @if(!$orderTracking)
                                                            disabled
                                                                @endif
                                                        >
                                                            <img src="{{ asset("vendor/buyer/svg/truck.svg") }}">
                                                            <p class="link-product">@lang('Track Order')</p>
                                                        </a>
                                                    </div>
                                                    <div class="col-4 col-small">
                                                        @if($order->status == \App\Model\Order::STATUS_COMPLETED && !$isReview)
                                                            <button id="btnReview" class="btn-customer primary btn ml-2" data-toggle="modal" data-target=" #received-star ">@lang('Review Order')</button>
                                                        @elseif($order->status == \App\Model\Order::STATUS_SHIPPING)
                                                            <a class="d-flex btn-customer primary btn ml-2" href="{{route('order.received', $order->id)}}">
                                                                <img src="{{asset('img/check-circle.svg')}}" class="store-icon"/>
                                                                <p class="link-product" style="color: #FFFFFF;">@lang('Order Received')</p>
                                                            </a>
                                                        @else
                                                            <a class="link-product tertiary-icon d-flex btn-customer primary btn ml-2 btn-fade" href="#" disabled>
                                                                <img src="{{asset('img/check-circle.svg')}}" class="store-icon"/>
                                                                <p class="link-product" style="color: #FFFFFF;">@lang('Order Received')</p>
                                                            </a>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div id="check-circle" class="d-none">
                                    <div class="d-flex justify-content-center">
                                        <a class="btn-customer btn-icon completed btn col-3" href="#" role="button">
                                            <img src="{{ asset("vendor/buyer/Img/alert-success.svg") }}">
                                            <p>completed</p>
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
                                                <input type="hidden" name="idProductDetail" value="{{$product->id}}">
                        <input type="hidden" name="orderId" value="{{$order->id}}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-cancel btn col-3" data-dismiss="modal">Cancel</button>
                    <a onclick="submitRevew()" class="btn btn-secondary btn col-3" data-dismiss="modal">Submit</a>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('extra-footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>
    <script type="text/javascript" src="{{ asset("vendor/buyer/script/reviews.js") }}"></script>
    <script>
        const urlReviews = '{{route('product.reviews',$product->id)}}';
    </script>
@endsection
