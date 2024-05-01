<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\KomunitasController;
use App\Http\Requests\SetProfileRequest;
use App\Http\Requests\JoinComunityRequest;
use App\Http\Requests\InsertComunityRequest;

Route::middleware('jwt.auth')->group(function () {

    //Profile
    Route::get('/get-profile/{id}', function ($id) {
        return app()->make(ProfilController::class)->getDataPribadi($id);
    });
    Route::post('/set-profile/{id}', function (SetProfileRequest $request, $id) {
        return app()->make(ProfilController::class)->setDataPribadi($request, $id);
    });

    //Comunity
    Route::get('/get-comunity', function (){
        return app()->make(KomunitasController::class)->getDaftarComunity();
    });
    Route::post('/join-comunity/{id}', function (JoinComunityRequest $request, $id){
        return app()->make(KomunitasController::class)->joinComunity($request, $id);
    });
    Route::post('/insert-comunity', function (InsertComunityRequest $request){
        return app()->make(KomunitasController::class)->insertComunity($request);
    });

    //Team

});

