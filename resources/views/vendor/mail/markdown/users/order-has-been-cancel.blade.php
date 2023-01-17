@component('mail::message')
    <p>Dear <b>{{$buyer->name}} {{$buyer->last_name}}</b>,</p>

    <p>Thank you for shopping with us!</p>

    <p>We&rsquo;re sorry to inform you that your order <span style="color: #413EC1; font-weight: 700">#{{$orderId}}</span> has been cancelled by our team due to a mistake made by our seller regarding the given discount amount.</p>

    <p> In the meantime, you can re-order your products again anytime :)</p>

    <p>Click this link <a href="{{env('APP_URL')}}" style="color: #413EC1; font-weight: 700">{{env('APP_URL')}}</a> to return to our website.</p>

    <p>Thanks for being a part of our family! Loads of love, The Shukshuk Team</p>
    <p><i>Please do not reply to this email. If you have any questions, you can reach us out at <span style="color: #413EC1; font-weight: 700">admin@shukshuk.com</span></i></p>
@endcomponent