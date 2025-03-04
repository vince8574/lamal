<?php

namespace App\Livewire\Traits;

use App\Livewire\Profile;
use Livewire\Attributes\Url;

trait LoadProfil
{
    #[Url()]

    public int $profile_id;
    public function loadProfileFilter()
    {
        $profile = Profile::find($this->profile_id);
        if ($profile) {

            $this->filter = $profile->filter;
        }
    }
}
