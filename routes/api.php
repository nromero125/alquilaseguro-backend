<?php

use App\Enums\UserTypes;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrokerController;
use App\Http\Controllers\ClaimController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\UserController;
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
    if (auth()->user('api')->user_type == UserTypes::TENANT) {
        return $request->user()->load('tenant.property');
    }

    return $request->user();
});

Route::post('password/forgot-password', [ForgotPasswordController::class, 'sendResetLinkResponse'])->name('password.sent');
Route::post('password/reset', [ResetPasswordController::class, 'sendResetResponse'])->name('password.reset');

Route::post('/auth/login', [AuthController::class, 'login'])->name('api.login');
Route::post('/auth/logout', [AuthController::class, 'logout'])->name('api.logout');
Route::post('/auth/forgot-password', [AuthController::class, 'sendResetPassword']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/tenant/payments', [TenantController::class, 'getMyPayments'])->name('tenant.payments');
    Route::get('/insurance/payments', [PaymentController::class, 'getInsurancePayments'])->name('insurance.payments');
    Route::get('/broker/payments', [BrokerController::class, 'getMyPayments'])->name('broker.payments');
    Route::get('/owner/payments', [OwnerController::class, 'getMyPayments'])->name('owner.payments');
    Route::post('/tenant/payments/create', [TenantController::class, 'createPayment'])->name('tenant.payments.create');
    Route::get('/tenant/claims', [ClaimController::class, 'getMyClaims'])->name('tenant.claims');
    Route::get('/owner/claims', [ClaimController::class, 'getMyClaims'])->name('owner.claims');
    Route::get('/broker/properties', [BrokerController::class, 'getProperties'])->name('broker.properties');
    Route::get('/broker/properties/{id}', [BrokerController::class, 'showProperty'])->name('broker.show-property');
    Route::get('/owner/properties', [OwnerController::class, 'getProperties'])->name('owner.properties');
    Route::get('/owner/properties/all', [OwnerController::class, 'getPropertiesWithoutPag'])->name('owner.getPropertiesWithoutPag');
    Route::get('/owner/properties/{id}', [OwnerController::class, 'showProperty'])->name('owner.show-property');
    Route::get('/broker/claims', [ClaimController::class, 'brokerGetClaims'])->name('broker.get-claims');
    Route::post('/claims', [ClaimController::class, 'store'])->name('claims.store');
    Route::get('/claims', [ClaimController::class, 'index'])->name('claims.index');
    Route::put('/claims/{claim}', [ClaimController::class, 'updateClaim'])->name('claims.update');
    Route::get('/claims/{claim}', [ClaimController::class, 'show'])->name('claims.show');
    Route::get('/properties/{property}', [PropertyController::class, 'show'])->name('property.show');
    Route::post('/users/broker', [UserController::class, 'createBroker'])->name('users.broker');
    Route::post('/users/insurer', [UserController::class, 'createInsurer'])->name('users.insurer');
    Route::put('/users/broker/{broker}', [UserController::class, 'updateBrokerUser'])->name('users.broker.update');
    Route::put('/users/insurer/{insurer}', [UserController::class, 'updateInsurerUser'])->name('users.insurer.update');
    Route::get('/users', [UserController::class, 'getUsers'])->name('users.get');
    Route::post('/auth/update-password', [AuthController::class, 'updatePassword'])->name('profile.update-password');
    Route::get('/home', [HomeController::class, 'home'])->name('api.home');
});
