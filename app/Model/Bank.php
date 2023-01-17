<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $guarded = [];

    public function store(){
        return $this->belongsTo(Store::class, 'store_id');
    }
}
