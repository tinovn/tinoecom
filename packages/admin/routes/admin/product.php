<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::as('products.')->group(function (): void {
    Route::get('/', config('tinoecom.components.product.pages.product-index'))->name('index');
    Route::get('/{product}/edit', config('tinoecom.components.product.pages.product-edit'))->name('edit');
    Route::get('/{productId}/variants/{variantId}', config('tinoecom.components.product.pages.variant-edit'))
        ->name('variant');
});

if (\Tinoecom\Feature::enabled('attribute')) {
    Route::get('attributes', config('tinoecom.components.product.pages.attribute-index'))
        ->name('attributes.index');
}
