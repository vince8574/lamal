<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Citie extends Model
{
    protected $fillable = ['name', 'npa', 'municipality_id', 'region_code'];

    public function municipalitie()
    {
        return $this->belongsTo(Municipalitie::class, 'municipality_id');
    }

    public function district()
    {
        return $this->hasOneThrough(District::class, Municipalitie::class, 'id', 'id', 'municipality_id', 'district_id');
    }

    public function canton()
    {
        return $this->hasOneThrough(Canton::class, District::class, 'id', 'id', 'district_id', 'canton_id');
    }
}
