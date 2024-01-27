<?php

namespace Database\Factories;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Tag>
 */
class TagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'image' => fake()->imageUrl(),
            'slug' => fake()->slug(2),
            'title' => fake()->sentence(2),
            'description' => fake()->paragraph(1),
        ];
    }
}
