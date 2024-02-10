<?php

namespace Database\Factories;

use App\Models\Fact;
use App\Models\User;
use App\Models\UserFavorite;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<UserFavorite>
 */
class UserFavoriteFactory extends Factory
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
            'favoriteable_type' => $fact::class,
            'favoriteable_id' => $fact->id,
        ];
    }
}
