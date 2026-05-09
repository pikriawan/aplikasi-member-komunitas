<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Home')->name('home');

Route::middleware('guest')->group(function () {
    Route::inertia('/auth/register', 'auth/Register')->name('register');

    Route::post('/auth/register', RegisterController::class)->name('register.store');

    Route::inertia('/auth/login', 'auth/Login')->name('login');

    Route::post('/auth/login', LoginController::class)->name('login.attempt');
});

Route::middleware('auth')->group(function () {
    Route::inertia('/dashboard', 'Dashboard')->name('dashboard');

    Route::post('/auth/logout', LogoutController::class)->name('logout');
});
