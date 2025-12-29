<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BonusProduct extends Model
{
    protected $fillable = [
        'playroom_id',
        'name',
        'minutes',
        'price',
        'active',
    ];
}
