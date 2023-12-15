<?php

namespace Database\Factories;

use App\Models\FormatType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FormatType>
 */
class FormatTypeFactory extends Factory
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
            'name' => fake()->word(),
        ];
    }
}
