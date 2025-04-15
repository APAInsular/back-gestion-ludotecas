<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddressPlayroom extends Model
{
    use HasFactory;

    // Si la tabla se llama "addresses_playroom" (y no sigue la convención plural de Laravel)
    protected $table = 'addresses_playroom';

    // Campos asignables masivamente
    protected $fillable = [
        'playroom_id',
        'street',
        'municipality',
        'province',
        'country',
        'locality',
        'zip_code',
    ];

    /**
     * Relación inversa: una dirección pertenece a una playroom.
     */
    public function playroom()
    {
        return $this->belongsTo(Playroom::class, 'playroom_id');
    }
}
