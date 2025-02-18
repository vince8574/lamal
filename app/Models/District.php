<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $fillable = ['name', 'canton_id'];

    public function canton()
    {
        return $this->belongsTo(Canton::class, 'canton_id');
    }
}
