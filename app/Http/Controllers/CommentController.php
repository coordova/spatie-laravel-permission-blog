<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    // Middleware de autenticación para todas las acciones de comentarios
    public function __construct()
    {
//        $this->middleware('auth');
    }

    // Almacenar un nuevo comentario asociado a un Post
    public function store(Request $request, Post $post)
    {
        // Verificar si el usuario PUEDE crear comentarios en general
        // No pasamos un Comment específico, sino la clase, para la policy 'create'
//        $this->authorize('create', Comment::class);

        $validated = $request->validate([
            'body' => 'required|string|max:2000',
        ]);

        // Crear el comentario y asociarlo
        $post->comments()->create([
            'body' => $validated['body'],
            'user_id' => Auth::id(), // Asignar el usuario autenticado
        ]);

        return back()->with('success', 'Comentario añadido.'); // Volver a la página del post
    }

    // Mostrar formulario para editar un comentario (si es necesario)
    public function edit(Comment $comment)
    {
        // Verifica usando CommentPolicy@update
//        $this->authorize('update', $comment);
        // Podrías retornar una vista simple o hacerlo con JS en la misma página
        return view('comments.edit', compact('comment')); // Necesitarás crear esta vista
    }

    // Actualizar un comentario existente
    public function update(Request $request, Comment $comment)
    {
        // Verifica usando CommentPolicy@update
//        $this->authorize('update', $comment);

        $validated = $request->validate([
            'body' => 'required|string|max:2000',
        ]);

        $comment->update($validated);

        // Redirigir de vuelta al post donde estaba el comentario
        return redirect()->route('posts.show', $comment->post_id)->with('success', 'Comentario actualizado.');
    }

    // Eliminar un comentario
    public function destroy(Comment $comment)
    {
        // Verifica usando CommentPolicy@delete
//        $this->authorize('delete', $comment);

        $postId = $comment->post_id; // Guardar ID antes de borrar
        $comment->delete();

        // Redirigir de vuelta al post o a la página anterior
        return back()->with('success', 'Comentario eliminado.');
    }

    // --- Para Moderación ---
    public function indexForModeration()
    {
        // Verifica si el usuario puede moderar (ver la lista completa)
        // Usa el método viewAny de CommentPolicy
//        $this->authorize('viewAny', Comment::class);

        $comments = Comment::with(['user', 'post'])->latest()->paginate(20); // Cargar relaciones
        return view('admin.comments.index', compact('comments')); // Necesitarás crear esta vista
    }
}
