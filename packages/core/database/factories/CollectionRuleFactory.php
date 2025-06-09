<?php

declare(strict_types=1);

namespace Tinoecom\Core\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Tinoecom\Core\Models\CollectionRule;

/**
 * @extends Factory<CollectionRule>
 */
class CollectionRuleFactory extends Factory
{
    protected $model = CollectionRule::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'rule' => $this->faker->word(),
            'operator' => $this->faker->word(),
            'value' => $this->faker->word(),
        ];
    }
}
