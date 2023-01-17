@php
    $store = auth()->user()->store;
@endphp
@foreach($paged->items() as $order)
    <div class="order-item">
        <div class="order-item-header d-flex justify-content-between">
            <div class="d-flex align-self-end">
                <p class="mr-24px">{{ getOrderId($order) }}</p>
                <p class="color-gray">{{ presentDate($order->created_at) }}</p>
            </div>
            <div class="d-flex flex-column justify-content-between">
                @if ($order->status === \App\Model\Order::STATUS_NEW || $order->status === \App\Model\Order::STATUS_INPROCESS)
                    <div class="d-flex">
                        <a class="btn-cancel btn btn-small js-change-order-to-cancelled" href="#" data-url="{!! route('seller.order.ajax_change_status_to_in_cancelled', ['id' => getOrderId($order)]) !!}">@lang('Reject')</a>
                        @if($order->payment->status == 'PAID')
                            <a data-toggle="modal" data-target="#modalProceed" class="secondary btn btn-small ml-8px js-change-order-to-in-process" href="#" data-url="{!! route('seller.order.ajax_change_status_to_in_process', ['id' => getOrderId($order)]) !!}" data-order="{{ json_encode($order->jsonSerialize()) }}" >@lang('Proceed')</a>
                            @if($store->DC)
                            <a data-toggle="modal" data-target="#modalDC" class="js-proceed-order-by-dc primary btn btn-small ml-8px" style="color: #ffffff"
                               data-url="{!! route('seller.order.ajax_proceed_by_dc', ['id' => getOrderId($order)]) !!}"
                            >
                                DC</a>
                            @endif
                        @else
                            <a class="mr-10px btn btn-small">@lang('Wait for pay')</a>
                        @endif
                    </div>
                @elseif ($order->status === \App\Model\Order::STATUS_SCHEDULE_PICK_UP || $order->status === \App\Model\Order::STATUS_COMPLETED)
                    <div class="d-flex">
                        <span class="color-gray">Booking ID:&nbsp;</span>
                        <span>{{$order->orderShipping->shipping_referrer_id ?? 'by DC service'}}</span>
                        <span class="color-gray ml-16px">Pick-Up Time:&nbsp;</span>
                        @if(
                                isset($order->orderShipping->expect_start)
                                && isset($order->orderShipping->expect_finish)
                            )
                            @php
                                $startDay = date('Y-m-d', strtotime($order->orderShipping->expect_start));
                                $today = date("Y-m-d");
                                $tomorrow = date('Y-m-d', strtotime($today. ' +1 days'));
                                $isTomorrow = ($tomorrow == $startDay) ? true : false;
                            @endphp
                            @if($isTomorrow)
                                <span class="color-red">Tomorrow</span>
                            @else
                                <span class="color-red">{{date("h:i",strtotime($order->orderShipping->expect_start))}}</span>
                                <span>&nbsp;-&nbsp;</span>
                                <span class="color-red">{{date("h:i",strtotime($order->orderShipping->expect_finish))}}</span>
                            @endif
                        @endif
                    </div>
                @endif
            </div>
        </div>
        <div class="order-item-body">
            @foreach($order->products as $product)
                <div class="my-order-product d-flex align-items-start">
                    <img class="d-block mr-3 order-product-thumbnail" src="{{ asset($product->image) }}" onerror="this.src='{{asset('img/not-found.jpg')}}'" alt="">
                    <div class="wrap-information d-flex justify-content-between w-100">
                        <div>
                            <a href="{{route('product.show', $product->slug)}}">{{$product->name}}</a>

                            @foreach(json_decode($product->pivot->options) as $key=>$value)
                                <p>{{$key}}: {{$value}}</p>
                            @endforeach
                            <p>Quantity: {{$product->pivot->quantity}}</p>
                        </div>
                        <div class="d-flex align-items-start">
{{--                            <span class="color-gray">Price: </span>--}}
                            <p class="ml-1"> {{moneyFormat($product->pivot->subtotal)}}</p>
                        </div>

                    </div>
                </div>
            @endforeach
            <div style="margin-top: 8px">Note: @if($product->pivot->note) {{$product->pivot->note}} @else - @endif</div>
        </div>
        <div class="order-item-content d-flex justify-content-between">
            <span class="">Total Paid</span>
            <span class="color-black text-medium-18">{{moneyFormat($order->payment->paid_amount)}}</span>
        </div>
        @php
            $orderArray= $order->jsonSerialize();
            $detailAddress = $orderArray['billing_address'] .
                                ", " . $orderArray['billing_district'] .
                                ", " . $orderArray['billing_city'] .
                                ", " . $orderArray['billing_province'] ;
        @endphp
        <div class="order-item-content">
           <p class="color-gray">Buyer:</p>
            <p>{{$order->billing_name}} ({{$order->billing_phone}})</p>
            <p>{{$detailAddress}}</p>
        </div>
        <div class="order-item-content" style="padding: 20px 24px">
{{--            <a href="#"--}}
{{--               class="btn-pure-secondary">--}}
{{--                <img src="{{asset('asset-seller/Img/mdi_chat_bubble_outline.svg')}}">--}}
{{--                @lang('Message Buyer')--}}
{{--            </a>--}}
            <chat-button-to-buyer class="btn-pure-secondary"
                         store-id="{{$store->id}}"
                         user-id="{{$order->user_id}}"
                         messenger-url="{{route('seller.messenger.init_chat_with_buyer', $order->user_id)}}">
                <img src="{{asset('asset-seller/Img/mdi_chat_bubble_outline.svg')}}">
                @lang('Message Buyer')
            </chat-button-to-buyer>
            @if ($order->status !== \App\Model\Order::STATUS_NEW && $order->status !== \App\Model\Order::STATUS_INPROCESS)
            <a  data-toggle="modal" data-target="#modalShipLabel"
                class="ml-8px btn-pure-secondary js-change-order-to-in-process"
                data-order="{{ json_encode($order->jsonSerialize()) }}"
                href="#"
            >
                <img src="{{asset('asset-seller/Img/printer.svg')}}">
                @lang('Ship Label')
            </a>
            @endif
        </div>

    </div>
    <!-- #.order-item -->

