@foreach($order->orderProducts as $orderProduct)
    <div class=" d-flex align-items-start mb-1">
        <span class="no color-gray mr-4">{{ $loop->iteration }}</span>
        <img class="d-block mr-3 detail--img" src="{{ getProductImageUrl($orderProduct->product->image) }}" alt="">
        <div class="wrap-information d-flex justify-content-between w-100">
            <div>
                <p class="color-primary">{{ $orderProduct->name }}</p>
                <p class="color-black">Qty: {{ $orderProduct->quantity }}</p>
                <p class="color-black">Notes: {{ $orderProduct->note ? $orderProduct->note : '-' }}</p>
                <p class="color-black font-weight-bold">{{ moneyFormat($orderProduct->subtotal) }}</p>
            </div>
        </div>
    </div>
@endforeach
<div class="d-flex justify-content-between">
    <p class="neworder--total color-second font-weight-bold">Total: {{ moneyFormat($order->billing_total) }},- ({{ getPaymentTypeTextFromStore($order->payment) }})</p>
    <p class="pointer close-details">Close Details <img src="{{ asset("asset-seller/Img/top-down.svg") }}"></p>
</div>