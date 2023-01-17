<?php

namespace App\Listeners;

use App\Events\ShippingFailed;
use App\Model\Order;
use App\Service\OrderService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateOrderStatusAfterShippingFailed
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
        //
        $this->orderService = $orderService;
    }

    /**
     * Handle the event.
     *
     * @param  ShippingFailed  $event
     * @return void
     */
    public function handle(ShippingFailed $event)
    {
        $orderShipping = $event->getOrderShipping();
        $order = $orderShipping->order;

        $this->orderService->updateStatusTo($order, Order::STATUS_CANCELLED);
    }
}
