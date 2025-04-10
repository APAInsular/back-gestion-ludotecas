<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KidResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'birthdate' => $this->birthdate,
            'playroom_id' => $this->playroom_id,
            'tutor_id' => $this->tutor_id,
        ];
    }
}
