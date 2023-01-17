<?php

namespace App\Listeners;

use App\Events\OrderPayForSeller;
use App\Model\Order;
use App\Service\StoreTransactionService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderPayForSellerListener
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
     * @param  OrderPayForSeller  $event
     * @return void
     */
    public function handle(OrderPayForSeller $event)
    {
        $storeTransactionService = new StoreTransactionService();
        $order = $event->order;
        //billing subtotal without shipping fee
        $storeTransactionService->pay($order->store, $order->billing_subtotal, "pay for seller for ".$order->id);
        $order->pay_for_seller = Order::PAID_TO_SELLER;
        $order->save();
    }
}
