<?php

declare(strict_types=1);

use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Tinoecom\Http\Controllers\AssetController;
use Tinoecom\Http\Middleware\Authenticate;
use Tinoecom\Http\Middleware\Dashboard;
use Tinoecom\Http\Middleware\DispatchTinoecom;
use Tinoecom\Http\Middleware\HasConfiguration;
use Tinoecom\Http\Middleware\RedirectIfAuthenticated;
use Tinoecom\Livewire\Pages\Initialization;
use Tinoecom\Sidebar\Middleware\ResolveSidebars;

Route::domain(config('tinoecom.admin.domain'))
    ->middleware([
        EncryptCookies::class,
        AddQueuedCookiesToResponse::class,
        StartSession::class,
        AuthenticateSession::class,
        ShareErrorsFromSession::class,
        VerifyCsrfToken::class,
        SubstituteBindings::class,
        DispatchTinoecom::class,
    ])
    ->group(function (): void {
        Route::prefix(tinoecom()->prefix())->group(function (): void {
            Route::middleware([RedirectIfAuthenticated::class])
                ->as('tinoecom.')->group(function (): void {
                    require __DIR__ . '/auth.php';
                });

            Route::get('/assets/{file}', AssetController::class)
                ->where('file', '.*')
                ->name('tinoecom.asset');

            Route::post('/logout', function (Request $request): RedirectResponse {
                tinoecom()->auth()->logout();

                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('tinoecom.login');
            })->name('tinoecom.logout');

            Route::middleware([
                Authenticate::class,
                HasConfiguration::class,
                ResolveSidebars::class,
            ])->get('/initialize', Initialization::class)->name('tinoecom.initialize');

            Route::middleware(array_merge([
                Authenticate::class,
                Dashboard::class,
                ResolveSidebars::class,
            ], config('tinoecom.routes.middleware', [])))->group(function (): void {
                Route::as('tinoecom.')->group(function (): void {
                    require __DIR__ . '/cpanel.php';
                });

                if (config('tinoecom.routes.custom_file')) {
                    Route::as('tinoecom.')->group(config('tinoecom.routes.custom_file'));
                }
            });
        });
    });
