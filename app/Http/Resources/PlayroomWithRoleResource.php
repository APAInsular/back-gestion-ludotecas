<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PlayroomWithRoleResource extends JsonResource
{
    public function toArray($request): array
    {
        // $this es un Playroom cargado por belongsToMany
        return [
            'id'    => $this->id,
            'name'  => $this->name,
            'email' => $this->email,
            // puedes añadir aquí otros campos de Playroom…

            // el rol lo sacamos del pivot
            'role'  => $this->pivot->role->name ?? $this->pivot->role_id,
            'address' => new AddressResource($this->whenLoaded('address')),
            'phones' => PhoneResource::collection($this->whenLoaded('phones')),
        ];
    }
}
