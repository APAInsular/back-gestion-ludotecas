<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kid extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'birthdate',
        'playroom_id',
        'tutor_id',
        'dni_id',
    ];

    protected $casts = [
        'id' => 'integer',
        'birthdate' => 'date',
        'playroom_id' => 'integer',
        'tutor_id' => 'integer',
        'dni_id' => 'integer',
    ];

    public function dni(): BelongsTo
    {
        return $this->belongsTo(Dni::class);
    }

    public function playroom(): BelongsTo
    {
        return $this->belongsTo(Playroom::class);
    }

    public function tutor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'tutor_id');
    }
}
