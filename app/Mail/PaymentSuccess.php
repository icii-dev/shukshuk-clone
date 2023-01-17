<?php

namespace App\Mail;

use App\Model\Payment;
use App\Model\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PaymentSuccess extends Mailable
{
    use Queueable, SerializesModels;
    public $buyer, $payment;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $buyer, Payment $payment)
    {
        $this->buyer = $buyer;
        $this->payment = $payment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(\Config::get('app.name') . 'Payment Successful')
                    ->markdown('vendor.mail.markdown.users.payment-successful');
    }
}
