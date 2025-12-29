<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BonusUsage extends Model
{
    protected $fillable = [
        'bonus_id',
        'attendance_id',
        'minutes_used',
    ];

    public function bonus()
    {
        return $this->belongsTo(Bonus::class);
    }

    public function attendance()
    {
        return $this->belongsTo(Attendance::class);
    }
}
