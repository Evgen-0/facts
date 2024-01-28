<?php

namespace Database\Factories;

use App\Models\Fact;
use App\Models\Like;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Like>
 */
class LikeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $fact = Fact::factory()->create();

        return [
            'user_id' => User::factory()->create()->id,
            'is_like' => fake()->boolean,
            'likeable_type' => $fact::class,
            'likeable_id' => $fact->id,
        ];
    }
}
