<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];

    public function ludotecaUsers()
    {
        return $this->hasMany(RoleUserLudoteca::class, 'role_id');
    }

    // Si te interesa “todos los usuarios en todas las ludotecas con este rol”:
    public function usersInLudotecas()
    {
        return $this->belongsToMany(
            User::class,
            'role_user_ludoteca', // Nombre de la tabla pivot
            'role_id',
            'user_id'
        )
            ->using(RoleUserLudoteca::class)
            ->withPivot('playroom_id')
            ->withTimestamps();
    }

}
