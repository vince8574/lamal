<?php

namespace App\Livewire;

use App\Models\Card;
use Livewire\Component;

class Summary extends Component
{
    public function render()
    {
        return view('livewire.summary', ['cards' => Card::orderBy('id')->get()]);
    }
}
