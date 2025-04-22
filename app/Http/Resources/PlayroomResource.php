<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlayroomResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            // 'phone' => $this->phone,
            'email' => $this->email,
            'address' => $this->whenLoaded('address', function () {
                return [
                    'street' => $this->address->street,
                    'municipality' => $this->address->municipality,
                    'locality' => $this->address->locality,
                    'zip_code' => $this->address->zip_code,
                    'country' => $this->address->country,
                    'province' => $this->address->province,
                ];
            }),
        ];
    }
}
