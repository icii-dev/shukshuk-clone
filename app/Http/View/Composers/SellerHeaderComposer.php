<?php

namespace App\Http\View\Composers;

use App\Service\OrderService;
use Illuminate\Contracts\View\View;

class SellerHeaderComposer
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

        $totalOrder = $this->orderService->getTotalNewOrderOfStore($store);

        // @todo: calculate for totalMessage & totalNotification
        $view->with('totalOrder', $totalOrder)
            ->with('totalMessage', 0)
            ->with('totalNotification', 0)
            ->with('store', $store);
    }
}