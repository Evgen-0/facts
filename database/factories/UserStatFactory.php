<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\UserStat;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<UserStat>
 */
class UserStatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->create()->id,
            'facts' => fake()->numberBetween(0, 1000),
            'likes' => fake()->numberBetween(0, 1000),
            'comments' => fake()->numberBetween(0, 1000),
            'collections' => fake()->numberBetween(0, 1000),
            'likes_received' => fake()->numberBetween(0, 1000),
        ];
    }
}
