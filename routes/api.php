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
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth:sanctum');

Route::get('/age', [ApiController::class, 'ages'])->middleware('auth:sanctum');
Route::get('/tarif_type', [ApiController::class, 'tarifType'])
    ->middleware('auth:sanctum');
Route::get('/franchises', [ApiController::class, 'franchises'])
    ->middleware('auth:sanctum');
Route::get('/franchises/{age_id}', [ApiController::class, 'franchises'])
    ->middleware('auth:sanctum');
Route::get('/primes/{profile_id}', [ApiController::class, 'primes'])
    ->middleware('auth:sanctum');
Route::post('primes', [ApiController::class, 'primes'])
    ->middleware('auth:sanctum');
Route::get('/selection', [ApiController::class, 'selection'])
    ->middleware('auth:sanctum');
Route::post('/selection/{profile_id}/{prime_card_id}', [ApiController::class, 'selection'])
    ->middleware('auth:sanctum');
Route::delete('/selection/{profile_id}/{prime_card_id}', [ApiController::class, 'selection'])->middleware('auth:sanctum');
Route::post('/regions', [ApiController::class, 'regions'])
    ->middleware('auth:sanctum');
Route::post('/profile/{uid}', [ApiController::class, 'profile'])
    ->middleware('auth:sanctum');
Route::get('/profile/{profile_id}', [ApiController::class, 'profile'])
    ->middleware('auth:sanctum');
Route::delete('/profile/{profile_id}', [ApiController::class, 'profile'])
    ->middleware('auth:sanctum');
Route::put('/profile/{profile_id}', [ApiController::class, 'profile'])
    ->middleware('auth:sanctum');
