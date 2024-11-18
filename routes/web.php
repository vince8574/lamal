<?php

use App\Actions\CreateProfileAction;
use App\Models\AgeRange;
use Illuminate\Support\Facades\Route;
use App\Models\Canton;
use App\Models\Franchise;
use App\Models\Insurer;
use App\Models\Prime;
use App\Models\Tariftype;
use Illuminate\Http\Request;
use App\Facades\AnonymousUser;

Route::get('/', function (Request $request) {
    $current_canton = $request->get('canton');
    $cantons = Canton::orderBy('name')->get();
    $current_user = $request->get('name');

    return view('welcome', [
        'cantons' => $cantons,
        'user_name' => $current_user,
        'canton' => $current_canton
    ]);
})->name('home');

Route::middleware('web')->get('/search', function (Request $request, CreateProfileAction $create) {

    // dump(AnonymousUser::getCurrentUser());
    $name = $request->get('name');

    // Récupération des boutons existants dans la session
    $buttons = session()->get('buttons', []);

    // Si on vient de la page d'accueil (pas de boutons dans la session), on réinitialise
    if (!$request->has('name') && empty($buttons)) {
        session()->forget('buttons');
    }

    // Ajouter un nouveau bouton si un nom est envoyé et éviter les doublons
    if (!empty($name) && !in_array($name, $buttons)) {
        $buttons[] = $name;
        session()->put('buttons', $buttons);
    }

    //$create->execute(...$args)
    //CreateProfileAction::make()->execute();

    // getTabs

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
    $cantons = Canton::orderBy('name')->get();
    $insurers = Insurer::orderBy('name')->get();
    $current_accident = filled($request->get('accident')); //pour avoir un bool
    $current_tariftype = $request->get('tarif_type');
    $tariftypes = Tariftype::orderBy('label')->get();
    $primes = Prime::query()
        ->with(['insurer', 'franchise', 'canton'])
        ->when(filled($current_franchise), fn($query) => $query->where('franchise_id', $current_franchise))
        ->when(filled($current_age), fn($query) => $query->where('age_range_id', $current_age))
        ->when(filled($current_canton), fn($query) => $query->where('canton_id', $current_canton))
        // ->when(filled($current_accident), fn($query) => $query->where('accident', $current_accident))
        ->where('accident', $current_accident)
        ->when(filled($current_tariftype), fn($query) => $query->where('tariftype_id', $current_tariftype))
        ->orderBy('cost')->paginate(10)->withQueryString();

    return view('base', [
        'cantons' => $cantons,
        'ages' => $ages,
        'franchises' => $franchises,
        'primes' => $primes,
        'insurers' => $insurers,
        'tariftypes' => $tariftypes,
        'name' => $name,
        'canton' => $current_canton,
        'buttons' => $buttons
    ]);
})->name('search');

Route::get('/user', function () {

    return view('user');
})->name('user');

Route::get('/result', function (Request $request) {
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
        'tariftypes' => $tariftypes
    ]);
})->name('result');

Route::get('/remove_button', function (Request $request) {
    $name = $request->get('name');
    $buttons = session()->get('buttons', []);

    if (($key = array_search($name, $buttons)) !== false) {
        unset($buttons[$key]);
        session()->put('buttons', $buttons);
    }

    return response()->json(['status' => 'success']);
})->name('remove_button');
