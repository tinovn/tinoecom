<?php

declare(strict_types=1);

namespace Tinoecom\Core\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Tinoecom\Core\Enum\FieldType;
use Tinoecom\Core\Models\Attribute;

/**
 * @extends Factory<Attribute>
 */
class AttributeFactory extends Factory
{
    protected $model = Attribute::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'slug' => $this->faker->slug(),
            'description' => $this->faker->paragraph(),
            'type' => $this->faker->randomElement(FieldType::values()),
            'icon' => null,
            'is_enabled' => $this->faker->boolean(),
            'is_searchable' => $this->faker->boolean(),
            'is_filterable' => $this->faker->boolean(),
        ];
    }
}
