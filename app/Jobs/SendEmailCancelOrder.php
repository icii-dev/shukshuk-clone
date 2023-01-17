<?php

namespace App\Jobs;

use App\Model\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Mail;

class SendEmailCancelOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $buyer;
    protected $orderId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $buyer, $orderId)
    {
        $this->buyer = $buyer;
        $this->orderId = $orderId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = $this->buyer->email;
        if (env('APP_ENV')!='production'){
            $email = 'tintran.uit@gmail.com';
        }

        Mail::to($email)->send(new \App\Mail\CancelOrder($this->buyer, $this->orderId));
    }
}
