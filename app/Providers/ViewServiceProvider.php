<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        /* Seller */

        // Header
        View::composer(
            'seller.shared._header', 'App\Http\View\Composers\SellerHeaderComposer'
        );

        // Modal
        View::composer(
            'seller.shared._modal', 'App\Http\View\Composers\SellerModalComposer'
        );

        // Order
        View::composer(
            'seller.order._order_nav', 'App\Http\View\Composers\SellerOrderNavComposer'
        );

        //buyer header
        View::composer(
            'buyer.partials.header', 'App\Http\View\Composers\BuyerHeaderComposer'
        );

        //cart header
        View::composer(
            'buyer.partials.cart', 'App\Http\View\Composers\CartComposer'
        );

        //buyer footer
        View::composer(
            'buyer.partials.footer', 'App\Http\View\Composers\BuyerMenuFooterComposer'
        );

        //buyer footer
        View::composer(
            'buyer.partials.nav.about_nav', 'App\Http\View\Composers\BuyerMenuFooterComposer'
        );

        //admin edit about page
        View::composer(
            'buyer.partials.nav.page_admin_nav', 'App\Http\View\Composers\BuyerMenuFooterComposer'
        );
    }
}