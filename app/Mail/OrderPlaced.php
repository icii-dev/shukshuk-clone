<?php

namespace App\Mail;

use App\Model\Order;
use App\Model\Seller;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use Config;

class OrderPlaced extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        /** @var Seller $seller */

        return $this->subject('Order for '.Config::get('app.name'))
                    ->markdown('vendor.mail.markdown.sellers.new-order');
    }
}
