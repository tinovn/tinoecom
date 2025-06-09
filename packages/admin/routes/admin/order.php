<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::get('/', config('tinoecom.components.order.pages.order-index'))->name('index');
Route::get('/{order}/detail', config('tinoecom.components.order.pages.order-detail'))->name('detail');
