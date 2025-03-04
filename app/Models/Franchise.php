<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperFranchise
 */
class Franchise extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'label',
        'numerique',
    ];

    public function primes()
    {
        return $this->hasMany(Prime::class);
    }
}
