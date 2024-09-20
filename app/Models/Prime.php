<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prime extends Model
{
    use HasFactory;

    protected $fillable = [
        'canton',
        'year',
        'region_code',
        'age_range_id',
        'accident',
        'tarif',
        'franchise_class',
        'franchise_id',
        'cost',
        'tarif_name',
    ];

    public function insurer(){
        return this->belongsTo(Insurer::class);        
    }

    public function age_range(){
        return $this->belongsTo(AgeRange::class);
    }

    public function franchise(){
        return $this->belongsTo(Franchise::class);
    }
}
