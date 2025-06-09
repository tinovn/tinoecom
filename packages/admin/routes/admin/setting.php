<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::get('/', config('tinoecom.components.setting.pages.setting-index'))->name('index');
Route::get('/general', config('tinoecom.components.setting.pages.general'))->name('shop');

Route::prefix('locations')->group(function (): void {
    Route::get('/', config('tinoecom.components.setting.pages.location-index'))->name('locations');
    Route::get('/create', config('tinoecom.components.setting.pages.location-create'))->name('locations.create');
    Route::get('/{inventory}/edit', config('tinoecom.components.setting.pages.location-edit'))->name('locations.edit');
});

Route::get('/legal', config('tinoecom.components.setting.pages.legal'))->name('legal');
Route::get('/analytics', config('tinoecom.components.setting.pages.analytics'))->name('analytics');
Route::get('/payments', config('tinoecom.components.setting.pages.payment'))->name('payments');
Route::get('/zones', config('tinoecom.components.setting.pages.zones'))->name('zones');

Route::prefix('team')->group(function (): void {
    Route::get('/', config('tinoecom.components.setting.pages.team-index'))->name('users');
    Route::get('/roles/{role}', config('tinoecom.components.setting.pages.team-roles'))->name('users.role');
});
