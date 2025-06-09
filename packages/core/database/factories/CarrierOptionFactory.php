<?php

declare(strict_types=1);

namespace Tinoecom\Core\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Tinoecom\Core\Models\CarrierOption;

/**
 * @extends Factory<CarrierOption>
 */
class CarrierOptionFactory extends Factory
{
    protected $model = CarrierOption::class;

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
