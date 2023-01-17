<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class WishlistStore extends Model
{
    protected $table = 'store_favorite';

    protected $fillable = [
        'store_id', 'user_id',
    ];


    public function store(){
        return $this->belongsTo(Store::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
