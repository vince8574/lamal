<?php

namespace App\Actions;

use App\AnonymousUser;
use App\Facades\AnonymousUser as UserService;
use App\Models\Card;

class SaveCardAction
{
    public function __construct(protected AnonymousUser $user_service) {}

    // public static function make(...$args){
    // return app()->make(static::class, $args);
    // }
    public static function make()
    {
        return app()->make(static::class);
    }

    public function execute(string $prime_id, int $profile_id): ?Card
    {
        // $user ??= UserService::getCurrentUser();

        // $user ??= $this->user_service->getCurrentUser();
        $existing = Card::where('profile_id', $profile_id)->where('prime_id', $prime_id)->first();
        if (! $existing) {
            return Card::create([
                'prime_id' => $prime_id,
                'profile_id' => $profile_id,
                // 'profile_id' => $user->getKey()
            ]);
        }

        $existing->delete();

        return null;
    }
}
