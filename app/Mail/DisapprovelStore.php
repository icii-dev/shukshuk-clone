<?php

namespace App\Mail;

use App\Model\Seller;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Config;

class DisapprovelStore extends Mailable
{
    use Queueable, SerializesModels;
    public $seller;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Seller $seller)
    {
        $this->seller = $seller;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(Config::get('app.name'))
            ->markdown('vendor.mail.markdown.sellers.notification-disapproval');
    }
}
