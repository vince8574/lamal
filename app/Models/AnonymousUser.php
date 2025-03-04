<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnonymousUser extends Model
{
    use HasFactory;

    protected $fillable = [

        'token',

    ];

    public function profile()
    {
        return $this->hasMany(Profile::class);
    }
}
