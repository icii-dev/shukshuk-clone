<?php

namespace App\Http\View\Composers;

use App\Service\OrderService;
use Illuminate\Contracts\View\View;

class BuyerHeaderComposer{
    private $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function compose(View $view)
    {
        $totalOrders = '';
        if(auth()->user()){
            $totalOrders = $this->orderService->getTotalNewOrderOfBuyer(auth()->user());
        }
        $view->with('totalOrders', $totalOrders);
    }
}