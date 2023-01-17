<?php

namespace App\Http\View\Composers;

use App\Model\Order;
use App\Service\OrderService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;

class SellerOrderNavComposer
{
    /**
     * @var OrderService
     */
    private $orderService;

    public function __construct(
        OrderService $orderService
    ) {
        $this->orderService = $orderService;
    }

    public function compose(View $view)
    {
        $store = auth()->user()->store;

        $summaryOrderStatus = $this->orderService->getSummaryOrderStatusOfStore($store);

        $view->with('totalOrderNew', Arr::get($summaryOrderStatus, Order::STATUS_NEW, 0))
            ->with('totalOrderInprocess', Arr::get($summaryOrderStatus, Order::STATUS_INPROCESS, 0))
            ->with('totalOrderSchedulePickup', Arr::get($summaryOrderStatus, Order::STATUS_SCHEDULE_PICK_UP, 0))
            ->with('totalOrderShipping', Arr::get($summaryOrderStatus, Order::STATUS_SHIPPING, 0))
            ->with('totalOrderCompleted', Arr::get($summaryOrderStatus, Order::STATUS_COMPLETED, 0))
            ->with('totalOrderCancelled', Arr::get($summaryOrderStatus, Order::STATUS_CANCELLED, 0));
    }
}