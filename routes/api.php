<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ControllerController;
use App\Http\Controllers\CreativeHubAdminController;
use App\Http\Controllers\CreativeHubTeamController;
use App\Http\Controllers\EmailController;
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

Route::get('/spesialisasi', [PublicController::class, 'getSpesialisasi']);
Route::get('/send-email', [EmailController::class, 'sendEmail']);
Route::get('/send-sms', [\App\Http\Utility\SmsUtility::class, 'sendSms']);


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
    Route::group([
        'prefix' => 'profile'
    ], function ($router) {
        Route::patch('/', [PublicController::class, 'updateProfile']);
        Route::get('/{id}', [PublicController::class, 'getProfile']);
    });

    Route::group([
        'prefix' => 'rekening'
    ], function ($router) {
        Route::get('/', [PublicController::class, 'getRekening']);
        Route::post('/', [PublicController::class, 'createOrUpdateRekening']);
    });

    Route::group([
        'prefix' => 'team'
    ], function ($router) {
        Route::get('/member/{id}', [PublicController::class, 'getMember']);
        Route::get('/{id}', [PublicController::class, 'getTeam']);
    });

    Route::group([
        'prefix' => 'proyek'
    ], function ($router) {
        Route::get('/', [PublicController::class, 'getProyekList']);
        Route::post('/tambah-anggota', [PublicController::class, 'insertAnggotaKeProyek']);
        Route::get('/milestone', [PublicController::class, 'getMilestone']);
        Route::post('/milestone/selesai', [PublicController::class, 'updateSelesaiMilestone']);
        Route::post('/milestone/accept', [PublicController::class, 'updateAcceptMilestone']);
        Route::post('/milestone/bayar', [PublicController::class, 'updateTerbayarMilestone']);
        Route::get('/{id}', [PublicController::class, 'getDetailProyek']);
    });

    Route::group([
        'prefix' => 'design-brief'
    ], function ($router) {
        Route::get('/', [PublicController::class, 'getDesignBrief']);
        Route::post('/', [PublicController::class, 'updateDesignBrief']);
        Route::post('/accept', [PublicController::class, 'updateAcceptDesignBrief']);
    });

    // Client Routes
    Route::group([
        'prefix' => 'client'
    ], function ($router) {
        Route::get('/billing', [ClientController::class, 'getBilling']);
        Route::patch('/billing', [ClientController::class, 'updateBilling']);
        Route::post('/proyek', [ClientController::class, 'insertProyek']);
        Route::get('/controller-list', [ClientController::class, 'getControllerList']);
        Route::get('/payment', [ClientController::class, 'getPaymentProyek']);
        Route::post('/payment', [ClientController::class, 'updatePaymentProyek']);
    });

    Route::group([
        'prefix' => 'controller'
    ], function ($router) {
        Route::get('/tambah-milestone', [ControllerController::class, 'getBuatMilestone']);
        Route::post('/tambah-milestone', [ControllerController::class, 'insertBuatMilestone']);
    });

    Route::group([
        'prefix' => 'creative-hub-team'
    ], function ($router) {
        Route::get('/member', [CreativeHubTeamController::class, 'getMember']);
        Route::post('/member', [CreativeHubTeamController::class, 'insertMember']);
        Route::patch('/member', [CreativeHubTeamController::class, 'updateMember']);
        Route::post('/lamaran-proyek', [CreativeHubTeamController::class, 'insertLamaranProyek']);
    });

    Route::group([
        'prefix' => 'creative-hub-admin'
    ], function ($router) {
        Route::post('/insert-team', [CreativeHubAdminController::class, 'insertTeam']);
    });
});
