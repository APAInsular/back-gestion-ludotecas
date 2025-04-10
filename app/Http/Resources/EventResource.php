<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'date' => $this->date,
            'hour' => $this->hour,
            'description' => $this->description,
            'location' => $this->location,
            'playroom_id' => $this->playroom_id,
        ];
    }
}
