<?php

namespace App\Events;

use App\Model\OrderShipping;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ShippingFailed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var OrderShipping
     */
    private $orderShipping;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(OrderShipping $orderShipping)
    {
        //
        $this->orderShipping = $orderShipping;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }

    /**
     * @return OrderShipping
     */
    public function getOrderShipping(): OrderShipping
    {
        return $this->orderShipping;
    }
}
