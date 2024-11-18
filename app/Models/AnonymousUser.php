<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnonymousUser extends Model
{
    use HasFactory;
    protected $fillable = [

        'token_id',
        'anonymous_user_id',
        'age_range_key'

    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
}
