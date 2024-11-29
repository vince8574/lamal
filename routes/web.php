<?php

use App\Actions\CreateProfileAction;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Actions\DeleteCardAction;
use App\Actions\DeleteProfileAction;

use App\Http\Controllers\OuilleController;

Route::middleware('web')->get('/', [OuilleController::class, 'index'])->name('home');

Route::middleware('web')->get('/search', [OuilleController::class, 'search'])->name('search');

Route::middleware('web')->get('/user', function () {

    return view('user');
})->name('user');


Route::middleware('web')->post('/user', [OuilleController::class, 'createUser'])->name('user.create');

Route::middleware('web')->get('/user/delete/{profile_id}', function (int $profile_id) {
    try {

        DeleteProfileAction::make()->execute($profile_id);
    } catch (Exception $e) {
        return redirect(route('search'))->with('error', $e->getMessage());
    }
    return redirect(route('search'));
})->name('user.delete');

Route::middleware('web')->get('/result', [OuilleController::class, 'result'])->name('result');

Route::middleware('web')->get('/user/select', [OuilleController::class, 'cardSelect'])->name('card.select');
