<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProductOption extends Model
{
    public $timestamps = false;

    public $guarded = ['id'];

    public function values()
    {
        return $this->hasMany(ProductOptionValue::class);
    }

    public function delete() {
        $this->values()->delete();
        parent::delete();
    }
}
