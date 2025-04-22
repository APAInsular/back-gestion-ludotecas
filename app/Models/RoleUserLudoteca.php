<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class RoleUserLudoteca extends Pivot
{
    protected $table = 'role_user_ludoteca'; // Nombre de la tabla pivot

    // Para asignación masiva
    protected $fillable = [
        'user_id',
        'playroom_id',
        'role_id',
    ];

    public $incrementing = false;
    

    // Si quieres timestamps en el pivot
    public $timestamps = true;

    // Relaciones inversas (opcional)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ludoteca()
    {
        return $this->belongsTo(Playroom::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
