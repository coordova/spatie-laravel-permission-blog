<?php

namespace Database\Factories;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tag>
 */
class TagFactory extends Factory
{
    protected $model = Tag::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        /*return [
            'name' => fake()->word(),
            'slug' => fake()->slug(),
        ];*/

        // Generar un nombre único primero
        $name = fake()->unique()->word(); // Una sola palabra para tags suele ser común

        return [
            'name' => strtolower($name), // Tags suelen ir en minúscula
            'slug' => Str::slug($name),
        ];
    }
}
