<?php

namespace App\Mail;

use App\Model\Payment;
use App\Model\User;
use Config;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PaymentFailure extends Mailable
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
        return $this->subject(Config::get('app.name') . ' - Payment Failure')
            ->markdown('vendor.mail.markdown.users.payment-failure');
    }
}
