<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    protected $table = 'order_product';

    protected $fillable = [
        'order_id',
        'product_id',
        'name',
        'weight',
        'quantity',
        'subtotal',
        'options',
        'note'
    ];

    protected $casts = [
        'options' => 'array'
    ];

    /* -------------------------------------------- Accessor -------------------------------------------- */
    public function getNameAttribute()
    {
        $options = [];

        if (is_array($this->options)) {
            foreach ($this->options as $optionName => $valueName) {
                array_push($options, $optionName . ' ' . $valueName);
            }
        }

        if (!empty($options)) {
            return $this->product->name . ' (' . implode(', ', $options) . ')';
        } else {
            return $this->product->name;
        }
    }

    /* -------------------------------------------- Relation -------------------------------------------- */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
