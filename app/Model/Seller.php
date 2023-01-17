<?php

namespace App\Model;

use App\Model\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Seller extends Model
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const STATUS_DRAFT = 2;

    protected $guarded = [
        'id',
        'user_id'
    ];

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'dob',
        'phone',
        'nationality_id',
        'residence_id',
        'id_number'
    ];

    protected $casts = [
        'dob' => 'datetime:Y-m-d'
    ];

    public function scopePublished(Builder $query)
    {
        return $query->where('status', '=', self::STATUS_ACTIVE);
    }

    public function setDobAttribute($value)
    {
        $this->attributes['dob'] = Carbon::createFromFormat('d-m-Y', $value);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function store()
    {
        return $this->hasOne(Store::class);
    }
}
