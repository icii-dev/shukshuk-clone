<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
//        return parent::toArray($request);
        $variants = $this->variants;
        $variantPrices = array_column($variants->toArray(), 'price');
        $variantPresentPrices = array_column($variants->toArray(), 'present_price');
        return [
            'slug' => $this->slug,
            'name' => $this->name,
            'details' => $this->details,
            'description' => $this->description,
            'featured' => $this->featured,
            'quantity' => $this->quantity,
            'image' => $this->image,
            'images' => $this->images,
            'price' => $this->price,
            'price_range' => [
                'price_min' => min($variantPrices),
                'price_max' => max($variantPrices),
                'present_price_min' => min($variantPresentPrices),
                'present_price_max' => max($variantPresentPrices),
                'currency' => env('APP_CURRENCY', 'Rp')
            ],
            'discount' => $this->discount,
            'discount_type' => $this->discount_type,
            'presentPrice' => $this->presentPrice(),
            'store_id' => $this->store_id,
            'rating_cache' => $this->rating_cache,
            'rating_count' => $this->rating_count,
            'store' => [
                'slug' => $this->store->slug,
                'name' => $this->store->name,
            ],
            'variants' => ProductVariantResource::collection($this->variants),
            'sold' => $this->sold
        ];
    }
}
