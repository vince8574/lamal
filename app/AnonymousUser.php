<?php

namespace App;

use App\Models\AnonymousUser as UserModel;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class AnonymousUser
{
    protected $request;

    public function request(Request $request): static
    {
        $this->request = $request;
        return $this;
    }

    public function getToken(): string
    {
        return request()->cookie('token');
    }

    public function getCurrentUser(): UserModel
    {
        return UserModel::where('token', $this->getToken())->sole();
    }

    public function getProfiles()
    {
        return  Profile::where('anonymous_user_id', $this->getCurrentUser()->id)->get();
    }
}
