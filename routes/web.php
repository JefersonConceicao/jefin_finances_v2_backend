<?php

use Illuminate\Support\Facades\Route;

Route::get('/', action: function () {
    return ['Laravel' => app()->version()];
});

require __DIR__.'/auth.php';
