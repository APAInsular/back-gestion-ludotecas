<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PhonesPlayroom;

class Playroom extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'address',
        'phone',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];

    public function phones()
    {
        return $this->hasMany(PhonesPlayroom::class);
    }
    public function address()
    {
        return $this->hasOne(AddressPlayroom::class, 'playroom_id');
    }

    public function users()
    {
        return $this->belongsToMany(
            User::class,
            'role_user_ludoteca', // Nombre de la tabla pivot
            'playroom_id',
            'user_id'
        )
            ->using(RoleUserLudoteca::class)
            ->withPivot('role_id')
            ->withTimestamps();
    }

    // Pivot directo
    public function ludotecaRoles()
    {
        return $this->hasMany(RoleUserLudoteca::class, 'playroom_id');
    }

}
