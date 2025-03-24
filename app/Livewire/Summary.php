<?php

namespace App\Livewire;

use App\Facades\AnonymousUser;
use App\Models\Card;
use App\Models\Profile;
use Livewire\Component;

class Summary extends Component
{
    protected $listeners = ['cardUpdated' => '$refresh'];

    public function render()
    {

        return view('livewire.summary', [
            'cards' => Card::orderBy('id')->get(),
            'profiles' => Profile::all()]);
    }
}
