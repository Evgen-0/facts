<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->sentence(3),
            'aliases' => json_encode([['name' => 'test']]),
            'photo' => fake()->imageUrl(),
            'slug' => fake()->unique()->slug(2),
            'title' => fake()->sentence(2),
            'description' => fake()->paragraph(1),
            'parent_id' => null,
        ];
    }
}
