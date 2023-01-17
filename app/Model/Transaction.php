<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $guarded = [];

    const STATUS_SUCCESS = 10;
    const STATUS_PENDING = 20;

    const TYPE_PAY_FOR_SELLER = 'PAY_FOR_SELLER';
    const TYPE_WITHDRAW = 'WITHDRAW';


}
