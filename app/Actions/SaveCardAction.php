<?php

namespace App\Actions;

use App\AnonymousUser;
use App\Models\Card;


class SaveCardAction
{

    public function __construct(protected AnonymousUser $user_service) {}

    // public static function make(...$args){
    // return app()->make(static::class, $args);
    // }
    public static function make(float $prime_coast, string $canton, string $insurer, string $model, float $franchise, string $tarif_name, bool $accident)
    {
        return app()->make(static::class, [$prime_coast, $canton, $insurer, $model, $franchise, $tarif_name, $accident]);
    }
    public function execute(string $id, ?AnonymousUser $user = null): Card
    {
        $user ??= $this->user_service->getCurrentUser();
        return Card::create([
            'name' => $id,
            'anonymous_user_id' => $user->getKey()
        ]);
    }
}
