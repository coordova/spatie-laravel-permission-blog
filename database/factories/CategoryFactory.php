<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
//            'name' => fake()->word(),
//            'slug' => fake()->slug(),
            'name' => ucfirst($name), // Capitalizar primera letra
            'slug' => Str::slug($name), // Generar slug a partir del nombre
        ];
    }
}
