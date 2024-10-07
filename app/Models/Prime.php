<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperPrime
 */
class Prime extends Model
{
    use HasFactory;

    protected $fillable = [

        'canton_id',
        'year',
        'region_code',
        'age_range_id',
        'accident',
        'tarif',
        'franchise_class',
        'franchise_id',
        'franchise_type',
        'cost',
        'tarif_name',
        'tariftype_id',
    ];

    public function insurer()
    {
        return $this->belongsTo(Insurer::class);
    }

    public function age_range()
    {
        return $this->belongsTo(AgeRange::class);
    }

    public function franchise()
    {
        return $this->belongsTo(Franchise::class);
    }

    public function canton()
    {
        return $this->belongsTo(Canton::class);
    }

    public function tariftype()
    {
        return $this->belongsTo(Tariftype::class);
    }
}
