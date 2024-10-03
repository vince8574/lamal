<?php

use App\Http\Controllers\RateController;
use App\Models\AgeRange;
use Illuminate\Support\Facades\Route;
use App\Models\Canton;
use App\Models\Franchise;
use App\Models\Insurer;
use App\Models\Prime;
use Illuminate\Http\Request;

Route::get('/', function (Request $request) {
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


    $cantons = Canton::orderBy('name')->get();
    $insurers = Insurer::orderBy('name')->get();
    $primes = Prime::query()
        ->with(['insurer'])
        ->when(filled($current_franchise), fn($query) => $query->where('franchise_id', $current_franchise))
        ->when(filled($current_age), fn($query) => $query->where('age_range_id', $current_age))
        ->orderBy('cost')->paginate(10);

    return view('base', [
        'cantons' => $cantons,
        'ages' => $ages,
        'franchises' => $franchises,
        'primes' => $primes,
        'insurers' => $insurers
    ]);
});

Route::prefix('tarif')->name('tarif.')->group(function () {

    Route::get('/', RateController::class . '@index');
});
