<?php

namespace App\Livewire;

use App\Actions\CreateProfileAction;
use App\ViewModels\FiltersValuesViewModel;
use Exception;
use Livewire\Attributes\Url;
use Livewire\Component;

class Profile extends Component
{
    public $name = '';
    public $canton = '';

    protected $rules = [
        'name' => 'required',
    ];

    protected $messages = [
        'name.required' => 'Le nom est requis',
    ];
    public function createProfile()
    {
        $this->validate();
          

        try {

            CreateProfileAction::make()->execute($this->name, $this->canton ? (int)$this->canton : null);
            $this->name = '';
            $this->canton = '';
            return redirect()->route('search');
        } catch (Exception  $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function render()
    {
        $filtersvaluesvm = FiltersValuesViewModel::make();
        return view('livewire.profile', [
            ...$filtersvaluesvm->all(),
        ]);
    }
}
