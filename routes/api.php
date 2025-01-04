<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\APIAuthController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UsersController;

Route::ANY('/login', [APIAuthController::class, 'authenticate'])->name('auth.authenticate');
Route::POST('/recoveryPassword', [PasswordResetLinkController::class, 'store'])->name('auth.passwordResetLink');
Route::POST('/setNewPassword', [PasswordResetLinkController::class, 'setNewPassword'])->name('auth.setNewPassword');

Route::POST('/register',[RegisteredUserController::class, 'store'])->name('auth.register');

Route::middleware(['auth:sanctum'])->group(function(){
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::GET('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::POST('/logout', [APIAuthController::class, 'logout'])->name('auth.logout');

    Route::group(['prefix' => 'user'], function(){
        Route::GET('/profile',[UsersController::class, 'profile'])->name('user.profile');
        Route::POST('/updateProfile',[UsersController::class, 'updateProfile'])->name('user.updateProfile');
    });
});
