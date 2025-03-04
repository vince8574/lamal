<?php

namespace App\Livewire;

use App\Actions\CreateProfileAction;
use App\Models\City;
use App\ViewModels\FiltersValuesViewModel;
use Exception;
use LivewireUI\Modal\ModalComponent;

class Profile extends ModalComponent
{
    public bool $inModal = false;

    public $name = '';

    public $searchCity = '';

    public $cities = [];

    public $selectedCity = null;

    public $canton = null;

    public $citie = null;

    public $city = null;

    public $npa = null;

    protected $rules = [
        'name' => 'required',
        'city' => 'required',
    ];

    protected $messages = [
        'name.required' => 'Le nom est requis',
        'city.required' => 'La ville est requise',
    ];

    protected $listeners = ['autocomplete_did_change' => 'selectCity'];

    public function updatedSearchCity()
    {
        if (empty($this->searchCity)) {
            $this->cities = [];

            return;
        }

        // Rechercher les villes correspondant à l'entrée
        $this->cities = City::where('name', 'like', '%'.$this->searchCity.'%')
            ->orWhere('npa', 'like', '%'.$this->searchCity.'%')
            ->limit(10)
            ->get();
    }

    public function selectCity($value)
    {
        $cityId = $value;
        $this->city = $cityId;
    }

    public function createProfile()
    {
        $this->validate();

        try {
            $profile = CreateProfileAction::make()->execute(
                $this->name,
                $this->city,
            );

            // Réinitialisation des champs après création
       //     $this->reset(['name', 'searchCity', 'selectedCity', 'canton', 'citie', 'city', 'npa']);
            

            return redirect()->route('search', ['profile_id' => $profile->id]);
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function render()
    {
        $filtersvaluesvm = FiltersValuesViewModel::make();

        return view('livewire.profile', [
            ...$filtersvaluesvm->all(),
            'cities' => $this->cities,
        ]);
    }
}
