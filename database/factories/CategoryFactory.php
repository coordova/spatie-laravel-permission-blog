<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;
use Illuminate\Support\Str; // Necesario para Str::slug

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Generar un nombre único primero
        $name = fake()->unique()->words(rand(1, 3), true); // 1 a 3 palabras

        return [
            'name' => ucfirst($name), // Capitalizar primera letra
            'slug' => Str::slug($name), // Generar slug a partir del nombre
        ];
    }
}
