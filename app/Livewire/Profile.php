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

    public $city = null;


    protected $rules = [
        'name' => 'required',
        'city' => 'required',
    ];

    protected $messages = [
        'name.required' => 'Le nom est requis',
        'city.required' => 'La ville est requise',
    ];

    protected $listeners = ['autocomplete_did_change.profile' => 'selectCity'];


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

            return redirect()->route('search', ['profile_id' => $profile->id]);
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function render()
    {
        $filtersvaluesvm = FiltersValuesViewModel::make();

        return view('livewire.profile', [
        ]);
    }
}