@endforeach

<!-- The Modal proceed order -->
<div class="modal modalProceed" id="modalProceed">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Select Pick-Up Time</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="row scrollbox mt-20px">
                    <div class="col-12">
                        <h4>Pick-Up Address</h4>
                        <p>{{$store->name}}</p>
                        <p>{{$store->address}}, {{$store->district->name}}, {{$store->city->name}}, {{$store->province->name}}</p>
                        <p>(+{{$store->seller->phone}})</p>
                    </div>
                    <div class="col-12 mt-32px">
                        <h4>Deliver To Address</h4>
                        <p id="orderName">Boby Haryanto</p>
                        <p id="orderAddress">Jalan Kaligadis No. 33, Jagalan, Jebres, Surakarta</p>
                        <p id="orderPhone">081234567890</p>
                    </div>

                    <div class="col-12 mt-30px">
                        <h4>Select Pick-Up Time</h4>
                        <div class="form-group">
                            <div class="custom-control custom-radio">
                                <input type="radio" id="rd_1" name="expect_time" class="custom-control-input" value="{{date("Y-m-d")}} 10:00:00">
                                <label class="custom-control-label green" for="rd_1">10:00 - 12:00 WIB</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="rd_2" name="expect_time" class="custom-control-input" value="{{date("Y-m-d")}} 12:00:00">
                                <label class="custom-control-label green" for="rd_2">12:00 - 14:00 WIB</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="rd_3" name="expect_time" class="custom-control-input" value="{{date("Y-m-d")}} 14:00:00">
                                <label class="custom-control-label green" for="rd_3">14:00 - 16:00 WIB</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="rd_4" name="expect_time" class="custom-control-input" value="{{date("Y-m-d")}} 16:00:00">
                                <label class="custom-control-label green" for="rd_4">16:00 - 18:00 WIB</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="rd_5" name="expect_time" class="custom-control-input" value="{{date("Y-m-d")}} 18:00:00">
                                <label class="custom-control-label green" for="rd_5">18:00 - 20:00 WIB</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="rd_6" name="expect_time" class="custom-control-input" value="{{date("Y-m-d", strtotime("tomorrow"))}} 10:00:00">
                                <label class="custom-control-label green" for="rd_6">Tomorrow (10:00 - 12:00 WIB)</label>
                            </div>

                        </div>
                        <div class="text-note-gray">
                            <p>
                                Once you click 'Proceed', the order will be confirmed and cannot be cancelled. Please also ensure that the package is ready for pick-up before our delivery partner arrives.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <a type="button" class="btn btn-cancel" data-dismiss="modal">Close</a>
                <a class="btn secondary" id="btnProceedOrder">Proceed</a>

            </div>

        </div>
    </div>
