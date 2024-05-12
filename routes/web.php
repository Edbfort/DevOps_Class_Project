<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\PostinganController;
use App\Http\Controllers\TeamController;
use App\Http\Requests\SetProfileRequest;
use App\Http\Requests\JoinTeamRequest;
use App\Http\Requests\InsertTeamRequest;
use App\Http\Requests\InsertPostinganRequest;

Route::middleware('jwt.auth')->group(function () {

    //Profile
    Route::get('/get-profile/{id}', function ($id) {
        return app()->make(ProfilController::class)->getDataPribadi($id);
    });
    Route::post('/set-profile/{id}', function (SetProfileRequest $request, $id) {
        return app()->make(ProfilController::class)->setDataPribadi($request, $id);
    });

    //team
    Route::get('/get-team', function (){
        return app()->make(TeamController::class)->getDaftarTeam();
    });
    Route::post('/join-team/{id}', function (JoinTeamRequest $request, $id){
        return app()->make(TeamController::class)->joinTeam($request, $id);
    });
    Route::post('/insert-team', function (InsertTeamRequest $request){
        return app()->make(TeamController::class)->insertTeam($request);
    });
    Route::post('/interact-team/{id}', function ($request, $id){
        return app()->make(TeamController::class)->interactTeam($request, $id);
    });

    //postingan
    Route::get('/get-postingan-project', function () {
        return app()->make(PostinganController::class)->getAllPostinganProject();
    });
    Route::post('/insert-postingan-project', function (InsertPostinganRequest $request) {
        return app()->make(PostinganController::class)->insertPostinganProject($request);
    });

});

