<?php

namespace Database\Factories;

use App\Models\Collection;
use App\Models\CollectionStat;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CollectionStat>
 */
class CollectionStatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'collection_id' => Collection::factory()->create()->id,
            'facts' => fake()->numberBetween(0, 1000),
            'likes' => fake()->numberBetween(0, 1000),
            'comments' => fake()->numberBetween(0, 1000),
            'views' => fake()->numberBetween(0, 1000),
            'likes_received' => fake()->numberBetween(0, 1000),
        ];
    }
}
