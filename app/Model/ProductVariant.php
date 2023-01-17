<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    const DISCOUNT_TYPE_PERCENT = 'PERCENT';
    const DISCOUNT_TYPE_MONEY = 'MONEY';

    const STOCK_EMPTY = -1;

    protected $fillable = [
        'options',
        'option_1',
        'option_2',
        'description',
        'price',
        'quantity',
        'discount_value',
        'discount_type'
    ];

    protected $casts = [
        'images' => 'array',
        'options' => 'array'
    ];

    protected $appends = [
        'formatted_price',
        'present_price',
        'formatted_present_price',
        'formatted_discount_amount',
        'has_discount'
    ];

    public function getFormattedPriceAttribute()
    {
        return moneyFormat($this->price);
    }

    public function getFormattedPresentPriceAttribute()
    {
        return moneyFormat($this->present_price);
    }

    public function getPresentPriceAttribute()
    {
        $presentPrice = $this->price;

        if ($this->discount_value) {
            if ($this->discount_type == ProductVariant::DISCOUNT_TYPE_PERCENT && $this->discount_value < 100) {
                $presentPrice = $presentPrice * (100 - $this->discount_value) / 100;
            } else {
                $presentPrice = $presentPrice - $this->discount_value;
            }
        }

        return $presentPrice;
    }

    public function getFormattedDiscountAmountAttribute()
    {
        return formatDiscountAmountForProductVariant(
            $this->discount_type == ProductVariant::DISCOUNT_TYPE_PERCENT ?
                $this->discount_value :
                $this->price - $this->present_price,
            $this->discount_type
        );
    }

    public function getHasDiscountAttribute()
    {
        return $this->price != $this->present_price;
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
