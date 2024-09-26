<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Canton extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'name'
    ];

    public function primes()
    {
        return $this->hasMany(Prime::class);
    }
}
