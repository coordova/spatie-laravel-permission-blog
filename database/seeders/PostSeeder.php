<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\User;    // Para verificar si existen usuarios
use App\Models\Category;// Para verificar si existen categorías
use App\Models\Tag;     // Para verificar si existen tags

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Verificar si existen prerequisitos (usuarios, categorías, tags)
        if (User::count() == 0 || Category::count() == 0 || Tag::count() == 0) {
            $this->command->error('¡Error! Necesitas ejecutar UserSeeder, CategorySeeder y TagSeeder antes de PostSeeder.');
            return; // Detener si faltan datos base
        }

        $count = 50; // ¿Cuántos posts quieres crear?
        $this->command->info("Creando {$count} posts de ejemplo (y adjuntando categorías/tags)...");

        Post::factory($count)->create(); // La factory se encarga del resto

        $this->command->info("Seeder de Posts completado.");
    }
}
