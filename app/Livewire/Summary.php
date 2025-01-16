<?php

namespace App\Livewire;

use App\Models\Card;
use Livewire\Attributes\Url;
use Livewire\Component;
use App\Facades\AnonymousUser;
use App\Models\Profile;

class Summary extends Component
{
    protected $listeners = ['cardUpdated' => '$refresh'];


    public function render()
    {

        return view('livewire.summary', [
            'cards' => Card::orderBy('id')->get(),
        'profiles' => Profile::where('anonymous_user_id', AnonymousUser::getCurrentUser()->id)->get()]);
    }
}
