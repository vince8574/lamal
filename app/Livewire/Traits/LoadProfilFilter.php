<?php

namespace App\Livewire\Traits;


use Livewire\Attributes\Url;
use App\Models\Profile;

trait LoadProfileFilter
{
    #[Url()]

    public int $profile_id;
    public function profileFilter(): Profile
    {
        $profile = Profile::find($this->profile_id);
        if ($profile) {

            $this->filter = $profile->filter;
        }
        return $profile;
    }
}
