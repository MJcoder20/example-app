<?php

namespace App\Modules\User\App\Http\Resources;

use App\Http\Resources\AddressResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    
    public $preserveKeys = true;

    public static $wrap = 'user';

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        $this->setFullName($this->first_name,$this->last_name);

        return [
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'full_name' => $this->full_name,
            'Addresses' => AddressResource::collection($this->addresses),
            'api_token' => $this->api_token,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

 

}
