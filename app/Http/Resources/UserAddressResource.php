<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserAddressResource extends JsonResource
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
            'id' => $this->id,
            'recipient_name' => $this->recipient_name,
            'addresses' => $this->addresses . ', '. $this->district->name .', ' . $this->city->name . ', ' . $this->province->name,
            'phone' => $this->phone,
            'type' => $this->type,
        ];
    }
}
