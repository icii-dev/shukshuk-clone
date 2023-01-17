<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderShipping extends Model
{
    const STATUS_CREATED = 'CREATED';
    const STATUS_RETRY = 'STATUS_RETRY';
    const STATUS_IN_PROGRESS = 'IN_PROGRESS';

    // End status
    const STATUS_CANCELLED = 'CANCELLED';
    const STATUS_RETURNED = 'RETURNED';
    const STATUS_SHIPPED = 'SHIPPED';

    protected $fillable = [
        'shipping_referrer_id',
        'cost',
        'expect_start',
        'expect_finish',
        'retry_count',
        'status'
    ];

//    protected $casts = [
//        'expect_start' => 'datetime',
//        'expect_finish' => 'datetime'
//    ];

    public static function getStatusFlow()
    {
        return [
            self::STATUS_CREATED,
            self::STATUS_IN_PROGRESS,
            self::STATUS_CANCELLED,
            self::STATUS_RETURNED,
            self::STATUS_SHIPPED,

        ];
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function histories()
    {
        return $this->hasMany(OrderShippingHistory::class);
    }
}
