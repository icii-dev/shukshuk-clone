<?php

namespace App\Jobs;

use App\Mail\ApprovalStore;
use App\Model\Seller;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendApprovalStore implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $seller;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Seller $seller)
    {
        $this->seller = $seller;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        \Log::info('send mail to notify the seller '.$this->seller->email.' is approval');
        \Mail::to($this->seller)->send(new ApprovalStore($this->seller));
    }
}
