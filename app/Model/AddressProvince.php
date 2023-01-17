<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AddressProvince extends Model
{
    protected $table = 'address_provinces_indo';

    public function cities()
    {
        return $this->hasMany(AddressCity::class, 'province_id');
    }
}
