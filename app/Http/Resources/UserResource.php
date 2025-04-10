<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'DNI' => $this->DNI,
            'name' => $this->name,
            'firstSurname' => $this->firstSurname,
            'secondSurname' => $this->secondSurname,
            'email' => $this->email,
            'address' => new AddressResource($this->whenLoaded('address')),
            'phone' => new PhoneResource($this->whenLoaded('phones')),
            // otros campos que quieras exponer
        ];
    }
}
