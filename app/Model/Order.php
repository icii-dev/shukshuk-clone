<?php

namespace App\Model;

use App\Model\OrderShipping;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    const STATUS_NEW = 2;
    const STATUS_INPROCESS = 3;
    const STATUS_COMPLETED = 1;
    const STATUS_CANCELLED = 0;
    const STATUS_SCHEDULE_PICK_UP = 4;
    const STATUS_SHIPPING  = 5;
    //refund status
    const REFUND_ACCEPT=1;
    const REFUND_REJECT=0;
    const REFUND_NONE=2;
    const REFUND_REQUEST=3;
    //pay status
    const PAID_TO_SELLER = 1;
    const UNPAID_TO_SELLER = 0;
    // new (to-pay)-> inprocess(pay complete) -> schedule pick-up -> shipping

    protected $fillable = [
        'id',
        'user_id',
        'billing_email',
        'billing_name',
        'billing_address',
        'billing_city',
        'billing_province',
        'billing_district',
        'billing_phone',
        'billing_name_on_card',
        'billing_discount',
        'billing_discount_code',
        'billing_shipping_fee',
        'billing_insurance_fee',
        'billing_subtotal',
        'billing_tax',
        'billing_total',
        'payment_gateway',
        'error',
        'store_id',
        'checkout_id',
        'payment_id',
        'payment_status',
        'shipping_option',
        'total_weight',
        'pay_for_seller',
        'refund_status'
    ];

    public $incrementing = false;

    /* -------------------------------------------- Accessor -------------------------------------------- */

    public function getNameAttribute()
    {
        $listName = [];
        foreach ($this->orderProducts as $orderProduct) {
            $partName = [$orderProduct->name];

            array_push($listName, implode(' - ', $partName));
        }

        return implode(', ', $listName);
    }

    public static function getListStatus()
    {
        return [
            self::STATUS_NEW => 'New',
            self::STATUS_INPROCESS => 'In Process',
            self::STATUS_COMPLETED => 'Complete',
            self::STATUS_CANCELLED => 'Cancel'
        ];
    }

    public static function getStatusName($statusId)
    {
        $listStatus = self::getListStatus();

        return $listStatus[$statusId] ?? null;
    }

    public static function getListRefundStatus()
    {
        return [
            self:: REFUND_ACCEPT=>'Accept',
            self:: REFUND_NONE=>'None',
            self:: REFUND_REQUEST=>'Request',
            self:: REFUND_REJECT=>'Reject',
        ];
    }
    public static function getRefundStatusName($refundStatusId)
    {
        $listRefundStatus = self::getListRefundStatus();

        return $listRefundStatus[$refundStatusId] ?? null;
    }

    /* -------------------------------------------- Relation -------------------------------------------- */
    public function user()
    {
        return $this->belongsTo('App\Model\User');
    }

    public function products()
    {
        return $this->belongsToMany('App\Model\Product')->withPivot('quantity', 'subtotal', 'options', 'note');
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function province()
    {
        return $this->belongsTo(AddressProvince::class, 'billing_province');
    }

    public function city()
    {
        return $this->belongsTo(AddressCity::class, 'billing_city');
    }

    public function district()
    {
        return $this->belongsTo(AddressDistrict::class, 'billing_district');
    }

    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function orderShipping()
    {
        return $this->hasOne(OrderShipping::class, 'order_id');
    }
    public function orderRefunds()
    {
        return $this->hasMany(OrderRefund::class, 'order_id');
    }
}
