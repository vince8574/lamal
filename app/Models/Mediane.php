<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mediane extends Model
{
    use HasFactory;

    protected $fillable = [
        'canton_id',
        'age_range_id',
        'franchise_id',
        'tariftype_id',
        'accident',
        'count',
        'median_value',
        'type'

    ];

    public function canton()
    {
        return $this->belongsTo(Canton::class);
    }

    public function ageRange()
    {
        return $this->belongsTo(AgeRange::class);
    }

    public function franchise()
    {
        return $this->belongsTo(Franchise::class);
    }

    public function tariftype()
    {
        return $this->belongsTo(Tariftype::class);
    }
}
