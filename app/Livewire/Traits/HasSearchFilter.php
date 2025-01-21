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
        return SearchFilter::fromForm(
            SearchFilterForm::from(
                $this->filter,
            )
        );
    }
}
