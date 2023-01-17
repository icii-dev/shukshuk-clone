<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Builder;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Product extends Model
{
    /* Status constant */
    const STATUS_ACTIVE = 1;
    const STATUS_DEACTIVE = 0;
    //only admin can change status block
    const STATUS_BLOCK = 20;

    /* Featured constant */
    const FEATURED_ON = 1;
    const FEATURED_OFF = 0;

    /* Discount type */
    const DISCOUNT_PERCENT = 1;
    const DISCOUNT_MONEY = 0;

    const STOCK_EMPTY = -1;

    use SearchableTrait;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'quantity',
        'price',
        'discount',
        'discount_type',
        'weight',
        'width',
        'height',
        'length',
        'is_published',
        'status',
        'sold'
    ];

    protected $casts = [
        'images' => 'array',
    ];

    protected $appends = [
        'price_range'
    ];
    protected $hidden = ['price_range'];

    /**
     * Searchable rules.
     *
     * @var array
     */
//    protected $searchable = [
//        /**
//         * Columns and their priority in search results.
//         * Columns with higher values are more important.
//         * Columns with equal values have equal importance.
//         *
//         * @var array
//         */
//        'columns' => [
//            'products.name' => 10,
//            'products.details' => 5,
//            'products.description' => 2,
//        ],
//    ];

    public static function getListStatus()
    {
        return [
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_DEACTIVE => 'No active',
        ];
    }

    public static function getStatusName($statusId)
    {
        $listStatus = self::getListStatus();

        return $listStatus[$statusId] ?? null;
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product');
    }

    /**
     * Current price after discount promotion
     * @return float|int|mixed|null
     */
    public function presentPrice()
    {
        $presentPrice = $this->price;
        if($this->discount){
            if($this->discount_type == \App\Model\Product::DISCOUNT_PERCENT && $this->discount<100){
                $presentPrice = $presentPrice * (100 - $this->discount) / 100;
            }else{
                $presentPrice = $presentPrice - $this->discount;
            }
        }
        return $presentPrice;
    }

    public function scopeMightAlsoLike($query)
    {
        return $query->inRandomOrder()->take(4);
    }

    public function scopePublished(Builder $query)
    {
        return $query->where('status', '=', self::STATUS_ACTIVE)
            ->whereIn('store_id', function ($query) {
                $query->select('id')
                    ->from('stores')
                    ->where('status', Store::STATUS_ACTIVE);
            })
//            ->with('store')
//            ->where('store_id', function ($query) {
//                Store::select('id')->where('status', '=', Store::STATUS_ACTIVE);
//            })
//            ->with(['store' => function ($query) {
//                $query->where('status', '=', Store::STATUS_ACTIVE);
//            }])
            ;
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $array = $this->toArray();

        $extraFields = [
            'categories' => $this->categories->pluck('name')->toArray(),
        ];

        return array_merge($array, $extraFields);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function options()
    {
        return $this->hasMany(ProductOption::class);
    }

    public function optionValues()
    {
        return $this->hasManyThrough(ProductOptionValue::class, ProductOption::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function wishlist(){
        return $this->hasMany(Wishlist::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class)->notSpam()->approved();
    }

    public function scopeRating($query){
        return $query->where('rating_count', '>', 0);
    }

    public function recalculateRating()
    {
        $reviews = $this->reviews()->notSpam()->approved();
        $avgRating = $reviews->avg('rating');
        $this->rating_cache = round($avgRating,1);
        $this->rating_count = $reviews->count();
        $this->save();
    }

    public function delete() {
        $this->options()->delete();
        parent::delete();
    }

    protected function getPriceRangeAttribute()
    {
        $variants = $this->variants;
        $variantPrices = array_column($variants->toArray(), 'price');
        $variantPresentPrices = array_column($variants->toArray(), 'present_price');
        $currency = env('APP_CURRENCY', 'Rp');


        if(min($variantPresentPrices) == max($variantPresentPrices)){
            $presentRange = $currency . ' ' . amountFormat(min($variantPresentPrices));
        }else{
            $presentRange = $currency . ' ' . amountFormat(min($variantPresentPrices))
                . '&nbsp; - &nbsp;' . amountFormat(max($variantPresentPrices));
        }

        if(min($variantPresentPrices) == max($variantPresentPrices)){
            $range = $currency . ' ' . amountFormat(min($variantPrices));
        }else{
            $range = $currency . ' ' . amountFormat(min($variantPrices)) . '&nbsp; - &nbsp;' . amountFormat(max($variantPrices));
        }

        return [
            'price_min' => min($variantPrices),
            'price_max' => max($variantPrices),
            'present_price_min' => min($variantPresentPrices),
            'present_price_max' => max($variantPresentPrices),
            'range' => $range,
            'present_range' => $presentRange,
            'currency' => $currency
        ];
    }

}
