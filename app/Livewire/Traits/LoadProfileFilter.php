<?php

namespace App\Livewire\Traits;


use Livewire\Attributes\Url;
use App\Models\Profile;

trait LoadProfileFilter
{
    public function loadProfileFilter()
    {
        $profile = Profile::find($this->profile_id);
        if ($profile) {

            $this->filter = $profile->filter;
        }
    }
    
}
