<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;    // Para asignar autor
use App\Models\Category; // Para vincular categorías
use App\Models\Tag;      // Para vincular tags
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        /*return [
            'title' => fake()->sentence(),
            'content' => fake()->paragraph(),
            'is_published' => fake()->boolean(),
            'user_id' => UserFactory::new(),
//            'category_id' => CategoryFactory::new(),
        ];*/

        return [
            // Asignar un usuario existente aleatorio como autor
            // Asegúrate de que los usuarios se creen ANTES que los posts en los seeders
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(), // Si no hay usuarios, crea uno
            'title' => fake()->sentence(rand(5, 10)), // Título más realista
            'content' => fake()->paragraphs(rand(5, 15), true), // Varios párrafos como texto
            'is_published' => fake()->boolean(85), // 85% de posts publicados
            // Fechas de creación realistas (en el último año)
            'created_at' => fake()->dateTimeBetween('-1 year', 'now'),
            'updated_at' => function (array $attributes) {
                // updated_at es igual o posterior a created_at
                return fake()->dateTimeBetween($attributes['created_at'], 'now');
            },
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (Post $post) {
            // --- Adjuntar Categorías Aleatorias ---
            // Obtener IDs de categorías existentes (asegúrate de crearlas antes)
            $categories = Category::inRandomOrder()
                ->limit(rand(1, 3)) // Adjuntar entre 1 y 3 categorías
                ->pluck('id'); // Obtener solo los IDs
            if ($categories->isNotEmpty()) {
                $post->categories()->attach($categories); // attach() en la relación ManyToMany
            }

            // --- Adjuntar Tags Aleatorios ---
            // Obtener IDs de tags existentes (asegúrate de crearlos antes)
            $tags = Tag::inRandomOrder()
                ->limit(rand(2, 7)) // Adjuntar entre 2 y 7 tags
                ->pluck('id');
            if ($tags->isNotEmpty()) {
                $post->tags()->attach($tags); // attach() en la relación ManyToMany
            }
        });
    }
}
