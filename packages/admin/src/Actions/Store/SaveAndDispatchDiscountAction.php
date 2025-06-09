<?php

declare(strict_types=1);

namespace Tinoecom\Actions\Store;

use Tinoecom\Core\Models\Discount;
use Tinoecom\Jobs\AttachedDiscountToCustomers;
use Tinoecom\Jobs\AttachedDiscountToProducts;

final readonly class SaveAndDispatchDiscountAction
{
    public function __invoke(
        array $values,
        ?int $discountId = null,
        array $productsIds = [],
        array $customersIds = []
    ): Discount {
        $discount = Discount::query()->updateOrCreate(
            attributes: ['id' => $discountId],
            values: $values,
        );

        AttachedDiscountToProducts::dispatch(
            data_get($values, 'apply_to'),
            $productsIds,
            $discount,
        );

        AttachedDiscountToCustomers::dispatch(
            data_get($values, 'eligibility'),
            $customersIds,
            $discount,
        );

        return $discount;
    }
}
