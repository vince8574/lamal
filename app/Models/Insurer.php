<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperInsurer
 */
class Insurer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'bag_number',
        'loc',
    ];

    public function primes()
    {
        return $this->hasMany(Prime::class);
    }
}
