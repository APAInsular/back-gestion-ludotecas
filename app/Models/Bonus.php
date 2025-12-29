<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bonus extends Model
{
    protected $fillable = [
        'kid_id',
        'total_minutes',
        'remaining_minutes',
        'bonus_product_id',
        'expires_at',
    ];

    public function kid()
    {
        return $this->belongsTo(Kid::class);
    }

    public function usages()
    {
        return $this->hasMany(BonusUsage::class);
    }
}
