<?php

namespace App\Mail;

use App\Model\User;
use Config;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CancelOrder extends Mailable
{
    use Queueable, SerializesModels;
    public $buyer, $orderId;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $buyer, $orderId)
    {
        $this->buyer = $buyer;
        $this->orderId = $orderId;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Order Canceled')
            ->markdown('vendor.mail.markdown.users.order-has-been-cancel');
    }
}
