<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrokerController;
use App\Http\Controllers\ClaimController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\TenantController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('password/forgot-password', [ForgotPasswordController::class, 'sendResetLinkResponse'])->name('password.sent');
Route::post('password/reset', [ResetPasswordController::class, 'sendResetResponse'])->name('password.reset');

Route::post('/auth/login', [AuthController::class, 'login'])->name('login');
Route::post('/auth/forgot-password', [AuthController::class, 'sendResetPassword']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/tenant/payments', [TenantController::class, 'getMyPayments'])->name('tenant.payments');
    Route::post('/tenant/payments/create', [TenantController::class, 'createPayment'])->name('tenant.payments.create');
    Route::get('/tenant/claims', [ClaimController::class, 'getMyClaims'])->name('tenant.claims');
    Route::get('/broker/properties', [BrokerController::class, 'getProperties'])->name('broker.properties');
    Route::get('/broker/properties/{id}', [BrokerController::class, 'showProperty'])->name('broker.show-property');
    Route::get('/broker/claims', [ClaimController::class, 'brokerGetClaims'])->name('broker.get-claims');
    Route::post('/claims', [ClaimController::class, 'store'])->name('claims.store');
    Route::get('/claims/{claim}', [ClaimController::class, 'show'])->name('claims.show');
    Route::get('/properties/{property}', [PropertyController::class, 'show'])->name('property.show');
});
