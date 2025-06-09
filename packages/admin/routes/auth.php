<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Tinoecom\Http\Controllers\Auth\TwoFactorAuthenticatedController;
use Tinoecom\Livewire\Pages\Auth\ForgotPassword;
use Tinoecom\Livewire\Pages\Auth\Login;
use Tinoecom\Livewire\Pages\Auth\ResetPassword;

Route::redirect('/', tinoecom()->prefix() . '/login', 301);

// Authentication...
Route::get('/login', Login::class)->name('login');
Route::get('/password/reset', ForgotPassword::class)->name('password.request');
Route::get('/password/reset/{token}', ResetPassword::class)->name('password.reset');

// Two-Factor Authentication...
if (config('tinoecom.auth.2fa_enabled')) {
    Route::get('/two-factor-login', [TwoFactorAuthenticatedController::class, 'create'])
        ->name('two-factor.login');

    Route::post('/two-factor-login', [TwoFactorAuthenticatedController::class, 'store'])
        ->name('two-factor.post-login');
}
