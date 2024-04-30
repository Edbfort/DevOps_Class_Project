<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfilController;
use App\Http\Requests\SetProfileRequest;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware('jwt.auth')->group(function () {
    Route::get('/get-profile/{id}', function ($id) {
        return app()->make(ProfilController::class)->getDataPribadi($id);
    });
    Route::post('/set-profile/{id}', function (SetProfileRequest $request, $id) {
        return app()->make(ProfilController::class)->setDataPribadi($request, $id);
    });
});

