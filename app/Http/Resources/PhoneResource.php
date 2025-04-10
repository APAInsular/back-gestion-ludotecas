<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PhoneResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'phone' => $this->primary_phone,
            'name' => $this->name,
            'firstSurname' => $this->firstSurname,
            'secondSurname' => $this->secondSurname,
            'emergencyContact' => $this->emergencyContact,
        ];
    }
}
