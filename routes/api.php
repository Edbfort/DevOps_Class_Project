<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CreativeHubTeamController;
use App\Http\Controllers\CreativeHubAdminController;
use App\Http\Controllers\KotaController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::get('/kota', [KotaController::class, 'getKota'])->name('kota');

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/refresh', [AuthController::class, 'refresh'])->name('refresh');
    Route::post('/me', [AuthController::class, 'me'])->name('me');
});

Route::middleware('jwt.auth')->group(function () {

    // Profile routes
//    Route::get('/get-profile-admin/{id}', [ProfileController::class, 'getProfileAdmin']);
//    Route::get('/get-profile-team/{id}', [ProfileController::class, 'getProfileTeam']);
//    Route::get('/get-data-product-owner', [ProfileController::class, 'getDataProductOwner']);
//    Route::get('/get-all-data-product-owner', [ProfileController::class, 'getAllDataProductOwner']);
//    Route::post('/update-profile-admin/{id}', [ProfileController::class, 'updateProfileAdmin']);
//    Route::post('/update-profile-team/{id}', [ProfileController::class, 'updateProfileTeam']);
//
//    // Account routes
//    Route::post('/insert-ch-team/{id}', [AccountController::class, 'insertUserTeam']);
//    Route::post('/activate-team/{id}', [AccountController::class, 'activationUserTeam']);
//    Route::get('/get-ch-team/{id}', [AccountController::class, 'getUserTeam']);

    Route::get('/profile/{id}', [PublicController::class, 'getProfile']);
    Route::patch('/profile', [PublicController::class, 'updateProfile']);

    // Client Routes
    Route::group([
        'prefix' => 'client'
    ], function ($router) {
        Route::get('/billing',[ClientController::class, 'getBilling']);
        Route::patch('/billing',[ClientController::class, 'updateBilling']);
    });

    Route::group([
        'prefix' => 'creative-hub-team'
    ], function ($router) {
    });

    Route::group([
        'prefix' => 'creative-hub-admin'
    ], function ($router) {
        Route::post('/insert-new-team',[CreativeHubAdminController::class, 'insertNewTeam']);
        Route::get('/team/{id}',[CreativeHubAdminController::class, 'getTeam']);
    });
});
