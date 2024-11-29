<?php

namespace App\ViewModels;

use App\Models\Franchise;
use KDA\Laravel\Viewmodel\ViewModel;

class SearchViewModel extends ViewModel
{
    //

    public function __construct(protected int $current_profile_id) {}


    public function getFranchises()
    {

        return Franchise::when(filled($current_age), function ($q) use ($current_age) {

            $q->whereHas('primes', function ($q) use ($current_age) {
                $q->where('age_range_id', $current_age);
            });
        })->orderBy('key')->get();
    }
}
