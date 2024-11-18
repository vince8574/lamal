<?php

namespace App\Actions;

use App\AnonymousUser;
use App\Models\AnonymousUser as ModelsAnonymousUser;
use App\Models\Profile;

class DeleteProfileAction
{

    public function __construct(protected AnonymousUser $user_service) {}

    public function execute(string $name, ?AnonymousUser $user = null)
    {
        $user ??= $this->user_service->getCurrentUser();

        // Trouver le profil correspondant aux critères
        $profile = Profile::where([
            'name' => $name,
            'anonymous_user_id' => $user->getKey()
        ])->first();

        // Vérifier si le profil existe, puis le supprimer
        if ($profile) {
            return $profile->delete();
        }

        return false; // Retourner false ou gérer le cas où le profil n'existe pas
    }
}
