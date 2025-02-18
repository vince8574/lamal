<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Municipality extends Model
{
    protected $fillable = ['name', 'district_id', 'ofs_number'];

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }
}
