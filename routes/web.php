<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AccountController;

Route::middleware('jwt.auth')->group(function () {

    // Profile routes
    Route::get('/get-profile-admin/{id}', [ProfileController::class, 'getProfileAdmin']);
    Route::post('/update-profile-admin/{id}', [ProfileController::class, 'updateProfileAdmin']);

    // Account routes
    Route::post('/insert-ch-team/{id}', [AccountController::class, 'insertUserTeam']);
    Route::get('/get-ch-team/{id}', [AccountController::class, 'getUserTeam']);

});


