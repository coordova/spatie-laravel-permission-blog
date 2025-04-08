<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Comment;
use App\Models\User; // Para verificar
use App\Models\Post; // Para verificar

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Verificar si existen prerequisitos (usuarios, posts)
        if (User::count() == 0 || Post::count() == 0) {
            $this->command->error('¡Error! Necesitas ejecutar UserSeeder y PostSeeder antes de CommentSeeder.');
            return;
        }

        $count = 200; // ¿Cuántos comentarios quieres crear? (Más que posts)
        $this->command->info("Creando {$count} comentarios de ejemplo...");

        Comment::factory($count)->create();

        $this->command->info("Seeder de Comentarios completado.");
    }
}
