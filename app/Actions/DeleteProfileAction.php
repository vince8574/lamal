<?php

namespace App\Actions;

use App\AnonymousUser;
use App\Facades\AnonymousUser as FacadesAnonymousUser;
use App\Models\AnonymousUser as ModelsAnonymousUser;
use App\Models\Card;
use App\Models\Profile;
use Exception;

class DeleteProfileAction
{

    public function __construct() {}
    public static function make()
    {
        return app()->make(static::class);
    }


    public function execute(int $profileId): void
    {

        $profiles = FacadesAnonymousUser::getProfiles();
        if ($profiles->count() == 1) {
            throw new Exception('Vous ne pouvez pas supprimer votre dernier profil');
        }
        $profile = Profile::where('anonymous_user_id', FacadesAnonymousUser::getCurrentUser()->id)->where('id', $profileId)->first();

        Card::where('profile_id', $profile->id)->delete();
        $profile->delete();
    }
}
