<?php

namespace App\Jobs;

use App\Mail\OrderPlaced;
use App\Model\Order;
use App\Model\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Illuminate\Support\Facades\Mail;

class SendOrderEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $tries = 5;
    protected $order;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        // send mail to seller
        $email = $this->order->store->seller->email ?? 'seller@gmail.com';
        if (env('APP_ENV')!='production'){
            $email = 'tintran.uit@gmail.com';
        }
        Mail::to($email, $this->order->billing_name)->send(new OrderPlaced($this->order));

    }
}
