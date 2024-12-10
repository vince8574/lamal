<?php

namespace App\Livewire;

use App\Actions\CreateProfileAction;
use Exception;
use Livewire\Component;

class Profile extends Component
{
    public $name = '';

    public function createProfile()
    {

        try {
            dump($this->name);
            CreateProfileAction::make()->execute($this->name);
            $this->name = '';
        } catch (Exception  $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.profile');
    }
}
