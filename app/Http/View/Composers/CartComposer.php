<?php

namespace App\Http\View\Composers;

use Cart;
use Illuminate\Contracts\View\View;

class CartComposer
{
    public function __construct()
    {
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $cart = Cart::instance('shopping');
        $view->with('cart', $cart);
    }
}