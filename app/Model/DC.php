<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DC extends Model
{
    protected $table = 'dcs';

    protected $fillable = [
        'name',
        'phone',
        'type',
        'reference_id',
        'time_open',
        'time_closed',
        'province_id',
        'regency_id',
        'district_id',
        'status'
    ];

    const STATUS_DRAFT = 2;
    const STATUS_DEACTIVE = 0;
    const  STATUS_ACTIVE = 1;
    const STATUS_WAITING_APPROVAL = 3;
    const STATUS_CLOSED = 4;

    public function getListStatus(){
        return [
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_DEACTIVE => 'DeActive',
            self::STATUS_CLOSED => 'Close',
            self::STATUS_DRAFT => 'Draft',
            self::STATUS_WAITING_APPROVAL => 'Waiting Approval'
        ];
    }

    public function stores(){
        return $this->hasMany(Store::class);
    }
}