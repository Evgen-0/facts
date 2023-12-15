<?php

namespace Database\Factories;

use App\Models\Fact;
use App\Models\FormatType;
use App\Type\MediaType;
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
            'id' => fake()->uuid(),
            'format_types_id' => FormatType::factory()->create()->id,
            'media_type' => fake()->randomElement(MediaType::getAllCaseValues()),
            'media' => fake()->imageUrl(),
            'body' => fake()->paragraph(4),
            'slug' => fake()->slug(2),
            'title' => fake()->sentence(2),
            'description' => fake()->paragraph(1),
        ];
    }
}
