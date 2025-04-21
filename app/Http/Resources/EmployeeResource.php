<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'position' => $this->position,
            'salary' => $this->salary,
            'bank_account' => $this->bank_account,

            /* Datos del usuario asociado */
            'user' => [
                'id' => $this->whenLoaded('user', fn() => $this->user->id),
                'name' => $this->whenLoaded('user', fn() => $this->user->name),
                'firstSurname' => $this->whenLoaded('user', fn() => $this->user->firstSurname),
                'secondSurname' => $this->whenLoaded('user', fn() => $this->user->secondSurname),
                'email' => $this->whenLoaded('user', fn() => $this->user->email),
                'DNI' => $this->whenLoaded('user', fn() => $this->user->DNI),
            ],

            /* Dirección (1 a 1) */
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

            /* Teléfonos (1 a N) */
            'phones' => $this->whenLoaded('phones', function () {
                return $this->phones->map(function ($phone) {
                    return [
                        'number' => $phone->number,
                        'label' => $phone->label,
                    ];
                });
            }),

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
