<?php

namespace App\ViewModels;

use App\DTO\SearchFilter;
use App\Models\Prime;
use KDA\Laravel\Viewmodel\ViewModel;

class SearchViewModel extends ViewModel
{
    //

    public function __construct(protected int $current_profile_id, protected SearchFilter $filter) {}

    public function getPrimes()
    {

        return Prime::query()
            ->with(['insurer', 'franchise', 'canton'])
            ->when(filled($this->filter->franchise), fn ($query) => $query->where('franchise_id', $this->filter->franchise))
            ->when(filled($this->filter->age), fn ($query) => $query->where('age_range_id', $this->filter->age))
            ->when(filled($this->filter->canton), fn ($query) => $query->where('canton_id', $this->filter->canton))
            ->when(filled($this->filter->region_code), fn ($query) => $query->where('region_code', $this->filter->region_code))
            // ->when(filled($current_accident), fn($query) => $query->where('accident', $current_accident))
            ->where('accident', $this->filter->accident)
            ->when(filled($this->filter->tariftype), fn ($query) => $query->where('tariftype_id', $this->filter->tariftype))
            ->orderBy('cost')->paginate(10)->withQueryString();
    }
}
