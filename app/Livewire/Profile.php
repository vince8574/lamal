<?php

namespace App\Livewire;

use App\Actions\CreateProfileAction;
use App\Models\Citie;
use App\ViewModels\FiltersValuesViewModel;
use Exception;
use Livewire\Component;
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

    public function updatedSearchCity()
    {
        if (empty($this->searchCity)) {
            $this->cities = [];
            return;
        }

        // Rechercher les villes correspondant à l'entrée
        $this->cities = Citie::where('name', 'like', '%' . $this->searchCity . '%')
            ->orWhere('npa', 'like', '%' . $this->searchCity . '%')
            ->limit(10)
            ->get();
    }

    public function selectCity($cityId)
    {
        $city = Citie::find($cityId);
        if ($city) {
            $this->searchCity = $city->name;
            $this->selectedCity = $city->id;
            $this->canton = $city->municipalitie->district->canton->id ?? null;
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
            CreateProfileAction::make()->execute(
                $this->name,
                $this->canton,
                $this->citie,
                $this->city,
                $this->npa
            );

            // Réinitialisation des champs après création
            $this->reset(['name', 'searchCity', 'selectedCity', 'canton', 'citie', 'city', 'npa']);

            return redirect()->route('search');
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
