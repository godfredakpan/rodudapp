<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\OrdersController;

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

Route::get('/', function () {
    return "Rodud Truck Ordering API";
});


Route::middleware('throttle:60,1')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('/password/reset', [AuthController::class, 'resetPassword']);
    
    // Email Notification Routes
    Route::get('/verify-email/{token}', [AuthController::class, 'verifyEmail'])->name('verification.verify'); // we do  not need this for now
    Route::get('/notification/send-signup-email/{userId}', [EmailController::class, 'sendSignupEmail']);
    // Route::get('/notification/send-signin-email/{userId}', [EmailController::class, 'sendSigninEmail']); // we do  not need this for now
    Route::post('/notification/send-order-email/{userId}', [EmailController::class, 'sendTransactionEmail']);
    Route::get('/notification/send-verification-email/{userId}', [EmailController::class, 'sendVerificationEmail']);
    Route::get('/notification/send-password-reset-email/{email}', [EmailController::class, 'sendPasswordResetEmail']);
});

Route::middleware(['auth:sanctum'])->group(function () {

    // Authenticated User Routes
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('updateUser', [AuthController::class, 'updateUser']);
    Route::get('verify-account/{email}', [AuthController::class, 'verifyAccount']);

   // Order Routes
    Route::get('/orders/user', [OrdersController::class, 'userOrders']); 
    Route::post('/orders/create', [OrdersController::class, 'store']); 
    Route::get('/orders/{id}', [OrdersController::class, 'show']); 

    // Account deletion
    Route::get('/request-deletion-link', [UserController::class, 'requestDeletionLink']);

});

Route::get('/delete-account/{token}', [UserController::class, 'deleteAccount'])->name('deleteAccount');

// Authenticated user info
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


