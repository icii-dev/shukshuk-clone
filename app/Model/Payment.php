<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    //    the invoice has successfully been paid
    const STATUS_PAID = 'PAID';
    //    the invoice has yet to be paid
    const STATUS_PENDING = 'PENDING';
    //    the amount of paid invoice has been settled to cash balance
    const STATUS_SETTLED = 'SETTLED';
    //     the invoice has been expired
    const STATUS_EXPIRED = 'EXPIRED';

    protected $fillable = [
        'id', 'status', 'method', 'channel', 'payment_fee', 'paid_amount', 'currency', 'invoice_url'
    ];
    protected $hidden = [
        'id'
    ];

    public $incrementing = false;

    // a payment have many orders
    public function orders(){
        return $this->hasMany(Order::class);
    }
    public function paymentHistories(){
        return $this->hasMany(PaymentHistory::class);
    }

    public static function getListStatus()
    {
        return [
            self::STATUS_PAID => 'PAID',
            self::STATUS_PENDING => 'PENDING',
            self::STATUS_SETTLED => 'SETTLED',
            self::STATUS_EXPIRED => 'EXPIRED',
        ];
    }
    public static function getStatusName($id)
    {
        $listStatus = self::getListStatus();

        return $listStatus[$id] ?? null;
    }


}
