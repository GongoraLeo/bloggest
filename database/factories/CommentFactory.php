<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
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
        // Decide aleatoriamente si el comentario es de un invitado o de un usuario registrado
        $isGuest = fake()->boolean(30); // 30% de probabilidad de ser un invitado

        return [
            'post_id' => Post::factory(),
            'user_id' => $isGuest ? null : User::factory(),
            'name' => $isGuest ? fake()->name() : null,
            'email' => $isGuest ? fake()->unique()->safeEmail() : null,
            'content' => fake()->paragraph(),
            'created_at' => fake()->dateTimeBetween('-1 year', 'now'),
            'updated_at' => now(),
        ];
    }
}
