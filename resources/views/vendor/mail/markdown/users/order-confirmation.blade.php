@component('mail::message')
<p>Dear {{$buyer->name}},</p>
<p><br></p>
<p>Thank you for shopping with us!</p>
<p>Your new order has been confirmed.</p>
<p>Sit back and relax while your order is being processed. We will notify you once the order has</p>
<p>been shipped.</p>
<p>If you have any questions, contact us at {{trans('email.email-contact')}}</p>
<p>Click this <a href="{{route('users.orders')}}"><strong>link</strong></a> to return to our website.</p>
<p><br></p>
<p>Thanks for being a part of our family!</p>
<p>Loads of love,</p>
<p>{{trans('email.regard')}}</p>
@endcomponent