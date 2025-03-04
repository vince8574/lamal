<?php

namespace App\Livewire;

use App\Models\City;
use Livewire\Component;

class Autocomplete extends Component
{
    public string $searchedValue='';

    public $selectedValue;

    public function getCitiesProperty(){

        return City::with(['municipality.district.canton'])
        ->where('name', 'LIKE', "%{$this->searchedValue}%")
        ->orWhere('npa', 'LIKE', "%{$this->searchedValue}%")
        ->limit(10)
        ->get();
    }
    

    public function render()
    {
        return view('livewire.autocomplete');
    }

    public function selectValue($value){
        $this->selectedValue = $value;

        $city = City::find($value);
        $this->searchedValue = $city->name;
        $this->dispatch('autocomplete_did_change', value: $value);
    }
}
