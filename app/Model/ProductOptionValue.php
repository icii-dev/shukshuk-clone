<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProductOptionValue extends Model
{
    public $timestamps = false;

    public $guarded = ['id'];

    public function values()
    {
        return $this->hasMany(ProductOptionValue::class, 'product_option_id');
    }

    public function productOption()
    {
        return $this->belongsTo(ProductOption::class);
    }
}
