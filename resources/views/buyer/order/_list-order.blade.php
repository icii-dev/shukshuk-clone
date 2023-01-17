@php
    $payment=$order->payment;
    $orderPayments=$payment->orders;
@endphp
<div class="my-order-item">
    <div class="head d-flex justify-content-between">
        <p class="color-gray link-product">{{$order->id}} - {{date("m/d/Y", strtotime($order->created_at))}}</p>
        <a class ="view-detail link-product" href="{{route('order.show',$order->id)}}">@lang('See Order Details') &rarr;</a>
    </div>
    @foreach($order->products as $product)
        <div class="my-order-product d-flex align-items-start">
            <img class="d-block mr-3 order-product-thumbnail" src="{{ asset($product->image) }}" alt="" onerror="this.src='{{asset('img/not-found.jpg')}}'">
            <div class="wrap-information d-flex justify-content-between w-100">
                <div>
                    <a class="link-product" href="{{route('product.show', $product->slug)}}">{{$product->name}}</a>
                    @foreach(json_decode($product->pivot->options) as $key=>$value)
                        <p class="link-product" style="color: #222831;">{{$key}}: {{$value}}</p>
                    @endforeach
                    <p class="link-product" style="color: #222831;">Qty: {{$product->pivot->quantity}}</p>
                </div>
                <p class="link-product" style="color: #222831;">@lang('Price'):{{moneyFormat($product->pivot->subtotal)}}</p>
            </div>
        </div>
        <div class="link-product" style="margin-top: 8px;color: #222831;">@lang('Note'): @if($product->pivot->note) {{$product->pivot->note}} @else - @endif</div>
    @endforeach
    <div class="footer d-flex justify-content-between">
        <a href="{{ route('store.index', $order->store->slug ?? '') }}" class="truncate-overflow-one link-product"> <img src="{{asset('vendor/buyer/Img/store-icon.svg')}}" class="store-icon"/> {{$order->store->name}}</a>
        <span class="link-product" style="color: #222831;">Total: {{moneyFormat($order->billing_total+$order->payment->payment_fee/count($orderPayments))}}</span>
    </div>
</div>

