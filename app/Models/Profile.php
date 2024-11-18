<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [

        'name',
        'userAnonimous_id',
        'birthDate'
    ];


    public function profile()
    {
        return $this->belongsTo(AnonymousUser::class);
    }
}
