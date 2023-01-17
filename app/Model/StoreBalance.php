<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class StoreBalance extends Model
{
    protected $guarded = [];

    public function store(){
        return $this->belongsTo(Store::class);
    }

    public function transactions (){
        return $this->hasMany(Transaction::class);
    }
}
