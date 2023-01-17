<?php

namespace App\Events;

use App\Model\Seller;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AdminReviewSeller
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $seller;
    public $status;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Seller $seller, $status)
    {
        $this->seller = $seller;
        $this->status = $status;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('admin-review-seller');
    }
}
