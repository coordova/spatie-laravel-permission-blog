<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\User; // Para asignar autor
use App\Models\Post; // Para asignar post
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
        // Obtener un post existente
        $post = Post::inRandomOrder()->first();
        // Asegúrate de que los posts se creen ANTES que los comentarios

        return [
            // Asignar un usuario existente aleatorio como autor
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'post_id' => $post->id ?? Post::factory(), // Si no hay posts, crea uno
            'body' => fake()->paragraph(rand(1, 4)), // Comentario de 1 a 4 frases
            // Fechas de creación realistas (posteriores a la creación del post)
            'created_at' => fake()->dateTimeBetween($post->created_at ?? '-1 month', 'now'), // Comentario posterior al post
            'updated_at' => function (array $attributes) {
                return fake()->dateTimeBetween($attributes['created_at'], 'now');
            },
        ];
    }
}
