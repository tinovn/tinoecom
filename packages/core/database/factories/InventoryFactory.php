<?php

declare(strict_types=1);

namespace Tinoecom\Core\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Tinoecom\Core\Models\Country;
use Tinoecom\Core\Models\Inventory;

/**
 * @extends Factory<Inventory>
 */
class InventoryFactory extends Factory
{
    protected $model = Inventory::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'code' => $this->faker->slug(),
            'email' => $this->faker->unique()->safeEmail(),
            'street_address' => $this->faker->streetAddress(),
            'postal_code' => $this->faker->postcode(),
            'city' => $this->faker->city(),
            'phone_number' => $this->faker->phoneNumber(),
            'is_default' => $this->faker->boolean(),
            'country_id' => Country::factory(),
        ];
    }
}
