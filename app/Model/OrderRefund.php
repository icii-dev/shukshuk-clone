<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderRefund extends Model
{
    protected $table ='order_refunds';
    protected $fillable = [
        'id',
        'admin_id',
        'billing_tax',
        'billing_refund',
        'action',
        'note'
    ];
    const REFUND_ACCEPT=1;
    const REFUND_REJECT=0;

    public static function getListRefundStatus()
    {
        return [
            self:: REFUND_ACCEPT=>'Accept',
            self:: REFUND_REJECT=>'Reject',
        ];
    }

    public static function getRefundStatusName($refundStatusId)
    {
        $listRefundStatus = self::getListRefundStatus();

        return $listRefundStatus[$refundStatusId] ?? null;
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

}
