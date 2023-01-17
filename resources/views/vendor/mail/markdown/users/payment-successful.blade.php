@component('mail::message')
<p>Dear {{$buyer->name}} {{$buyer->last_name}},</p>
<p></p>
<p>Your payment for Orders
    @foreach($payment->orders as $order)
        # {{ $order->id}} ,
    @endforeach
    has been successful. Below is the receipt for</p>
<p>your payment.</p>
<p>Payment Number: {{$payment->id}}</p>
<p>Amount Paid: {{$payment->paid_amount}}</p>
<p>Date Paid: {{$payment->updated_at}}</p>
<p>Payment Method: {{$payment->method}}</p>
<p>Summary</p>
<p>Amount Paid to Shukshuk: {{$payment->paid_amount}}</p>
<p>If you have any questions, contact us at {{trans('email.email-contact')}}</p>
<p><br></p>
<p>Click this <a href="{{route('home')}}">link</a> to return to our website.</p>
<p><br></p>
<p>Thanks for being a part of our family!</p>
<p>Loads of love,</p>
<p>{{trans('email.regard')}}</p>
@endcomponent