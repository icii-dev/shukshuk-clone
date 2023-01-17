<?php

namespace App\Jobs;

use App\Mail\OrderConfirm;
use App\Model\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Mail;

class SendOrderConfirmToBuyerEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $buyer;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $buyer)
    {
        $this->buyer = $buyer;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->buyer->email)->send(new OrderConfirm($this->buyer));

    }
}
