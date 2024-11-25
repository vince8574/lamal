<?php

namespace App\Actions;

use App\AnonymousUser;
use App\Models\Card;
use App\Facades\AnonymousUser as UserService;


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
    public function execute(string $prime_id, int $profil_id): ?Card
    {
        // $user ??= UserService::getCurrentUser();

        // $user ??= $this->user_service->getCurrentUser();
        $existing = Card::where('profil_id', $profil_id)->where('prime_id', $prime_id)->first();
        if (!$existing) {
            return Card::create([
                'prime_id' => $prime_id,
                'profil_id' => $profil_id
                // 'profil_id' => $user->getKey()
            ]);
        }

        $existing->delete();
        return null;
    }
}
