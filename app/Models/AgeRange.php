<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperAgeRange
 */
class AgeRange extends Model
{
    use HasFactory;
    protected $fillable = [
        'key',
        'label'
    ];

    public function primes()
    {
        return $this->hasMany(Prime::class);
    }
}
