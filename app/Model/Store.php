<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    /* Store status */
    const STATUS_DRAFT = 2;
    const STATUS_DEACTIVE = 0;
    const  STATUS_ACTIVE = 1;
    const STATUS_WAITING_APPROVAL = 3;
    const STATUS_CLOSED = 4;

    /* Store type */
    const TYPE_INDIVIDUAL = 1;
    const TYPE_NGO = 2;
    const TYPE_SMALL_MEDIUM_ENTERPRISE = 3;
    const TYPE_BIG_COMPANIES = 4;

    /* Featured constant */
    const FEATURED_ON = 1;
    const FEATURED_OFF = 0;

    protected $guarded = [
        'id',
        'user_id',
        'slug'
    ];

    protected $fillable = [
        'delivery_unit_id',
        'name',
        'type',
        'category_id',
        'industry_id',
        'description',
        'address',
        'address_province_id',
        'address_city_id',
        'address_district_id',
        'cover_video',
        'is_cover_video'
    ];

    protected $casts = [
        'proof_images' => 'array'
    ];

    /* ---------------------- Scope ---------------------- */
    public function scopePublished(Builder $query)
    {
        return $query->where('status', '=', self::STATUS_ACTIVE);
    }

    /* ---------------------- Accessor ---------------------- */


    /* ---------------------- Relation ---------------------- */

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function categories(){
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function paymentMethods()
    {
        return $this->belongsToMany(PaymentMethod::class, 'store_payment_method');
    }

    public function delliveryUnit()
    {
        return $this->belongsTo(DeliveryUnit::class);
    }

    public function province()
    {
        return $this->belongsTo(AddressProvince::class, 'address_province_id');
    }

    public function city()
    {
        return $this->belongsTo(AddressCity::class, 'address_city_id');
    }

    public function district()
    {
        return $this->belongsTo(AddressDistrict::class, 'address_district_id');
    }

    public function wishlist()
    {
        return $this->hasMany(WishlistStore::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function balance()
    {
        return $this->hasOne(StoreBalance::class);
    }

    public function recalculateRating()
    {
        $products = $this->products()->rating();
        $avgRating = $products->avg('rating_cache');
        $this->rating = round($avgRating,1);
        $this->save();
    }

    public function isActive(){
        if($this->status == $this->STATUS_ACTIVE)
            return true;
        return false;
    }

    public function industry(){
        return $this->belongsTo(Industry::class);
    }

    public function rejectCause(){
        return $this->hasMany(StoreRejectCause::class, 'store_id');
    }

    public function banks(){
        return $this->hasMany(Bank::class);
    }

    public function DC(){
        return $this->belongsTo(DC::class, 'dc_id');
    }

}
