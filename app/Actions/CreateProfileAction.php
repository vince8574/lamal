<?php

namespace App\Actions;

use App\AnonymousUser;
use App\Models\AnonymousUser as ModelsAnonymousUser;
use App\Models\Profile;

class CreateProfileAction
{

    public function __construct(protected AnonymousUser $user_service) {}
    public static function make(string $canton, string $age_range, bool $accident, int $franchise, string $insurer_model)
    {
        return app()->make(static::class, [$canton, $age_range, $accident, $franchise, $insurer_model]);
    }
    public function execute(string $name, ?AnonymousUser $user = null): Profile
    {
        $user ??= $this->user_service->getCurrentUser();
        return Profile::create([
            'name' => $name,
            'anonymous_user_id' => $user->getKey()
        ]);
    }
}
