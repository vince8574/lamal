<?php

namespace App\Models;

use App\Models\Scopes\ForCurrentAnonymousUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [

        'name',
        'anonymous_user_id',
        'age_range_key',
        'filter',
    ];

    protected $casts = [
        'filter' => 'array',
    ];


    protected static function booted()
    {
        static::addGlobalScope(new ForCurrentAnonymousUser);
    }

    public function anonymousUser()
    {
        return $this->belongsTo(AnonymousUser::class);
    }

    public function cards()
    {
        return $this->hasMany(Card::class, 'profile_id');
    }
}
