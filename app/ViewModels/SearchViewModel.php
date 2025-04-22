<?php

namespace App\ViewModels;

use App\DTO\SearchFilter;
use App\Models\City;
use App\Models\Prime;
use App\Models\Mediane;
use KDA\Laravel\Viewmodel\ViewModel;

class SearchViewModel extends ViewModel
{
    //

    public function __construct(protected int $current_profile_id, protected SearchFilter $filter) {}

    public function getPrimes()
    {

        $city = City::find($this->filter->city);

        $canton = $city?->municipality->district->canton;

        $region_code = $city?->region_code;

        $primes =  Prime::query()
            ->with(['insurer', 'franchise', 'canton', 'tariftype'])
            ->when(filled($this->filter->franchise), fn($query) => $query->where('franchise_id', $this->filter->franchise))
            ->when(filled($this->filter->age), function ($query) {

                $query->whereHas('age_range', function ($query) {
                    $query->where('id', $this->filter->age);
                });
            })


            //      ->when(filled($this->filter->canton), fn ($query) => $query->where('canton_id', $this->filter->canton))
            //     ->when(filled($this->filter->region_code), fn ($query) => $query->where('region_code', $this->filter->region_code))
            // ->when(filled($current_accident), fn($query) => $query->where('accident', $current_accident))
            ->where('accident', $this->filter->accident)
            ->when(filled($this->filter->tariftype), fn($query) => $query->where('tariftype_id', $this->filter->tariftype))
            ->when(filled($canton), fn($query) => $query->where('canton_id', $canton->id))
            ->when(filled($region_code), fn($query) => $query->where('region_code', $region_code))
            ->orderBy('cost')->paginate(10)->withQueryString();

        //Recherche de la médiane correspondante
        $mediane = Mediane::where('type', 'by_filters')
            ->when(filled($this->filter->franchise), fn($query) => $query->where('franchise_id', $this->filter->franchise))
            ->when(filled($this->filter->age), fn($query) => $query->where('age_range_id', $this->filter->age))
            ->when(filled($this->filter->tariftype), fn($query) => $query->where('tariftype_id', $this->filter->tariftype))
            ->when(filled($canton), fn($query) => $query->where('canton_id', $canton->id))
            ->where('accident', $this->filter->accident)
            ->first();

        //Ajout de la médiane à chaque prime
        foreach ($primes as $prime) {
            if ($mediane) {
                $prime->difference = $prime->cost - $mediane->median_value;
                $prime->median_value = $mediane->median_value;
                // Calculer le pourcentage de différence
                $prime->difference_percent = $mediane->median_value > 0
                    ? round(($prime->difference / $mediane->median_value) * 100, 1)
                    : 0;
            } else {
                $prime->difference = 0;
                $prime->median_value = null;
                $prime->difference_percent = 0;
            }
        }
        return $primes;
    }
}