</div>

<!-- The Modal proceed order by DC -->
<div class="modal modalDC" id="modalDC">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Proceed by DC</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="text-note-gray">
                    <p>
                        Once you click 'Proceed by DC', the order will be proceed by DC and cannot be cancelled. Please ship your order to DC within 2 days.
                    </p>
                </div>
            </div>

            <div class="modal-footer">
                <a type="button" class="btn btn-cancel" data-dismiss="modal">Close</a>
                <a class="btn primary" id="btnProceedByDC" style="color: #fff"
                   data-dismiss="modal"
                   data-url=""
                >
                    Proceed by DC
                </a>

            </div>
        </div>
    </div>
</div>

<!-- The Dialog confirm shipping label -->
<div class="modal-1 modalProceed" id="modalShipLabel" tabindex="-1">
    <!-- Modal content -->
    <div class="modal-content-1">
        <!-- Modal Header -->
        <div class="modal-header">
            <div class="navbar-brand logo d-flex">
                <img class="d-block w-100 h-50" src="{{asset('vendor/buyer/Img/24.svg')}}">
            </div>
            <a href="#" id="orderIdForLabel"></a>
        </div>
        <!-- Modal body -->
        <div class="modal-body">
            <div class="row scrollbox mt-20px">
                <div class="col-12" style="margin-bottom: 16px">
                    <p class=" d-flex justify-content-center">
                        <svg id="barcode"></svg>
                    </p>
                </div>
                                <div class="col-12 d-flex mt-30px"style="margin-bottom: 24px">
                                    <div class="pad-out">
                                        <p class="font-custom-pick-up">@lang('Invoice.No')</p>
                                        <p id="orderId" class="shipping-info"></p>
                                    </div>
                                    <div class="pad-out">
                                        <p class="font-custom-pick-up">@lang('Weight')</p>
                                        <p id="orderWeight" class="shipping-info"></p>
                                    </div>
                                    <div class="pad-out">
                                        <p class="font-custom-pick-up">@lang('Shipping Fee')</p>
                                        <p id="orderShipFee" class="shipping-info"></p>
                                    </div>
                                    <div class="pad-out">
                                        <p class="font-custom-pick-up">@lang('Shipping Insurance')</p>
                                        <p id="orderInsuranceFee" class="shipping-info"></p>
                                    </div>
                                </div>
                <div class="col-6 mt-30px">
                    <p class="font-custom-pick-up">@lang('Origin')</p>
                    <p class="shipping-info">{{$store->name}}</p>
                    <p class="color-black shipping-info">({{$store->seller->phone}})</p>
                    <p class="ship-address">{{$store->address}}, {{$store->district->name}}, {{$store->city->name}}, {{$store->province->name}}</p>
                </div>

                <div class="col-6 mt-30px">
                    <p class="font-custom-pick-up">@lang('Destination')</p>
                    <p id="orderNameForLabel" class="shipping-info"></p>
                    <p id="orderPhoneForLabel" class="color-black shipping-info"></p>
                    <p id="orderAddressForLabel" class="ship-address"></p>
                </div>
                <div class="text-note-gray" style="margin-top: 24px">
                    <p>Seller doesn’t need to pay anything unless there’s an extra shipping charge. All payments are automatically paid by the system</p>
                </div>
            </div>
        </div>
    </div>
</div>
