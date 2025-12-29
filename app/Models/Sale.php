<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'playroom_id',
        'kid_id',
        'user_id',
        'total',
    ];

    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }
}
