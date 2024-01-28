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
            'facts' => 0,
            'likes' => 0,
            'comments' => 0,
            'collections' => 0,
            'likes_received' => 0,
        ];
    }
}
