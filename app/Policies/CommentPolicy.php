<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CommentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('comments.moderate');
    }

    // Ver un comentario específico (generalmente permitido si se puede ver el post)
    // Podría ser más complejo si hay comentarios privados, etc.
    // Por simplicidad, cualquiera que pueda crear, puede ver (implícito al ver el post)
    // No definiremos 'view' explícitamente aquí a menos que sea necesario restringir.
    /**
     * Determine whether the user can view the model.
     */
    /*public function view(User $user, Comment $comment): bool
    {
        return false;
    }*/

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Cualquiera con el permiso puede intentar crear
        return $user->can('comments.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Comment $comment): bool
    {
        // El usuario puede moderar O (es el autor Y puede editar los propios)
        return $user->can('comments.moderate') ||
            ($user->id === $comment->user_id && $user->can('comments.edit.own'));
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Comment $comment): bool
    {
        // El usuario puede moderar O (es el autor Y puede eliminar los propios)
        return $user->can('comments.moderate') ||
            ($user->id === $comment->user_id && $user->can('comments.delete.own'));
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Comment $comment): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Comment $comment): bool
    {
        return false;
    }
}
