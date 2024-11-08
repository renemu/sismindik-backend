<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return response()->json([
        "version" => "2.0 V",
        "message" => "Welcome to Sismindik Api.",
        "health_check_url" => URL::to('/') . "/up"
    ]);
});

Route::get('/person', [App\Http\Controllers\Api\PersonController::class, 'index'])->name('users');
