<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\AccountSecurityController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// emil.confirm
Route::get('/email/confirm', [App\Http\Controllers\AuthController::class, 'confirmEmail'])->name('email.confirm');
// Account security settings
Route::get('/account/security', [AccountSecurityController::class, 'showSecuritySettings'])->name('account.security');

// Update password
Route::post('/account/update-password', [AccountSecurityController::class, 'updatePassword'])->name('account.update.password');

Auth::routes();

// register admin
Route::post('/register/admin', [App\Http\Controllers\Auth\RegisterController::class, 'register'])->name('register.admin');

Route::group(['prefix' => ''], function () {

    Route::get('', [App\Http\Controllers\FrontendController::class, 'index'])->name('index');

    Route::get('privacy', [App\Http\Controllers\FrontendController::class, 'privacy'])->name('privacy');

    Route::get('terms', [App\Http\Controllers\FrontendController::class, 'terms'])->name('terms');

    Route::get('/delete-account', [App\Http\Controllers\FrontendController::class, 'showDeletionForm'])->name('delete.account');

    Route::post('/submit-deletion', [App\Http\Controllers\FrontendController::class, 'requestAccountDeletion'])->name('submit.deletion');

});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::group(['prefix' => 'dashboard', 'middleware' => 'auth'], function () {

    Route::get('/', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    Route::post('/send-email', [App\Http\Controllers\EmailController::class, 'sendCustomEmail'])->name('send.email');

    Route::group(['prefix' => 'users', 'middleware' => 'auth'], function () {

        Route::get('all', [App\Http\Controllers\UserController::class, 'index'])->middleware('admin')->name('all.users');

        Route::get('create', [App\Http\Controllers\UserController::class, 'create'])->middleware('admin')->name('create.user');

        Route::post('save', [App\Http\Controllers\UserController::class, 'save'])->middleware('admin')->name('save.user');

        Route::get('view/{id}', [App\Http\Controllers\UserController::class, 'view'])->middleware('admin')->name('view.user');

        Route::get('profile', [App\Http\Controllers\UserController::class, 'profile'])->name('profile.user');

        Route::post('confirmPassword', [App\Http\Controllers\UserController::class, 'confirmPassword'])->name('confirmPassword');

        Route::post('update', [App\Http\Controllers\UserController::class, 'update'])->name('update.user');

        Route::get('delete/{id}', [App\Http\Controllers\UserController::class, 'delete'])->middleware('admin')->name('delete.user');

        Route::get('approve/{id}', [App\Http\Controllers\UserController::class, 'approve'])->middleware('admin')->name('approve.user');

        Route::get('decline/{id}', [App\Http\Controllers\UserController::class, 'decline'])->middleware('admin')->name('decline.user');
    });

    Route::group(['prefix' => 'orders', 'middleware' => 'auth'], function () {
        Route::get('/', [App\Http\Controllers\OrdersController::class, 'index'])->name('orders.index'); 
        Route::get('/user', [App\Http\Controllers\OrdersController::class, 'userOrders']); 
        Route::post('/create', [App\Http\Controllers\OrdersController::class, 'store']); 
        Route::get('/view/{id}', [App\Http\Controllers\OrdersController::class, 'show'])->name('orders.show'); 
        Route::put('/update/{id}', [App\Http\Controllers\OrdersController::class, 'updateStatus'])->name('orders.update');
        Route::delete('/delete/{id}', [App\Http\Controllers\OrdersController::class, 'destroy'])->name('orders.destroy');
    });

});


Route::get('/password/success', function () {
    return view('auth.passwords.success');
});

Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('view:clear');
    return 'DONE'; //Return anything
});
