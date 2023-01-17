<?php

namespace App\Listeners;

use App\Events\AdminReviewSeller;
use App\Mail\ApprovalStore;
use App\Mail\DisapprovelStore;
use App\Model\Store;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use Log;

class SendEmailReviewSeller implements ShouldQueue
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
    public function handle(AdminReviewSeller $event)
    {
        $seller = $event->seller;

        if (env('APP_ENV')!='production'){
            $seller = 'tintran.uit@gmail.com';
        }
        \Log::info('call event');

        switch ($event->status){
            case Store::STATUS_ACTIVE:
                Log::info('send mail to notify the seller '.$seller->email.' is approval');
                Mail::to($seller)->send(new ApprovalStore($seller));
                break;
            case Store::STATUS_DEACTIVE:
                Log::info('send mail to notify the seller '.$seller->email.' is disapproval');
                Mail::to($seller)->send(new DisapprovelStore($seller));
                break;

        }

    }
}
