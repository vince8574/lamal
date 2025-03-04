<?php

namespace App\Http\Controllers;

use App\Actions\CreateProfileAction;
use App\Actions\SaveCardAction;
use App\DTO\SearchFilter;
use App\Facades\AnonymousUser;
use App\Models\Canton;
use App\Models\Card;
use App\Models\Franchise;
use App\Models\Profile;
use App\ViewModels\FiltersValuesViewModel;
use App\ViewModels\FranchiseViewModel;
use App\ViewModels\SearchViewModel;
use Illuminate\Http\Request;

class OuilleController extends Controller
{
    public function index(Request $request)
    {
        $user =  AnonymousUser::getCurrentUser();
        if($user ){
            if(AnonymousUser::getProfiles()->count() > 0){
                return redirect(route('search',['profile_id'=>AnonymousUser::getProfiles()->first()]));
            }
        }

        $current_canton = $request->get('canton');
        $cantons = Canton::orderBy('name')->get();
        $current_user = $request->get('name');

        $request->validate([
            'name' => ['string', 'min:3'],
        ]);

        return view('welcome', [
            'cantons' => $cantons,
            'user_name' => $current_user,
            'canton' => $current_canton,
        ]);
    }

    public function search(Request $request, CreateProfileAction $create)
    {
        $id = $request->get('profile_id');

        $profiles = Profile::where('anonymous_user_id', AnonymousUser::getCurrentUser()->id)->get();

        if ($profiles->isEmpty()) {
            return redirect(route('home'));
        }
        $currentProfile = Profile::where('anonymous_user_id', AnonymousUser::getCurrentUser()->id)->where('id', $id)->first();

        // si le profil n'existe pas on redirige sur le premier
        if (! $currentProfile) {
            $currentProfile = $profiles->first();
            $request->session()->reflash();

            return redirect(route('search', ['profile_id' => $currentProfile->id, ]));
        }

        return view('base');
    }

    public function result(Request $request)
    {
        $current_age = $request->get('age');
        $franchises = Franchise::when(filled($current_age), function ($q) use ($current_age) {

            $q->whereHas('primes', function ($q) use ($current_age) {
                $q->where('age_range_id', $current_age);
            });
        })->orderBy('key')->get();

        $current_franchise = $request->get('franchise');
        // si la franchise existe pas avec l'age actuel on ignore
        if ($franchises->where('id', $current_franchise)->count() == 0) {
            $current_franchise = null;
        }

       
        $cards = Card::orderBy('id')->get();
        $profiles = Profile::orderBy('id')->get();

        return view('selection', [

            'cards' => $cards,
            'profiles' => $profiles,
        ]);
    }

    public function createUser(Request $request)
    {
        $request->validate([
            'name' => ['string', 'min:3'],
        ]);

        $profile = CreateProfileAction::make()->execute($request->get('name'),$request->get('city'));

        return redirect(route('search', ['profile_id' => $profile->id]));
    }

    // public function cardSelect(int $prime_id, int $profile_id, bool $select)
    // {

    //     if ($select) {
    //         SaveCardAction::make()->execute($prime_id, $profile_id);
    //     } else DeleteCardAction::make()->execute();
    //     $select = !$select;
    //     return redirect(route('search', ['profile_id' => $profile_id, 'selected' => $select]));
    // }
    public function cardSelect(Request $request)
    {
        // $select = $request->get('select');
        $prime_id = $request->get('prime_id');
        $profile_id = $request->get('profile_id');
        SaveCardAction::make()->execute($prime_id, $profile_id);
        // } else DeleteCardAction::make()->execute();
        //   $select = !$select;

        // return redirect(route('search', ['profile_id' => $profile_id]));
        return redirect()->back();
    }
}
