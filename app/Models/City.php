<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = ['name', 'npa', 'municipality_id', 'region_code'];

    public function municipality()
    {
        return $this->belongsTo(Municipality::class, 'municipality_id');
    }

    public function district()
    {
        return $this->hasOneThrough(District::class, Municipality::class, 'id', 'id', 'municipality_id', 'district_id');
    }

    public function canton()
    {
        return $this->hasOneThrough(Canton::class, District::class, 'id', 'id', 'district_id', 'canton_id');
    }
}
