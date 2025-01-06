<?php

namespace App\Livewire;

use App\Actions\CreateProfileAction;
use Exception;
use Livewire\Component;

class Base extends Component
{
    public $name = '';
    public $canton = '';

    public function createProfile()
    {

        try {

            CreateProfileAction::make()->execute($this->name, $this->canton);
            $this->name = '';
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }



    public function render()
    {
        return view('livewire.base');
    }
}
