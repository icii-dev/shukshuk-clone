@component('mail::message')
    <p>Dear {{$seller->first_name}} {{$seller->last_name}},</p>
    <p>Your Shukshuk seller account has been verified.
        <br/>You are now able to upload products onto our platform for transactions.
        <br/>Click this <a href="{{route('seller.home')}}"><strong>link</strong></a> to start uploading your products.
{{--        <br/>Click this link (Hyperlink to Shukshuk How-to page) to learn how to upload your products.--}}
        <br/>Click this <a href="{{route('home')}}"><strong>link</strong></a> to return to our website.
        <br/>If you have any questions, contact us at {{trans('email.email-contact')}}</p>
    <p>Thanks for being a part of our family!<br/>Loads of love,<br/>{{trans('email.regard')}}</p>
@endcomponent