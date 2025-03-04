<?php

namespace App\Actions;

use App\AnonymousUser;
use App\Models\Card;

class DeleteCardAction
{
    public function __construct(protected AnonymousUser $user_service) {}

    public static function make()
    {
        return app()->make(static::class);
    }

    public function execute(string $name, ?AnonymousUser $user = null)
    {
        $user ??= $this->user_service->getCurrentUser();

        // Trouver le profil correspondant aux critères
        $card = Card::where([
            'name' => $name,
            'anonymous_user_id' => $user->getKey(),
        ])->first();

        // Vérifier si le profil existe, puis le supprimer
        if ($card) {
            return $card->delete();
        }

        return false; // Retourner false ou gérer le cas où le profil n'existe pas
    }
}
