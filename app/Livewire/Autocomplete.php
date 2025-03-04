<?php

namespace App\Livewire;

use App\Models\City;
use App\Models\Profile;
use Livewire\Component;

class Autocomplete extends Component
{

    protected $listeners = ['profileChanged'];

    public ?int $profile_id=null;
    public string $searchedValue = '';
    public string $selectedValue;
    public string $event_key;

    public function getProfile(){
        return Profile::find($this->profile_id);
    }

    public function getProfileFilter(){
        return $this->getProfile()?->filter ?? [];
    }


    public function getSelectedCityProperty(){
        return City::find($this->getProfileFilter()['city']??null);
    }

    public function profileChanged($value)
    {
        $this->profile_id = $value;
        if($this->selected_city){
            $this->searchedValue = $this->selected_city->name;
            $this->selectedValue = $this->selected_city->id;
        }
    }


    public function mount(){
        $this->profileChanged($this->profile_id);
    }

  


    public function getCitiesProperty()
    {

        return City::with(['municipality.district.canton'])
            ->where('name', 'LIKE', "%{$this->searchedValue}%")
            ->orWhere('npa', 'LIKE', "%{$this->searchedValue}%")
            ->orWhereHas('municipality', function ($query) {
                $query->where('name', 'LIKE', "%{$this->searchedValue}%")
                    ->orWhereHas('district', function ($query) {
                        $query->where('name', 'LIKE', "%{$this->searchedValue}%")
                            ->orWhereHas('canton', function ($query) {
                                $query->where('name', 'LIKE', "%{$this->searchedValue}%");
                            });
                    });
            })
            ->limit(10)
            ->get();
    }

    public function render()
    {
        return view('livewire.autocomplete');
    }

    public function selectValue($value)
    {
        $this->selectedValue = $value;

        $city = City::find($value);
        $this->searchedValue = $city->name;
        $this->dispatch('autocomplete_did_change.'.$this->event_key, value: $value);
    }
}
