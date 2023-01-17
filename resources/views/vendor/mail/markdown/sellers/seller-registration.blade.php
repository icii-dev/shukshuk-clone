@component('mail::message')
    <p>Dear {{$seller->first_name}} {{$seller->last_name}},</p>
    <p>Your Shukshuk seller account has been registered and is pending verification.</p>
    <p>We are working to verify your account and will contact you if we need additional</p>
    <p>information. We do this to ensure the highest level of security standards for both the</p>
    <p>merchant and the customer.</p>
    <p>Upon verification of your account, we will notify you via email and you may then be able to</p>
    <p>upload products onto our platform for transactions.</p>
    <p>Meanwhile, you can learn how to upload your products here (Hyperlink to Shukshuk How-</p>
    <p>to page).</p>
    <p></p>
    <p>Click this link (Hyperlink to Shukshuk website) to return to our website.</p>
    <p></p>
    <p>Thanks for being a part of our family!</p>
    <p>Loads of love,</p>
    <p>The Shukshuk Team</p>
@endcomponent