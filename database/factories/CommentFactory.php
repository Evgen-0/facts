<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Fact;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Comment>
 */
class CommentFactory extends Factory
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
            'body' => fake()->paragraph(2),
            'parent_id' => null,
            'commentable_type' => $fact::class,
            'commentable_id' => $fact->id,
        ];
    }
}
