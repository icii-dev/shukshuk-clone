<?php

namespace App\Listeners;

use App\Model\Coupon;
use App\Jobs\UpdateCoupon;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CartUpdatedListener
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
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        if (session()->get('coupon')){
            $couponName = session()->get('coupon')['name'];

            if ($couponName) {
                $coupon = Coupon::where('code', $couponName)->first();

                dispatch_now(new UpdateCoupon($coupon));
            }
        }

    }
}
