<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    use HasFactory;

    protected $table = 'phones';

    protected $fillable = [
        'user_id',
        'primary_phone',
        'backup_phone'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
