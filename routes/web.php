<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Requests\SetProfileAdminRequest;
use App\Http\Requests\GetProfileAdminRequest;

Route::middleware('jwt.auth')->group(function () {

    // Profile routes
    Route::get('/get-profile-admin/{id}', [ProfileController::class, 'getProfileAdmin']);
    Route::post('/update-profile-admin/{id}', [ProfileController::class, 'updateProfileAdmin']);

});


