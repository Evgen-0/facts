<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Fact;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Fact>
 */
class FactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'heading' => fake()->sentence(2),
            'body' => fake()->imageUrl(),
            'user_id' => User::factory()->create()->id,
            'category_id' => Category::factory()->create()->id,
            'slug' => fake()->slug(2),
            'title' => fake()->sentence(2),
            'description' => fake()->paragraph(1),
        ];
    }
}
