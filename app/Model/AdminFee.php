<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AdminFee extends Model
{
    protected $fillable = [
        "fee", "description"
    ];
}
