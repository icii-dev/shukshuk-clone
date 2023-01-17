<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderShippingHistory extends Model
{
    protected $fillable = [
        'message',
        'tracking_code',
        'action_at',
    ];

    protected $casts = [
        'action_at' => 'datetime',
    ];

    public function orderShipping()
    {
        return $this->belongsTo(OrderShipping::class);
    }
}
