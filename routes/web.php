<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Finance\PaymentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Leader\StatisticController;
use App\Http\Controllers\Member\ContentController as MemberContentController;
use App\Http\Controllers\Staff\ContentController as StaffContentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SuperAdmin\AccountController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::get('/blog', [PostController::class, 'index'])->name('blog');

Route::get('/blog/search', [PostController::class, 'search'])->name('blog.search');

Route::get('/blog/posts/{slug}', [PostController::class, 'show'])->name('blog.post');

Route::middleware('guest')->group(function () {
    Route::inertia('/register', 'Register')->name('register');

    Route::post('/register', [AuthController::class, 'register'])->name('register.store');

    Route::inertia('/login', 'Login')->name('login');

    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');

    Route::inertia('/forgot-password', 'ForgotPassword')->name('password.request');

    Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');

    Route::get('/reset-password/{token}', [AuthController::class, 'resetPassword'])->name('password.reset');

    Route::post('/reset-password', [AuthController::class, 'updatePassword'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/email/verify', [AuthController::class, 'noticeVerification'])->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verify'])->middleware('signed')->name('verification.verify');

    Route::post('/email/verification-notification', [AuthController::class, 'sendVerification'])->middleware(['throttle:6,1'])->name('verification.send');
});

Route::get('/dashboard', DashboardController::class)->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified', 'role:member'])
    ->prefix('member')
    ->name('member.')
    ->group(function () {
        Route::get('/contents', [MemberContentController::class, 'index'])->name('contents');
    });

Route::middleware(['auth', 'verified', 'role:staff'])
    ->prefix('staff')
    ->name('staff.')
    ->group(function () {
        Route::get('/contents', [StaffContentController::class, 'index'])->name('contents');
    });

Route::middleware(['auth', 'verified', 'role:finance'])
    ->prefix('finance')
    ->name('finance.')
    ->group(function () {
        Route::get('/payments', [PaymentController::class, 'index'])->name('payments');
    });

Route::middleware(['auth', 'verified', 'role:leader'])
    ->prefix('leader')
    ->name('leader.')
    ->group(function () {
        Route::get('/statistics', [StatisticController::class, 'index'])->name('statistics');
    });

Route::middleware(['auth', 'verified', 'role:super_admin'])
    ->prefix('super-admin')
    ->name('super_admin.')
    ->group(function () {
        Route::get('/accounts', [AccountController::class, 'index'])->name('accounts');
    });
