<?php

namespace App\ViewModels;

use App\Models\Franchise;
use KDA\Laravel\Viewmodel\ViewModel;

class FranchiseViewModel extends ViewModel
{
    //

    public function __construct(protected ?int $age_id) {}

    public function getFranchises()
    {

        return Franchise::when(filled($this->age_id), function ($q) {

            $q->whereHas('primes', function ($q) {
                $q->where('age_range_id', $this->age_id);
            });
        })->orderBy('key')->get();
    }
}
