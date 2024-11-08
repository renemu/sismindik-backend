<?php

// use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware(Authenticate::using('sanctum'));

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', App\Http\Controllers\Api\RegisterController::class)->name('register');
Route::post('/login', App\Http\Controllers\Api\LoginController::class)->name('login');
Route::post('/logout', App\Http\Controllers\Api\LogoutController::class)->name('logout');
Route::post('/code', App\Http\Controllers\Api\code_regisController::class)->name('code');

// Route::apiResource('/code', App\Http\Controllers\Api\code_regisController::class);
Route::apiResource('/posts', App\Http\Controllers\Api\PostController::class);
Route::apiResource('/people', App\Http\Controllers\Api\PeopleController::class);
