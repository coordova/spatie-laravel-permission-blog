<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use Illuminate\Support\Facades\Hash; // Importar Hash
use Spatie\Permission\Models\Role;   // Importar Role

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Crear usuarios específicos con roles definidos
        $this->command->info('Creando usuarios específicos (Admin, Editor, Writer, Viewer)...');

        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'], // Clave para buscar/crear
            [ // Valores si se crea nuevo
                'name' => 'Admin User',
                'password' => Hash::make('password')
            ]
        );
        $admin->assignRole('Admin'); // Asigna el rol (asegúrate que exista desde RolePermissionSeeder)

        $editor = User::firstOrCreate(
            ['email' => 'editor@example.com'],
            ['name' => 'Editor User', 'password' => Hash::make('password')]
        );
        $editor->assignRole('Editor');

        $writer = User::firstOrCreate(
            ['email' => 'writer@example.com'],
            ['name' => 'Writer User', 'password' => Hash::make('password')]
        );
        $writer->assignRole('Writer');

        $viewer = User::firstOrCreate(
            ['email' => 'viewer@example.com'],
            ['name' => 'Viewer User', 'password' => Hash::make('password')]
        );
        $viewer->assignRole('Viewer');

        // 2. Crear usuarios aleatorios adicionales (ej: 10 más)
        $this->command->info('Creando 10 usuarios aleatorios adicionales (con rol Viewer)...');
        $viewerRole = Role::where('name', 'Viewer')->first(); // Obtener el rol Viewer

        if ($viewerRole) {
            User::factory(10)->create()->each(function ($user) use ($viewerRole) {
                $user->assignRole($viewerRole); // Asignar rol Viewer a los aleatorios
            });
        } else {
            User::factory(10)->create(); // Crear sin rol si 'Viewer' no existe
            $this->command->warn('Rol "Viewer" no encontrado. Usuarios aleatorios creados sin rol.');
        }


        $this->command->info('Seeder de Usuarios completado.');
    }
}
