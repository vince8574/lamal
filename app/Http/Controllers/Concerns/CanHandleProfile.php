<?php

namespace App\Http\Controllers\Concerns;

use App\Actions\CreateAnonymousUserAction;
use App\Actions\CreateProfileAction;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Prime;
use App\Models\Profile;
use App\Models\Card;
use App\Models\Tariftype;
use App\Models\Franchise;
use App\Models\Region;
use App\Http\Controllers\Controller;
use App\Facades\AnonymousUser as UserService;
use App\Models\AnonymousUser;
use Exception;

trait CanHandleProfile
{


    public function getProfiles(Request $request) {}



    public function getProfile(Request $request, $profile_id)
    {
        // GET /profile/{uid} - Récupérer un profil
        try {
            $user = UserService::getCurrentUser();
            if (blank($user)) {
                throw new Exception("Anonymous account not found");
            }
            $profile = Profile::where('id', $profile_id)
                ->whereHas('anonymousUser', function ($q) use ($user) {
                    $q->where('id', $user->id)
                        ->whereHas('owner', function ($q) {
                            $q->where('id', auth()->user()->getKey());
                        });
                });

            if (!$profile) {
                return abort(404);
            }

            return response()->json($profile);
        } catch (Exception $e) {
            return abort(400);
        }
    }

    public function createProfile(Request $request)
    {
        // 1. Récupérer le anonymous user actuel ou le créér,
        /*   $user = UserService::getCurrentUser();
        if (!$user) {
            $user = CreateAnonymousUserAction::make()->execute();
        }
*/

        $token = UserService::getProvidedToken();

        $user = CreateAnonymousUserAction::make()->execute($token);



        // POST /profile - Créer un profil
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|integer|max:255',


        ]);



        $profile = CreateProfileAction::make()->execute(
            $request->get('name'),
            $request->get('city'),
            $user,

        );


        return response()->json(
            [
                "uid" => $user->token,
                "profile" => $profile
            ],
            201
        );
    }

    public function updateProfile(Request $request, $profile_id)
    {
        // PUT /profile/{uid} - Mettre à jour un profil
        // $profile = Profile::where('profile_id', $profile_id)->first();

        // if (!$profile) {
        //     return response()->json(['message' => 'Profil non trouvé'], 404);
        // }

        // $validatedData = $request->validate([
        //     'name' => 'sometimes|string|max:255',
        //     'age' => 'sometimes|integer|min:0|max:120',
        //     'canton' => 'sometimes|string|max:255',
        //     'region' => 'sometimes|string|max:255',
        //     'franchise' => 'nullable|string',
        //     'owner_id' => 'nullable|integer',
        // ]);

        try {
            $user = UserService::getCurrentUser();
            if (blank($user)) {
                throw new Exception("Anonymous account not found");
            }

            $profile = Profile::where('id', $profile_id)
                ->whereHas('anonymousUser', function ($q) use ($user) {
                    $q->where('id', $user->id)
                        ->whereHas('owner', function ($q) {
                            $q->where('id', auth()->user()->getKey());
                        });
                })->first(); // Add ->first() here too!

            if (!$profile) {
                return abort(404);
            }



            $profile->update($request->all());

            return response()->json([
                'uid' => $user->token,
                'profile' => $profile
            ]);
        } catch (Exception $e) {
            return abort(400);
        }

        // $profile->update($validatedData);

        // return response()->json($profile);
    }

    public function deleteProfile(Request $request, $profile_id)
    {
        try {
            $user = UserService::getCurrentUser();
            if (blank($user)) {
                throw new Exception("Anonymous account not found");
            }

            $profile = Profile::where('id', $profile_id)
                ->whereHas('anonymousUser', function ($q) use ($user) {
                    $q->where('id', $user->id)
                        ->whereHas('owner', function ($q) {
                            $q->where('id', auth()->user()->getKey());
                        });
                })->first();

            if (!$profile) {
                return abort(404);
            }

            $profile->delete();

            return response()->json([
                'message' => 'Profil supprimé avec succès',
                'uid' => $user->token
            ]);
        } catch (Exception $e) {
            return abort(400);
        }
    }
}
