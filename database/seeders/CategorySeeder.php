<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $count = 15; // ¿Cuántas categorías quieres crear?
        $this->command->info("Creando {$count} categorías de ejemplo...");

        // Opcional: Crear algunas categorías específicas primero
        // Category::firstOrCreate(['name' => 'Tecnología', 'slug' => 'tecnologia']);
        // Category::firstOrCreate(['name' => 'Tutoriales', 'slug' => 'tutoriales']);
        // Category::firstOrCreate(['name' => 'Noticias', 'slug' => 'noticias']);

        // Crear el resto con la factory
        Category::factory($count)->create();

        $this->command->info("Seeder de Categorías completado.");
    }
}
