<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AccountController;

Route::middleware('jwt.auth')->group(function () {

    // Profile routes
    Route::get('/get-profile-admin/{id}', [ProfileController::class, 'getProfileAdmin']);
    Route::get('/get-profile-team/{id}', [ProfileController::class, 'getProfileTeam']);
    Route::post('/update-profile-admin/{id}', [ProfileController::class, 'updateProfileAdmin']);
    Route::post('/update-profile-team/{id}', [ProfileController::class, 'updateProfileTeam']);

    // Account routes
    Route::post('/insert-ch-team/{id}', [AccountController::class, 'insertUserTeam']);
    Route::post('/activate-team/{id}', [AccountController::class, 'activationUserTeam']);
    Route::get('/get-ch-team/{id}', [AccountController::class, 'getUserTeam']);
});


