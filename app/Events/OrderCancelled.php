<?php

namespace App\Events;

use App\Model\Order;
use Illuminate\Queue\SerializesModels;

class OrderCancelled
{
    use SerializesModels;

    /**
     * @var Order
     */
    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }
}
