<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Disbursement extends Model
{
    protected $guarded = [];
    protected $hidden = ['id'];
    public $incrementing = false;

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
