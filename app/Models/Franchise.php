<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Franchise extends Model
{
    use HasFactory;
    protected $fillable=[
        'key'
    ];

    public function primes(){
        return $this->hasMany(Prime::class);
    }
}
