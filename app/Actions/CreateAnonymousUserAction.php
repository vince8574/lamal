<?php

namespace App\Actions;

use App\Models\AnonymousUser;

class CreateAnonymousUserAction
{
    public $token_id;

    public function __construct() {}

    public static function make()
    {
        return app()->make(static::class);
    }

    public function execute(string $token): AnonymousUser
    {
        return AnonymousUser::firstOrCreate([
            'token' => $token,

        ]);
    }
}
