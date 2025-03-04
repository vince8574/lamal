<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tariftype extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'code',
        'label',
    ];

    public function primes()
    {
        return $this->hasMany(Prime::class);
    }
}
