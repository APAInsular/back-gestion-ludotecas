<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'kid_id',
        'playroom_id',
        'user_id',
        'date',
        'entry_time',
        'exit_time',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function kid(): BelongsTo
    {
        return $this->belongsTo(Kid::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function playroom(): BelongsTo
    {
        return $this->belongsTo(Playroom::class);
    }
}
