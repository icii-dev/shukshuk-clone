<?php

namespace App\Listeners;

use App\Events\OrderCancelled;

class OrderCancelledListener
{
    public function __construct()
    {

    }

    public function handle(OrderCancelled $event)
    {
        // Access the order using $event->order...
    }

}
