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
    ];

    protected $messages = [
        'name.required' => 'Le nom est requis',
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
        $city = City::find($cityId);
        if ($city) {
            $this->searchCity = $city->name;
            $this->selectedCity = $city->id;
            $this->canton = $city->municipality->district->canton->id ?? null;
            $this->citie = $city->id;
            $this->city = $city->name;
            $this->npa = $city->npa;
            $this->cities = []; // Masquer la liste après sélection
        }
    }

    public function createProfile()
    {
        $this->validate();

        try {
            $profile = CreateProfileAction::make()->execute(
                $this->name,
                $this->canton,
                $this->citie,
                $this->city,
                $this->npa
            );

            // Réinitialisation des champs après création
            $this->reset(['name', 'searchCity', 'selectedCity', 'canton', 'citie', 'city', 'npa']);

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
