<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\PhoneBook */
class PhoneBookResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'image' => $this->image,
            'address' => $this->address,
            'location' => [
                'lat' => $this->lat,
                'long' => $this->long
            ],
            'nid' => $this->nid,
        ];
    }
}
