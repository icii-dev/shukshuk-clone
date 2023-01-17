<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AddressCity extends Model
{
    protected $table = 'address_regencies_indo';

    public function province()
    {
        return $this->belongsTo(AddressProvince::class);
    }

    public function districts(){
        return $this->hasMany(AddressCity::class, 'regency_id');
    }
}
