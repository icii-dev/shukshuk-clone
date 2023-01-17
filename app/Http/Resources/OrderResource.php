<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'=> $this->id,
            'user_id'=> $this->user_id,
            'billing_email'=> $this->billing_email,
            'billing_name'=> $this->billing_name,
            'billing_address'=> $this->billing_address,
            'billing_city'=> $this->city->name,
            'billing_province'=> $this->province->name,
            'billing_district'=> $this->district->name,
            'billing_phone'=> $this->billing_phone,
            'billing_shipping_fee'=> $this->billing_shipping_fee,
            'billing_insurance_fee'=> $this->billing_insurance_fee,
            'total_weight'=>$this->total_weight,
            'billing_name_on_card'=> $this->billing_name_on_card,
            'billing_discount'=> $this->billing_discount,
            'billing_discount_code'=> $this->billing_discount_code,
            'billing_subtotal'=> $this->billing_subtotal,
            'billing_tax'=> $this->billing_tax,
            'billing_total'=> $this->billing_total,
            'payment_gateway'=> $this->payment_gateway,
            'payment_id'=> $this->payment_id,
            'checkout_id'=> $this->checkout_id,
            'shipped'=> $this->shipped,
            'error'=> $this->error,
            'store_id'=> $this->store_id,
            'status'=> $this->status,
            'created_at'=> $this->created_at,
            'updated_at'=> $this->updated_at,

        ];
    }
}
