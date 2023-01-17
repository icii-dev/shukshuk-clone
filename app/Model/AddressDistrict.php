<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AddressDistrict extends Model
{
    protected $table = 'address_districts_indo';

    public $timestamps = false;

    public function city()
    {
        return $this->belongsTo(AddressCity::class, 'regency_id');
    }
}
