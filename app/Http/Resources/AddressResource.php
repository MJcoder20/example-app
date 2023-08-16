<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
          
            'district' => $this->district,
            'street' => $this->street,
            'phone' => $this->phone,
            'city_id'=> $this->city_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
         
        ];
    }
}
