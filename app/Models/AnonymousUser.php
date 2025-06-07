<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnonymousUser extends Model
{
    use HasFactory;

    protected $fillable = [

        'token',
        'owner_id',

    ];

    public function profile()
    {
        return $this->hasMany(Profile::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}
