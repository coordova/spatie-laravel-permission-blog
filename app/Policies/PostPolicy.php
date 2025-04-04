<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PostPolicy
{
    /**
     * Determine whether the user can view any models.
     * Usado por $user->can('viewAny', Post::class)
     */
    public function viewAny(User $user): bool
    {
        // Cualquiera con permiso 'posts.view' o 'posts.view.published' puede ver listas
        return $user->hasAnyPermission(['posts.view', 'posts.view.published']);
    }

    /**
     * Determine whether the user can view the model.
     * Usado por $user->can('view', $post)
     */
    public function view(User $user, Post $post): bool
    {
        // Si el post está publicado Y el usuario tiene permiso para ver publicados
        if ($post->is_published && $user->can('posts.view.published')) {
            return true;
        }
        // Si el usuario tiene permiso para ver CUALQUIER post (incluso no publicados)
        if ($user->can('posts.view')) {
            return true;
        }
        // Si el usuario es el autor, podría verlo aunque no esté publicado (si así lo decides)
        // if ($post->user_id === $user->id) {
        //     return true;
        // }

        return false;
    }

    /**
     * Determine whether the user can create models.
     * Usado por $user->can('create', Post::class)
     */
    public function create(User $user): bool
    {
        return $user->can('posts.create');
    }

    /**
     * Determine whether the user can update the model.
     * Usado por $user->can('update', $post)
     */
    public function update(User $user, Post $post): bool
    {
        // Si tiene permiso general para editar
        if ($user->can('posts.edit')) {
            return true;
        }
        // Si tiene permiso para editar propios Y es el autor
        if ($user->can('posts.edit.own') && $post->user_id === $user->id) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     * Usado por $user->can('delete', $post)
     */
    public function delete(User $user, Post $post): bool
    {
        return $user->can('posts.delete');
    }

    /**
     * Determine whether the user can publish the model.
     * Método personalizado, no estándar de Policy.
     * Lo llamaremos explícitamente: $user->can('publish', $post)
     */
    public function publish(User $user, Post $post): bool
    {
        return $user->can('posts.publish');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Post $post): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Post $post): bool
    {
        return false;
    }

    /**
     * Opcional: Permitir a los Admins hacer todo sin verificar permisos específicos.
     * Descomenta esto si quieres que los Admins siempre pasen las validaciones.
     */
    // public function before(User $user, $ability)
    // {
    //     if ($user->hasRole('Admin')) {
    //         return true;
    //     }
    // }
}
