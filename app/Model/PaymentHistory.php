<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PaymentHistory extends Model
{
    protected $fillable = [
        'payment_id',
        'description',
        'status',
        'action_at',
    ];

    protected $casts = [
        'action_at' => 'datetime'
    ];

    public function payment(){
        return $this->belongsTo(Payment::class);
    }
}
