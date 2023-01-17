<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    const TYPE_HOME = 'HOME';
    const TYPE_OFFICE = 'OFFICE';

    protected $table = 'user_address';
    protected $fillable = [
        'phone',
        'province_id',
        'regency_id',
        'district_id',
        'addresses',
        'date_of_birth',
        'customer_id',
        'recipient_name',
        'type'
    ];

    public function user()
    {
        return $this->belongsTo('App\Model\User', 'id', 'customer_id');
    }

    public function province()
    {
        return $this->belongsTo(AddressProvince::class, 'province_id');
    }

    public function city()
    {
        return $this->belongsTo(AddressCity::class, 'regency_id');
    }

    public function district()
    {
        return $this->belongsTo(AddressDistrict::class, 'district_id');
    }

    public static function getListType()
    {
        return [
            self::TYPE_HOME => 'HOME',
            self::TYPE_OFFICE => 'OFFICE'
        ];
    }

    public function getFullAddressAttribute()
    {
        $addresses = [
            $this->addresses
        ];

        if ($this->district) {
            $addresses[] = $this->district->name;
        }

        if ($this->city) {
            $addresses[] = $this->city->name;
        }

        if ($this->province) {
            $addresses[] = $this->province->name;
        }

        return implode(', ', $addresses);
    }

}
