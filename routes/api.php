<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/tokens/create', function (Request $request) {
    $token = $request->user()->createToken($request->token_name);

    return ['token' => $token->plainTextToken];
});

Route::apiResource('posts', PostController::class);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/age', [ApiController::class, 'index']);
    Route::get('/tarif_type', [ApiController::class, 'tarifType']);
    Route::get('/franchises', [ApiController::class, 'franchises']);
    Route::get('/franchises/{age_id}', [ApiController::class, 'franchise']);
    Route::get('/primes/{profile_id}', [ApiController::class, 'primes']);
    Route::post('primes', [ApiController::class, 'primes']);
    Route::get('/selection', [ApiController::class, 'selection']);
    Route::post('/selection/{profile_id}/{prime_card_id}', [ApiController::class, 'selection']);
    Route::delete('/selection/{profile_id}/{prime_card_id}', [ApiController::class, 'selection']);
    Route::post('/regions', [ApiController::class, 'regions']);

    // profiles 
    Route::post('/profile', [ApiController::class, 'createProfile']);
    Route::get('/profile', [ApiController::class, 'getProfiles']);
    Route::get('/profile/{profile_id}', [ApiController::class, 'getProfile']);
    Route::delete('/profile/{profile_id}', [ApiController::class, 'deleteProfile']);
    Route::put('/profile/{profile_id}', [ApiController::class, 'updateProfile']);
});
