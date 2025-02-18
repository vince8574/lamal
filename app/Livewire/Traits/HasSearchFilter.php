<?php

namespace App\Livewire\Traits;

use App\DTO\SearchFilter;
use App\DTO\SearchFilterForm;
use Livewire\Attributes\Url;

trait HasSearchFilter
{
    #[Url()]
    public $filter;

    public function getFilter(): SearchFilter
    {
        $filterData = array_merge([
            'accident' => false, // Valeur par défaut
        ], $this->filter ?? []);

        return SearchFilter::fromForm(
            SearchFilterForm::from(
                $filterData
            )
        );
    }
}
