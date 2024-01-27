<?php

namespace Database\Factories;

use App\Models\Fact;
use App\Models\MediaFile;
use App\Type\MediaType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MediaFile>
 */
class MediaFileFactory extends Factory
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
            'type' => fake()->randomElement(MediaType::getAllCaseValues()),
            'file' => fake()->imageUrl()
        ];
    }
}
