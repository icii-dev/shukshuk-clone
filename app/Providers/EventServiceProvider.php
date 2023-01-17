<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'cart.added' => [
            'App\Listeners\CartUpdatedListener',
        ],
        'cart.updated' => [
            'App\Listeners\CartUpdatedListener',
        ],
        'cart.removed' => [
            'App\Listeners\CartUpdatedListener',
        ],
        'Illuminate\Auth\Events\Registered' => [
            'App\Listeners\RegisteredListener'
        ],
        'App\Events\UpdatePayment' => [
            'App\Listeners\UpdatePaymentListener'
        ],
        'App\Events\SellerRegistered' => [
            'App\Listeners\SellerRegisteredListener'
        ],
        'App\Events\OrderPayForSeller' => [
            'App\Listeners\OrderPayForSellerListener'
        ],
        'App\Events\OrderCancelled' => [
            'App\Listeners\OrderCancelledListener'
        ],
        'App\Events\AdminReviewSeller' => [
            'App\Listeners\SendEmailReviewSeller'
        ],
        // Users
        'App\Events\UserUpdated' => [
            'App\Listeners\UpdateSendbirdUserBuyer'
         ],
        // Store
        'App\Events\StoreUpdated' => [
            'App\Listeners\UpdateSendbirdUserStore'
        ],
        // Shipping
        'App\Events\ShippingSucceed' => [
            'App\Listeners\UpdateOrderStatusAfterShippingSucceed'
        ],
        'App\Events\ShippingFailed' => [
            'App\Listeners\UpdateOrderStatusAfterShippingFailed'
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
