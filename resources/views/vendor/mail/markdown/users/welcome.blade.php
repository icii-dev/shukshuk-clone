@component('mail::message')
    <p>Dear {{$user->name}} {{$user->name}},</p>
    <p><br></p>
    <p>Your Shukshuk user account has been successfully registered.</p>
    <p>The log in details are as follows:</p>
    <p>Username: {{$user->name}}</p>
    <p>Email: {{$user->email}}</p>
    <p>Click this link (Hyperlink to Shukshuk website) to return to our website.</p>
    <p>You may now use your Shukshuk user account to make purchases.</p>
    <p>You can also use your Shukshuk account to create a seller account to list any products as a</p>
    <p>merchant.</p>
    <p>If you have any questions, contact us at {{trans('email.email-contact')}}</p>
    <p><br></p>
    <p>Thanks for being a part of our family!</p>
    <p>Loads of love,</p>
    <br>{{ trans('email.regard') }}
@endcomponent
