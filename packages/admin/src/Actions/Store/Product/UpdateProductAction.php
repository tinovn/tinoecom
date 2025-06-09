<?php

declare(strict_types=1);

namespace Tinoecom\Actions\Store\Product;

use Filament\Forms\Form;
use Illuminate\Support\Arr;
use Tinoecom\Core\Events\Products\Updated;
use Tinoecom\Core\Models\Product;
use Tinoecom\Feature;

final class UpdateProductAction
{
    public function __invoke(Form $form, Product $product): Product
    {
        $state = $form->getState();

        $product->update(Arr::except($state, ['categories']));

        if (Feature::enabled('category')) {
            $categoriesIds = (array) data_get($state, 'categories');

            if (count($categoriesIds) > 0) {
                $product->categories()->sync($categoriesIds);
            }
        }

        $product->refresh();

        event(new Updated($product));

        return $product;
    }
}
