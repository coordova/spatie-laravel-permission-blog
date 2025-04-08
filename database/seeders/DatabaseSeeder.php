<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Schema; // Para deshabilitar/habilitar FK constraints

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        /*User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);*/

        // Deshabilitar chequeo de claves foráneas para evitar errores de orden al truncar
        Schema::disableForeignKeyConstraints();

        // TRUNCATE TABLES (Opcional, pero recomendado si usas migrate:fresh --seed a menudo)
        // Esto limpia las tablas antes de sembrar, pero es más rápido que migrate:fresh
        // Ten cuidado si tienes datos importantes que no quieres perder
        // \App\Models\User::truncate();
        // \App\Models\Category::truncate();
        // \App\Models\Tag::truncate();
        // \App\Models\Post::truncate();
        // \App\Models\Comment::truncate();
        // DB::table('roles')->truncate(); // Truncar tablas de Spatie si es necesario
        // DB::table('permissions')->truncate();
        // DB::table('model_has_roles')->truncate();
        // DB::table('model_has_permissions')->truncate();
        // DB::table('role_has_permissions')->truncate();
        // DB::table('category_post')->truncate();
        // DB::table('post_tag')->truncate();
        // $this->command->info('Tablas truncadas (opcional).');


        // Llamar a los Seeders en el orden correcto de dependencias
        $this->call([
            RolePermissionSeeder::class, // 1. Roles y Permisos primero
            UserSeeder::class,           // 2. Usuarios (necesitan roles)
            CategorySeeder::class,       // 3. Categorías (independiente)
            TagSeeder::class,            // 4. Tags (independiente)
            PostSeeder::class,           // 5. Posts (necesitan usuarios, categorías, tags)
            CommentSeeder::class,        // 6. Comentarios (necesitan usuarios, posts)
        ]);

        // Volver a habilitar chequeo de claves foráneas
        Schema::enableForeignKeyConstraints();

        $this->command->info('¡Base de datos poblada exitosamente!');
    }
}
