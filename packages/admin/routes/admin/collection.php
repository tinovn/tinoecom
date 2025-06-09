<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::get('/', config('tinoecom.components.collection.pages.collection-index'))->name('index');
Route::get('/{collection}/edit', config('tinoecom.components.collection.pages.collection-edit'))->name('edit');
