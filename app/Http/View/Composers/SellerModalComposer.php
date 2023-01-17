<?php

namespace App\Http\View\Composers;

use Illuminate\Contracts\View\View;

class SellerModalComposer
{
    public function compose(View $view)
    {
        $store = auth()->user()->store;

        // @todo: calculate for totalMessage & totalNotification
        $view->with('store', $store);
    }
}