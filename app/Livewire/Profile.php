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



    public function createProfile()
    {
        $this->validate([
            'name' => 'required',
        ]);

        try {

            CreateProfileAction::make()->execute($this->name, $this->canton ? (int)$this->canton : null);
            $this->name = '';
            $this->canton = '';
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
