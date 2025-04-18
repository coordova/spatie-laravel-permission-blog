<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // 2. Crear Permisos Base (Posts y Users - como en el ejemplo anterior)
        Permission::firstOrCreate(['name' => 'posts.create']);
        Permission::firstOrCreate(['name' => 'posts.view']);
        Permission::firstOrCreate(['name' => 'posts.view.published']);
        Permission::firstOrCreate(['name' => 'posts.edit']);
        Permission::firstOrCreate(['name' => 'posts.edit.own']);
        Permission::firstOrCreate(['name' => 'posts.delete']);
        Permission::firstOrCreate(['name' => 'posts.publish']);
        Permission::firstOrCreate(['name' => 'users.manage']); // Permiso para gestión de usuarios

        // 3. Crear Permisos Nuevos (Categories, Tags, Comments)
        Permission::firstOrCreate(['name' => 'categories.manage']); // CRUD para categorías
        Permission::firstOrCreate(['name' => 'tags.manage']);       // CRUD para tags
        Permission::firstOrCreate(['name' => 'comments.create']);     // Crear comentarios
        Permission::firstOrCreate(['name' => 'comments.moderate']);   // Ver todos, Editar, Eliminar comentarios (moderación)
        Permission::firstOrCreate(['name' => 'comments.edit.own']);   // Editar comentarios propios
        Permission::firstOrCreate(['name' => 'comments.delete.own']); // Eliminar comentarios propios

        // 4. Crear Roles (asegúrate de que existan o créalos)
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $editorRole = Role::firstOrCreate(['name' => 'Editor']);
        $writerRole = Role::firstOrCreate(['name' => 'Writer']);
        $viewerRole = Role::firstOrCreate(['name' => 'Viewer']);

        // 5. Asignar TODOS los permisos al Admin (forma explícita)
        // Admin: Tiene todos los permisos (implícito o explícito)
        // No es necesario asignar todos si usas Gate::before (ver config/auth.php)
        // pero para claridad, podemos asignarlos:
        $allPermissions = Permission::pluck('name')->toArray(); // Obtiene todos los nombres de permisos
        $adminRole->syncPermissions($allPermissions); // syncPermissions quita los no listados y añade los nuevos
        // O alternativamente, si configuras un Gate::before para admins, no necesitas esto.


        // 6. Asignar permisos específicos a otros roles usando syncPermissions
        $editorRole->syncPermissions([
            'posts.create',
            'posts.view',
            'posts.edit',
            'posts.delete',
            'posts.publish',
            'categories.manage', // Nuevo
            'tags.manage',       // Nuevo
            'comments.create',   // Nuevo
            'comments.moderate', // Nuevo (implica poder editar/eliminar cualquier comentario)
        ]);

        $writerRole->syncPermissions([
            'posts.create',
            'posts.view', // Puede ver todos, pero solo editar los suyos
            'posts.edit.own',
            'comments.create',     // Nuevo
            'comments.edit.own',   // Nuevo
            'comments.delete.own', // Nuevo
        ]);

        $viewerRole->syncPermissions([
            'posts.view.published',
            'comments.create', // Nuevo: Permitir a los viewers comentar
        ]);

        $this->command->info('Roles y permisos (incluyendo nuevos) creados y asignados correctamente.');
        // No olvides llamar a UserSeeder si lo tienes para crear usuarios con roles - desde el DatabaseSeeder.php
        // $this->call(UserSeeder::class);
    }
}
