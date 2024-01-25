<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\UserLink;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<UserLink>
 */
class UserLinkFactory extends Factory
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
            'telegram_id' => null,
            'instagram_id' => null,
            'facebook_id' => null,
            'twitter_id' => null,
            'tiktok_id' => null,
            'github_id' => null,
            'gitlab_id' => null,
            'twitch_id' => null,
            'discord_id' => null,
        ];
    }
}
