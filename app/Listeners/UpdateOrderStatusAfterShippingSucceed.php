<?php

namespace App\Listeners;

use App\Events\ShippingSucceed;
use App\Model\Order;
use App\Service\OrderService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateOrderStatusAfterShippingSucceed
{
    /**
     * @var OrderService
     */
    private $orderService;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Handle the event.
     *
     * @param  ShippingSucceed  $event
     * @return void
     */
    public function handle(ShippingSucceed $event)
    {
        $orderShipping = $event->getOrderShipping();
        $order = $orderShipping->order;

        $this->orderService->updateStatusTo($order, Order::STATUS_COMPLETED);
    }
}
