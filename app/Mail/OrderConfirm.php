<?php

namespace App\Mail;

use App\Model\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Log;
use Config;

class OrderConfirm extends Mailable
{
    use Queueable, SerializesModels;
    public $buyer;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $buyer)
    {
        $this->buyer = $buyer;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Order for '.Config::get('app.name'))
            ->markdown('vendor.mail.markdown.users.order-confirmation');
    }
}
