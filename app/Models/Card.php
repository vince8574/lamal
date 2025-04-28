<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;

    protected $fillable = [

        'prime_id',
        'profile_id',

    ];

    public function prime()
    {
        return $this->belongsTo(Prime::class);
    }

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public function mediane()
    {
        return $this->belongsTo(Mediane::class);
    }
}
