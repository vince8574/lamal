<?php

namespace App\Livewire;

use App\ViewModels\FiltersValuesViewModel;
use Livewire\Attributes\Url;
use Livewire\Component;

class SearchForm extends Component
{
    #[Url()]
    public int $profile_id;

    #[Url()]
    public int $canton;



    public function render()
    {
        $filtersvaluesvm = FiltersValuesViewModel::make();
        return view('livewire.search-form', [
            ...$filtersvaluesvm->all()
        ]);
    }
}
