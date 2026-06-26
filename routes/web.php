<?php

use App\Enums\UserRole;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Finance\InvoiceController as FinanceInvoiceController;
use App\Http\Controllers\Finance\ProfileController as FinanceProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Leader\ProfileController as LeaderProfileController;
use App\Http\Controllers\Leader\StatisticController;
use App\Http\Controllers\Member\ContentController as MemberContentController;
use App\Http\Controllers\Member\ConversationController as MemberConversationController;
use App\Http\Controllers\Member\InvoiceController as MemberInvoiceController;
use App\Http\Controllers\Member\PremiumController;
use App\Http\Controllers\Member\ProfileController as MemberProfileController;
use App\Http\Controllers\Staff\ContentController as StaffContentController;
use App\Http\Controllers\Staff\ConversationController as StaffConversationController;
use App\Http\Controllers\Staff\BlogController as StaffBlogController;
use App\Http\Controllers\Staff\ProfileController as StaffProfileController;
use App\Http\Controllers\SuperAdmin\AccountController;
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
        Route::get('/contents', [MemberContentController::class, 'index'])->name('contents.index');

        Route::get('/contents/{fileUrl}', [MemberContentController::class, 'show'])->name('contents.show');

        Route::get('/conversation', [MemberConversationController::class, 'index'])->name('conversation.index');

        Route::post('/conversation', [MemberConversationController::class, 'store'])->name('conversation.store');

        Route::get('/premium', PremiumController::class)->name('premium.index');

        Route::get('/invoices', [MemberInvoiceController::class, 'index'])->name('invoices.index');

        Route::get('/invoices/{id}', [MemberInvoiceController::class, 'show'])->name('invoices.show');

        Route::post('/invoices', [MemberInvoiceController::class, 'store'])->name('invoices.store');

        Route::post('/invoices/{id}', [MemberInvoiceController::class, 'update'])->name('invoices.update');

        Route::put('/invoices/{id}/cancel', [MemberInvoiceController::class, 'cancel'])->name('invoices.cancel');

        Route::get('/profile', [MemberProfileController::class, 'index'])->name('profile.index');

        Route::inertia('/profile/edit', 'Member/Profile/Edit')->name('profile.edit');

        Route::put('/profile/edit', [MemberProfileController::class, 'update'])->name('profile.update');
    });

Route::prefix('staff')
    ->name('staff.')
    ->middleware(['auth', 'verified', 'role:' . UserRole::Staff->value])
    ->group(function () {
        Route::get('/contents', [StaffContentController::class, 'index'])->name('contents.index');

        Route::inertia('/contents/create', 'Staff/Content/Create')->name('contents.create');

        Route::post('/contents', [StaffContentController::class, 'store'])->name('contents.store');

        Route::get('/contents/{id}', [StaffContentController::class, 'edit'])->name('contents.edit');

        Route::put('/contents/{id}', [StaffContentController::class, 'update'])->name('contents.update');

        Route::delete('/contents/{id}', [StaffContentController::class, 'destroy'])->name('contents.destroy');

        Route::get('/blog', [StaffBlogController::class, 'index'])->name('posts.index');

        Route::inertia('/blog/create', 'Staff/Blog/Create')->name('posts.create');

        Route::post('/blog', [StaffBlogController::class, 'store'])->name('posts.store');

        Route::get('/blog/{id}', [StaffBlogController::class, 'edit'])->name('posts.edit');

        Route::put('/blog/{id}', [StaffBlogController::class, 'update'])->name('posts.update');

        Route::delete('/blog/{id}', [StaffBlogController::class, 'destroy'])->name('posts.destroy');

        Route::get('/conversations', [StaffConversationController::class, 'index'])->name('conversations.index');

        Route::get('/conversations/{id}', [StaffConversationController::class, 'show'])->name('conversations.show');

        Route::post('/conversations/{conversationId}/message', [StaffConversationController::class, 'storeMessage'])->name('conversations.message.store');

        Route::inertia('/profile', 'Staff/Profile/Index')->name('profile.index');

        Route::inertia('/profile/edit', 'Staff/Profile/Edit')->name('profile.edit');

        Route::put('/profile/edit', [StaffProfileController::class, 'update'])->name('profile.update');
    });

Route::prefix('finance')
    ->name('finance.')
    ->middleware(['auth', 'verified', 'role:' . UserRole::Finance->value])
    ->group(function () {
        Route::get('/invoices', [FinanceInvoiceController::class, 'index'])->name('invoices.index');

        Route::get('/invoices/{id}', [FinanceInvoiceController::class, 'show'])->name('invoices.show');

        Route::put('/invoices/{id}/accept', [FinanceInvoiceController::class, 'accept'])->name('invoices.accept');

        Route::put('/invoices/{id}/reject', [FinanceInvoiceController::class, 'reject'])->name('invoices.reject');

        Route::inertia('/profile', 'Finance/Profile/Index')->name('profile.index');

        Route::inertia('/profile/edit', 'Finance/Profile/Edit')->name('profile.edit');

        Route::put('/profile/edit', [FinanceProfileController::class, 'update'])->name('profile.update');
    });

Route::prefix('leader')
    ->name('leader.')
    ->middleware(['auth', 'verified', 'role:' . UserRole::Leader->value])
    ->group(function () {
        Route::get('/statistics', [StatisticController::class, 'index'])->name('statistics.index');

        Route::get('/statistics/members', [StatisticController::class, 'indexMembers'])->name('statistics.members.index');

        Route::get('/statistics/contents', [StatisticController::class, 'indexContents'])->name('statistics.contents.index');

        Route::get('/statistics/posts', [StatisticController::class, 'indexPosts'])->name('statistics.posts.index');

        Route::get('/statistics/revenues', [StatisticController::class, 'indexRevenues'])->name('statistics.revenues.index');

        Route::inertia('/profile', 'Leader/Profile/Index')->name('profile.index');

        Route::inertia('/profile/edit', 'Leader/Profile/Edit')->name('profile.edit');

        Route::put('/profile/edit', [LeaderProfileController::class, 'update'])->name('profile.update');
    });

Route::prefix('super-admin')
    ->name('super_admin.')
    ->middleware(['auth', 'verified', 'role:' . UserRole::SuperAdmin->value])
    ->group(function () {
        Route::get('/accounts', [AccountController::class, 'index'])->name('accounts.index');

        Route::get('/accounts/{id}', [AccountController::class, 'show'])->name('accounts.show');
    });
