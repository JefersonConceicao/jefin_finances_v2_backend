<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/confirmUser/{token}',[RegisteredUserController::class, 'confirmUser'])->name('auth.registerConfirmation');
Route::get('/', action: function () {
    return ['Laravel' => app()->version()];
});

Route::get('/setNewPassword', function(Request $request){
    return dd($request->all());
});

require __DIR__.'/auth.php';
