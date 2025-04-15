<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhonesPlayroom extends Model
{
    use HasFactory;

    // Si tu tabla se llama "phones_playroom":
    protected $table = 'phones_playroom';

    protected $fillable = [
        'playroom_id',
        'number',
        'label',
    ];

    public function playroom()
    {
        return $this->belongsTo(Playroom::class, 'playroom_id');
    }
}
