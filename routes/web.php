<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Requests\SetProfileAdminRequest;

use Illuminate\Http\Request;

Route::middleware('jwt.auth')->group(function () {

    //Profile
    Route::post('/get-profile-admin/{id}', function (SetProfileAdminRequest $request, $id) {
        return app()->make(ProfileController::class)->updateProfileAdmin($request, $id);
    });

});

