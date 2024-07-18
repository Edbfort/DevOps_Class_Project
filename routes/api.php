<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ControllerController;
use App\Http\Controllers\CreativeHubTeamController;
use App\Http\Controllers\CreativeHubAdminController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\KotaController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\SmsController;
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
Route::get('/send-email', [EmailController::class, 'sendEmail']);
Route::get('/send-sms', [SmsController::class, 'sendSms']);


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
    Route::get('/rekening', [PublicController::class, 'getRekening']);
    Route::post('/rekening', [PublicController::class, 'createOrUpdateRekening']);
    Route::get('/team/member/{id}', [PublicController::class, 'getMember']);
    Route::get('/team/{id}',[PublicController::class, 'getTeam']);
    Route::get('/proyek',[PublicController::class, 'getProyekList']);
    Route::get('/proyek/{id}', [PublicController::class, 'getDetailProyek']);
    Route::get('/design-brief', [PublicController::class, 'getDesignBrief']);

    // Client Routes
    Route::group([
        'prefix' => 'client'
    ], function ($router) {
        Route::get('/billing',[ClientController::class, 'getBilling']);
        Route::patch('/billing',[ClientController::class, 'updateBilling']);
        Route::post('/proyek',[ClientController::class, 'insertProyek']);
        Route::get('/controller-list',[ClientController::class, 'getControllerList']);
        Route::get('/payment',[ClientController::class, 'getPaymentProyek']);
        Route::post('/payment',[ClientController::class, 'updatePaymentProyek']);
    });

    Route::group([
        'prefix' => 'controller'
    ], function ($router) {
        Route::post('/design-brief',[ControllerController::class, 'updateDesignBrief']);
    });

    Route::group([
        'prefix' => 'creative-hub-team'
    ], function ($router) {
        Route::get('/member', [CreativeHubTeamController::class, 'getMember']);

    });

    Route::group([
        'prefix' => 'creative-hub-admin'
    ], function ($router) {
        Route::post('/insert-team',[CreativeHubAdminController::class, 'insertTeam']);
    });
});
