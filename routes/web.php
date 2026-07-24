<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FolderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');
    Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->name('verification.send');
    Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)
        ->name('verification.verify');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/archives/{archive}/download', [ArchiveController::class, 'download'])->name('archives.download');
    Route::get('/archives/{archive}/preview', [ArchiveController::class, 'preview'])->name('archives.preview');
    Route::resource('archives', ArchiveController::class);

    Route::middleware(['role:Admin|Super Admin'])->group(function () {
        Route::resource('folders', FolderController::class)->except(['edit', 'update', 'destroy']);
        Route::post('/folders/{folder}/archives', [FolderController::class, 'assignArchives'])->name('folders.assign-archives');
    });

    Route::middleware('role:Super Admin')->group(function () {
        Route::resource('users', UserController::class);
        Route::post('/users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');
        Route::resource('roles', RoleController::class);
        Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
