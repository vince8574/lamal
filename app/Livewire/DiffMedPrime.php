<?php

namespace App\Livewire;

use Livewire\Component;
use App\Livewire\Traits\CalculDiff;

class PrimeCard extends Component
{
    public $prime;
    public $medianeData;

    public function mount($prime)
    {
        $this->prime = $prime;
        $this->medianeData = CalculDiff::calculateMedianDifference($prime);
    }

    public function render()
    {
        return view('livewire.selection');
    }
}
