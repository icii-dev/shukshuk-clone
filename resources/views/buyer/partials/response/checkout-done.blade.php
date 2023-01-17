<div class="container web-block">
    <div class="payment payment-invoice">
        <div class="row">
            <div class="col-6">
                <div class="your-cart">
                    <h2 class="title">{{$order->id}}</h2>
                    @foreach($cart as $cartItem)
                        <div class="product d-flex justify-content-between row no-gutters">
                            <div class="col-md-9 left d-flex">
                                <img class="img-your-cart" src="{{ asset($cartItem->options->thumbnail) }}" alt=""
                                     onerror="this.src='{{asset('img/not-found.jpg')}}'">
                                <div class="detail-product-yourcart">
                                    <a href="{{route('product.show', $cartItem->options->slug)}}" class="name-product truncate-overflow-one">{{$cartItem->name}}</a>
                                    <p class="qty mt-4">Qty: {{$cartItem->qty}}</p>
                                    <div class="d-flex text mt-4 option">
                                        @foreach($cartItem->options->options as $key=>$value)
                                            <p @if ($loop->first) @else class="ml-3" @endif>{{$key}}: {{$value}}</p>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 rigfht-sale">
                                <h3 class="text-right">{{moneyFormat($cartItem->subtotal)}}</h3>
                            </div>
                        </div>
                    @endforeach
                    <div class="text-method d-flex justify-content-between">
                        <p>Delivery Fee:</p>
                        <h3>{{moneyFormat($order->billing_shipping_fee)}}</h3>
                    </div>
                    <div class="text-total d-flex justify-content-between">
                        <p>All price are inclusive Tax 10%</p>
                        <h3>Total</h3>
                    </div>
                    <h1 class="text-right money-invoice">{{moneyFormat($total)}}</h1>
                    <div class="text-method d-flex justify-content-between">
                        <p>Payment Method:</p>
                        <p>{{$order->payment->method}}: {{$order->payment->channel}}</p>
                    </div>
                </div>
            </div>
            <div class="col-5 offset-1">
                <div class="wrap-paid d-flex justify-content-end">
                    <div class="paid">
                        <span>{{$order->payment->status}}</span>
                    </div>
                </div>
                <div class="change d-flex justify-content-between">
                    <p>Delivered to:</p>
                </div>
                <div class="payment-name">
                    <h2>{{$order->billing_name}}</h2>
                    <p>{{$order->billing_phone}}</p>
                </div>
                <p class="p-invoice">
                    {{$order->billing_address}}, {{$order->district()->first()->name}},
                    {{$order->city()->first()->name}}, {{$order->province()->first()->name}}
                </p>
                <div class="method invoice d-flex justify-content-between">
                    <p>Delivery Method:</p>
                    <p class="font-weight-bold">Shukshuk Delivery</p>
                </div>
                <div class="method invoice d-flex justify-content-between">
                    <p>Duration:</p>
                    <p class="font-weight-bold">
                        @php
                            use Carbon\Carbon;
                            $duration= $order->shipping_option;
                            switch ($duration){
                                  case 'REG':
                                      $date=Carbon::parse($order->created_at)->addDays(3)->format('d/m/Y');
                                       echo 'Regular (usually takes 2-3 days to arrive), expected arrive on'.$date;
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
            </div>
        </div>
    </div>
    <div class="btn-invoice d-flex justify-content-center">
        <a class="btn-customer primary btn col-2" href="#" role="button">Pay Now</a>
    </div>
    <p class="note-invoice text-center">Note: You can also find menu “My Order” in the header menu under your profile name.</p>
</div>