<?php

namespace Database\Factories;

use App\Models\Fact;
use App\Models\FactStat;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FactStat>
 */
class FactStatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'fact_id' => Fact::factory()->create()->id,
            'views' => fake()->numberBetween(0, 1000),
            'likes' => fake()->numberBetween(0, 1000),
            'comments' => fake()->numberBetween(0, 1000),
        ];
    }
}
