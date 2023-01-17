<?php

namespace App\Listeners;

use App\Events\SellerRegistered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SellerRegisteredListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  SellerRegistered  $event
     * @return void
     */
    public function handle(SellerRegistered $event)
    {
        \App\Jobs\SendSellerRegisrtationEmail::dispatch($event->seller)->delay(1);
    }
}
