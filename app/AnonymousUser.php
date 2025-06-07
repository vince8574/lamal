<?php

namespace App;

use App\Models\AnonymousUser as UserModel;
use App\Models\Profile;
use Illuminate\Http\Request;

class AnonymousUser
{

    public function getProvidedToken(): ?string
    {
        $authHeader = request()->header('X-ANONYMOUS-TOKEN');
        if ($authHeader) {
            return $authHeader;
        }

        return request()->cookie('token');
    }

    public function getToken(): string
    {
        return $this->getProvidedToken();
    }

    public function getCurrentUser(): UserModel
    {
        return UserModel::where('token', $this->getToken())->sole();
    }

    public function getProfiles()
    {
        return Profile::where('anonymous_user_id', $this->getCurrentUser()->id)->get();
    }
}
