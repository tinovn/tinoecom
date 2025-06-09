<?php

declare(strict_types=1);

namespace Tinoecom\Actions\Store\Product;

use Filament\Forms\Form;
use Illuminate\Support\Arr;
use Tinoecom\Actions\Store\InitialQuantityInventory;
use Tinoecom\Core\Events\Products\Created;
use Tinoecom\Core\Models\Product;
use Tinoecom\Core\Repositories\ProductRepository;
use Tinoecom\Feature;

final class CreateProductAction
{
    public function __invoke(Form $form): Product
    {
        $state = $form->getState();

        /** @var Product $product */
        $product = (new ProductRepository)->create(
            Arr::except($state, ['quantity', 'categories'])
        );

        $form->model($product)->saveRelationships();

        if (Feature::enabled('category')) {
            $categoriesIds = (array) data_get($state, 'categories');

            if (count($categoriesIds) > 0) {
                $product->categories()->sync($categoriesIds);
            }
        }

        $quantity = data_get($state, 'quantity');

        if ($quantity && (int) $quantity > 0) {
            app()->call(InitialQuantityInventory::class, [
                'quantity' => $quantity,
                'product' => $product,
            ]);
        }

        event(new Created($product));

        return $product;
    }
}
