<?php

use App\Enums\UserRole;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Member\ContentController;
use App\Http\Controllers\Member\ConversationController;
use App\Http\Controllers\Member\PaymentController;
use App\Http\Controllers\Member\PremiumController;
use App\Http\Controllers\Member\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::get('/blog', [BlogController::class, 'index'])->name('blog');

Route::get('/blog/search', [BlogController::class, 'search'])->name('blog.search');

Route::get('/blog/posts/{slug}', [BlogController::class, 'show'])->name('blog.post');

Route::middleware('guest')->group(function () {
    Route::inertia('/register', 'Register')->name('register');

    Route::post('/register', [AuthController::class, 'register'])->name('register.store');

    Route::inertia('/login', 'Login')->name('login');

    Route::post('/login', [AuthController::class, 'login'])->name('login.store');

    Route::inertia('/forgot-password', 'ForgotPassword')->name('password.request');

    Route::post('/forgot-password', [AuthController::class, 'sendPasswordResetLink'])->name('password.email');

    Route::get('/reset-password/{token}', [AuthController::class, 'showPasswordReset'])->name('password.reset');

    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/email/verify', [AuthController::class, 'sendVerification'])->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verify'])->middleware('signed')->name('verification.verify');

    Route::post('/email/verification-notification', [AuthController::class, 'resendVerification'])->middleware('throttle:6,1')->name('verification.send');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
});

Route::prefix('member')
    ->name('member.')
    ->middleware(['auth', 'verified', 'role:' . UserRole::Member->value])
    ->group(function () {
        Route::get('/contents', [ContentController::class, 'index'])->name('contents.index');

        Route::get('/contents/{fileUrl}', [ContentController::class, 'show'])->name('contents.show');

        Route::get('/conversation', [ConversationController::class, 'index'])->name('conversation.index');

        Route::post('/conversation', [ConversationController::class, 'store'])->name('conversation.store');

        Route::get('/premium', PremiumController::class)->name('premium.index');

        Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');

        Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');

        Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');

        Route::post('/profile/edit', [ProfileController::class, 'update'])->name('profile.update');
    });

Route::prefix('staff')
    ->name('staff.')
    ->middleware(['auth', 'verified', 'role:' . UserRole::Staff->value])
    ->group(function () {
        Route::get('/contents', function () {
            return 'Staff: contents';
        })->name('contents.index');
    });

Route::prefix('finance')
    ->name('finance.')
    ->middleware(['auth', 'verified', 'role:' . UserRole::Finance->value])
    ->group(function () {
        Route::get('/payments', function () {
            return 'Finance: payments';
        })->name('payments.index');
    });

Route::prefix('leader')
    ->name('leader.')
    ->middleware(['auth', 'verified', 'role:' . UserRole::Leader->value])
    ->group(function () {
        Route::get('/statistics', function () {
            return 'Leader: statistics';
        })->name('statistics.index');
    });

Route::prefix('super-admin')
    ->name('super_admin.')
    ->middleware(['auth', 'verified', 'role:' . UserRole::SuperAdmin->value])
    ->group(function () {
        Route::get('/accounts', function () {
            return 'Super Admin: accounts';
        })->name('accounts.index');
    });
