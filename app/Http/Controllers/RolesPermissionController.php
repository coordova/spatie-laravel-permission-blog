<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthorizationController extends Controller
{
    /**
     * @var string[]
     *
     * Roles a Definir:
     * Admin: Control total sobre todo.
     * Editor: Puede crear, ver, editar y publicar artículos.
     * Writer: Puede crear, ver y editar sus propios artículos, pero no publicarlos.
     * Viewer: Solo puede ver artículos publicados.
     */
    public $roles = [
        'admin',     // Control total
        'editor',    // Editor
        'writer',    // Writer
        'viewer'     // Viewer
    ];

    /**
     * @var string[]
     *
     * Permisos a Definir (usaremos la convención recurso.accion):
     * posts.create: Crear artículos.
     * posts.view: Ver cualquier artículo (publicado o no).
     * posts.view.published: Ver solo artículos publicados.
     * posts.edit: Editar cualquier artículo.
     * posts.edit.own: Editar solo sus propios artículos.
     * posts.delete: Eliminar cualquier artículo.
     * posts.publish: Publicar/despublicar artículos.
     * users.manage: Gestionar usuarios (crear, editar, eliminar - solo para Admin).
     * categories.manage: Gestionar categorías (crear, editar, eliminar - solo para Admin).
     * tags.manage: Gestionar tags (crear, editar, eliminar - solo para Admin).
     * comments.create: Crear comentarios.
     * comments.edit.own: Editar/Actualizar comentario (Moderador o autor con permiso 'edit.own').
     * comments.delete.own: Eliminar comentario (Moderador o autor con permiso 'delete.own').
     * comments.moderate: Ver todos, Editar, Eliminar comentarios (moderación) (Admin).
     */
    public $permissions = [
        'post.create',          // Crear post (Writer, Editor, Admin)
        'post.view',            // Ver cualquier post
        'post.view.published',  // Ver posts publicados
        'post.edit',            // Editar/Actualizar post (Editor, Admin, o Writer para propios)
        'post.edit.own',        // Editar/Actualizar post (Editor, Admin, o Writer para propios)
        'post.delete',          // Eliminar post (Editor, Admin)
        'post.publish',         // Publicar/despublicar post (Editor, Admin)

        'users.manage',         // CRUD para Gestión de usuarios (Admin)

        'categories.manage',    // CRUD para categorías (Admin)

        'tags.manage',          // CRUD para tags (Admin)

        'comments.create',      // Crear comentarios (Cualquier usuario autenticado con permiso 'comments.create')
        'comments.edit.own',    // Editar/Actualizar comentario (Moderador o autor con permiso 'edit.own')
        'comments.delete.own',  // Eliminar comentario (Moderador o autor con permiso 'delete.own')
        'comments.moderate',    // Ver todos, Editar, Eliminar comentarios (moderación) (Admin)

        /*'create-post',
        'update-post',
        'delete-post',
        'publish-post',
        'create-category',
        'update-category',
        'delete-category',
        'create-tag',
        'update-tag',
        'delete-tag',*/
    ];
}
