<?php

namespace App\Policies;

use App\Models\AnonymousUser;
use App\Models\Profile;

class ProfilePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function delete(AnonymousUser $user, Profile $profile)
    {

        dump('hello');
    }
}
