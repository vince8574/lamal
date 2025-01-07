<?php

namespace App\Actions;

use App\Facades\AnonymousUser as UserService;
use App\Models\AnonymousUser as AnonymousUser;
use App\Models\Profile;

class CreateProfileAction
{


    public function __construct() {}
    public static function make()
    {
        return app()->make(static::class);
    }
    public function execute(string $name, int $canton,  ?AnonymousUser $user = null): Profile
    {

        $user ??= UserService::getCurrentUser();
        $filter = ['canton' => $canton];

        return Profile::create([
            'name' => $name,
            'filter' => $filter,
            'anonymous_user_id' => $user->getKey()
        ]);
    }
}
