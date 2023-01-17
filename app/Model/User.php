<?php

namespace App\Model;

use App\Model\Seller;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends \TCG\Voyager\Models\User
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'last_name','email', 'role_id', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getFullNameAttribute()
    {
        return $this->name . ' ' . $this->last_name;
    }

//    public function getAvatarAttribute($value)
//    {
//        return $this->attributes['avatar'];
//    }

    public function orders()
    {
        return $this->hasMany('App\Model\Order');
    }

    public function address(){
        return $this->hasOne('App\Model\UserAddress', 'customer_id');
    }

    public function seller()
    {
        return $this->hasOne(Seller::class);
    }

    public function store()
    {
        return $this->hasOne(Store::class);
    }

    public function wishlist(){
        return $this->hasMany(Wishlist::class);
    }

    public function wishlistStore(){
        return $this->hasMany(WishlistStore::class);
    }

    public function countWishlist(){
        return $this->wishlist()->count() + $this->wishlistStore()->count();
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function order_refunds()
    {
        return $this->hasMany(OrderRefund::class);
    }




}
