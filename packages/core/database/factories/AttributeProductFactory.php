<?php

declare(strict_types=1);

namespace Tinoecom\Core\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Tinoecom\Core\Models\AttributeProduct;

/**
 * @extends Factory<AttributeProduct>
 */
class AttributeProductFactory extends Factory
{
    protected $model = AttributeProduct::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [];
    }
}
