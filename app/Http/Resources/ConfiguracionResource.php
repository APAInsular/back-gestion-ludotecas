<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConfiguracionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'idioma' => $this->idioma,
            'notificaciones' => $this->notificaciones,
            'usuario_id' => $this->usuario_id,
        ];
    }
}
