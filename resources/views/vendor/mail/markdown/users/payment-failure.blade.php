@component('mail::message')
<p>Dear {{$buyer->name}} {{$buyer->last_name}},</p>
<p></p>
<p>We regret to inform you that we have encountered a problem when processing your payment</p>
<p>for Order
        @php
        $total = 0;
        @endphp
    @foreach($payment->orders as $order)
        # {{ $order->id}}
    @php
    $total += $order->billing_total;
    @endphp
    @endforeach
</p>
<p>
        The outstanding amount is {{$total}}.
</p>
<p>Please click this <a href="{{$payment->invoice_url}}">link</a> to make the necessary payments, to</p>
<p>avoid missing out on the products you have selected. Please note that your order will only be</p>
<p>processed after payment has been made.</p>
<p>Once your payment is successful, you will receive an order confirmation email from us,</p>
<p>together with the receipt of your payment.</p>
<p>Thanks for being a part of our family!</p>
<p>Loads of love,</p>
<p>{{trans('email.regard')}}</p>
@endcomponent