<?php

use App\Domains\Auth\Controllers\PasswordResetController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/reset-password', [PasswordResetController::class, 'create'])
    ->name('password.reset');
