<?php

declare(strict_types=1);

namespace Tinoecom\Core\Enum;

use Filament\Support\Contracts\HasLabel;
use Tinoecom\Core\Traits\ArrayableEnum;
use Tinoecom\Core\Traits\HasEnumStaticMethods;

/**
 * @method static string ProductTitle()
 * @method static string ProductBrand()
 * @method static string ProductCategory()
 * @method static string ProductPrice()
 * @method static string CompareAtPrice()
 * @method static string InventoryStock()
 */
enum Rule: string implements HasLabel
{
    use ArrayableEnum;
    use HasEnumStaticMethods;

    case ProductTitle = 'product_title';

    case ProductBrand = 'product_brand';

    case ProductCategory = 'product_category';

    case ProductPrice = 'product_price';

    case CompareAtPrice = 'compare_at_price';

    case InventoryStock = 'inventory_stock';

    public function getLabel(): string
    {
        return match ($this) {
            self::ProductTitle => __('tinoecom-core::enum/collection.rules.product_title'),
            self::ProductBrand => __('tinoecom-core::enum/collection.rules.product_brand'),
            self::ProductCategory => __('tinoecom-core::enum/collection.rules.product_category'),
            self::ProductPrice => __('tinoecom-core::enum/collection.rules.product_price'),
            self::CompareAtPrice => __('tinoecom-core::enum/collection.rules.compare_at_price'),
            self::InventoryStock => __('tinoecom-core::enum/collection.rules.inventory_stock'),
        };
    }
}
