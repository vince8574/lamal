<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Canton;
use App\Actions\CreateProfileAction;
use App\Models\AgeRange;
use App\Models\Profile;
use App\Facades\AnonymousUser;
use App\Models\Franchise;
use App\Models\Insurer;
use App\Models\Prime;
use App\Models\Tariftype;
use App\Models\Card;
use App\Actions\SaveCardAction;
use App\Actions\DeleteCardAction;
use App\DTO\SearchFilter;
use App\ViewModels\FranchiseViewModel;
use App\ViewModels\SearchViewModel;

class OuilleController extends Controller
{
    public function index(Request $request)
    {
        $current_canton = $request->get('canton');
        $cantons = Canton::orderBy('name')->get();
        $current_user = $request->get('name');

        $request->validate([
            'name' => ['string', 'min:3']
        ]);



        return view('welcome', [
            'cantons' => $cantons,
            'user_name' => $current_user,
            'canton' => $current_canton
        ]);
    }

    public function search(Request $request, CreateProfileAction $create)
    {
        // dump(AnonymousUser::getCurrentUser());
        // $name = $request->get('name');

        // Récupération des boutons existants dans la session
        // $buttons = session()->get('buttons', []);

        // Si on vient de la page d'accueil (pas de boutons dans la session), on réinitialise
        // if (!$request->has('name') && empty($buttons)) {
        // session()->forget('buttons');
        // }

        // Ajouter un nouveau bouton si un nom est envoyé et éviter les doublons
        // if (!empty($name) && !in_array($name, $buttons)) {
        // $buttons[] = $name;
        // session()->put('buttons', $buttons);
        // }

        //$create->execute(...$args)
        //CreateProfileAction::make()->execute();

        // getTabs

        $profiles = Profile::where('anonymous_user_id', AnonymousUser::getCurrentUser()->id)->get();
        $id = $request->get('profile_id');
        $currentProfile = Profile::where('anonymous_user_id', AnonymousUser::getCurrentUser()->id)->where('id', $id)->first();
        if (!$currentProfile) {
            $currentProfile = $profiles->first();
            $request->session()->reflash();
            return redirect(route('search', ['profile_id' => $currentProfile->id]));
        }
        $current_age = $request->get('age');
        $ages = AgeRange::orderBy('key')->get();

        $franchiseVm = FranchiseViewModel::make($current_age);
        /*$franchises = Franchise::when(filled($current_age), function ($q) use ($current_age) {

            $q->whereHas('primes', function ($q) use ($current_age) {
                $q->where('age_range_id', $current_age);
            });
        })->orderBy('key')->get();

*/
        $current_franchise = $request->get('franchise');
        // si la franchise existe pas avec l'age actuel on ignore 
        if ($franchiseVm->getFranchises()->where('id', $current_franchise)->count() == 0) {
            $current_franchise = null;
        }

        $current_canton = $request->get('canton');
        $cantons = Canton::orderBy('name')->get();
        $insurers = Insurer::orderBy('name')->get();
        $current_accident = filled($request->get('accident')); //pour avoir un bool
        $current_tariftype = $request->get('tarif_type');
        $tariftypes = Tariftype::orderBy('label')->get();
        // $cards = Card::orderBy('id')->get();
        $primes = Prime::query()
            ->with(['insurer', 'franchise', 'canton'])
            ->when(filled($current_franchise), fn($query) => $query->where('franchise_id', $current_franchise))
            ->when(filled($current_age), fn($query) => $query->where('age_range_id', $current_age))
            ->when(filled($current_canton), fn($query) => $query->where('canton_id', $current_canton))
            // ->when(filled($current_accident), fn($query) => $query->where('accident', $current_accident))
            ->where('accident', $current_accident)
            ->when(filled($current_tariftype), fn($query) => $query->where('tariftype_id', $current_tariftype))
            ->orderBy('cost')->paginate(10)->withQueryString();



        $filter = SearchFilter::from(
            [
                'canton' => $current_canton,
                'age' => $current_age,
                'franchise' => $current_franchise,
                'tariftype' => $current_tariftype,
                'accident' => $current_accident,
            ]
        );
        $vm = SearchViewModel::make($currentProfile->id, $filter);
        //  dump($vm->all());
        return view('base', [
            ...$vm->all(),
            'cantons' => $cantons,
            'ages' => $ages,
            ...$franchiseVm->all(),
            // 'primes' => $primes,
            'insurers' => $insurers,
            'tariftypes' => $tariftypes,
            'cards' => $currentProfile->cards,

            'canton' => $current_canton,
            'profiles' => $profiles,
            'current_profile_id' => $currentProfile->id
        ]);
    }

    public function result(Request $request)
    {
        $current_age = $request->get('age');
        $ages = AgeRange::orderBy('key')->get();
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

        $current_canton = $request->get('canton');
        $current_canton_key = Canton::where('name', $current_canton)->value('key');
        $cantons = Canton::orderBy('name')->get();
        $insurers = Insurer::orderBy('name')->get();
        $current_accident = filled($request->get('accident')); //pour avoir un bool
        $current_tariftype = $request->get('tarif_type');
        $tariftypes = Tariftype::orderBy('label')->get();
        $cards = Card::orderBy('id')->get();
        $profiles = Profile::orderBy('id')->get();

        $primes = Prime::query()
            ->with(['insurer', 'franchise', 'canton'])
            ->when(filled($current_franchise), fn($query) => $query->where('franchise_id', $current_franchise))
            ->when(filled($current_age), fn($query) => $query->where('age_range_id', $current_age))
            ->when(filled($current_canton_key), fn($query) => $query->where('canton_id', $current_canton_key))
            // ->when(filled($current_accident), fn($query) => $query->where('accident', $current_accident))
            ->where('accident', $current_accident)
            ->when(filled($current_tariftype), fn($query) => $query->where('tariftype_id', $current_tariftype))
            ->orderBy('cost')->paginate(10)->withQueryString();

        return view('selection', [
            'cantons' => $cantons,
            'ages' => $ages,
            'franchises' => $franchises,
            'primes' => $primes,
            'insurers' => $insurers,
            'tariftypes' => $tariftypes,
            'cards' => $cards,
            'profiles' => $profiles
        ]);
    }

    public function createUser(Request $request)
    {
        $request->validate([
            'name' => ['string', 'min:3']
        ]);

        $profile = CreateProfileAction::make()->execute($request->get('name'));
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
