<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductVariantResource extends JsonResource
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
        return [
            'price' => $this->price,
            'formatted_price' => $this->formatted_price,
            'present_price' => $this->present_price,
            'formatted_present_price' => $this->formatted_present_price,
            'formatted_discount_amount' => $this->formatted_discount_amount,
            'has_discount' => $this->has_discount
        ];
    }
}
