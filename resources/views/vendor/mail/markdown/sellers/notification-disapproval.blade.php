@component('mail::message')
    <p>Dear {{$seller->first_name}} {{$seller->last_name}},</p>
    <p>We're sorry. Your seller account has not been approved.
        <br/>If you have any questions, contact us at {{trans('email.email-contact')}}</p>
    <p>Thanks for being a part of our family!<br/>Loads of love,<br/>{{trans('email.regard')}}</p>
@endcomponent