<?php

namespace Database\Seeders;

use App\Models\Tag;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $count = 30; // ¿Cuántos tags quieres crear?
        $this->command->info("Creando {$count} tags de ejemplo...");

        // Opcional: Crear algunos tags específicos
        //  Tag::firstOrCreate(['name' => 'laravel', 'slug' => 'laravel']);
        //  Tag::firstOrCreate(['name' => 'php', 'slug' => 'php']);
        //  Tag::firstOrCreate(['name' => 'javascript', 'slug' => 'javascript']);
        //  Tag::firstOrCreate(['name' => 'tutorial', 'slug' => 'tutorial']);
        //  Tag::firstOrCreate(['name' => 'tips', 'slug' => 'tips']);

        // Crear el resto con la factory
        Tag::factory($count)->create();

        $this->command->info("Seeder de Tags completado.");
    }
}
