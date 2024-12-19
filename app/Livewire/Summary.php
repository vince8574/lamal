<?php

namespace App\Livewire;

use App\Models\Card;
use Livewire\Attributes\Url;
use Livewire\Component;

class Summary extends Component
{
    protected $listeners = ['cardUpdated' => '$refresh'];


    public function render()
    {

        return view('livewire.summary', ['cards' => Card::orderBy('id')->get()]);
    }
}
