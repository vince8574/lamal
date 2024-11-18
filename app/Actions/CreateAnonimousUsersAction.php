<?php

namespace App\Actions;


use App\Models\AnonymousUser;

class CreateAnonymousUserAction
{
    public $token_id;


    public function __construct() {}
    public static function make(string $token_id)
    {
        return app()->make(static::class, [$token_id]);
    }
    public function execute(string $token_id): AnonymousUser
    {
        return AnonymousUser::create([
            'token_id' => $token_id

        ]);
    }
}
