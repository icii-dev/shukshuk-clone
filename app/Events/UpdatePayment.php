<?php

namespace App\Events;

use App\Model\Payment;
use App\Model\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UpdatePayment
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $buyer, $payment, $data;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $buyer, Payment $payment, $payload)
    {
        $this->buyer = $buyer;
        $this->payment = $payment;
        $this->data = $payload;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('update-payment');
    }
}
