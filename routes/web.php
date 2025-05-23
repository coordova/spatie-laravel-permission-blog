<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;

/*Route::get('/', function () {
    return view('welcome');
});*/

// Rutas públicas (o que requieren 'posts.view.published')
Route::get('/', [PostController::class, 'indexPublished'])->name('posts.index.published'); // Página principal muestra posts publicados
Route::get('/posts/{post}', [PostController::class, 'show'])->where('post', '[0-9]+')->name('posts.show'); // Ver detalle post

// Rutas de Autenticación (si usas Laravel UI/Breeze/Jetstream)
//Auth::routes();
Route::get('/home', [HomeController::class, 'index'])->name('home'); // Dashboard básico post-login


/* ----------------------------------------------------------- */
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
/* ----------------------------------------------------------- */

// Rutas que requieren Autenticación General
Route::middleware('auth')->group(function () {
    // --- Gestión de Perfil ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- Gestión de Posts ---
    Route::prefix('posts')->name('posts.')->group(function () {
        // Crear Post (Writer, Editor, Admin)
        Route::get('/create', [PostController::class, 'create'])->name('create'); // Policy verifica 'create'
        Route::post('/', [PostController::class, 'store'])->name('store'); // Policy verifica 'create'

        // Editar/Actualizar Post (Editor, Admin, o Writer para propios)
        Route::get('/{post}/edit', [PostController::class, 'edit'])->name('edit'); // Policy verifica 'update'
        Route::put('/{post}', [PostController::class, 'update'])->name('update'); // Policy verifica 'update'

        // Publicar/Despublicar (Editor, Admin)
        Route::patch('/{post}/publish', [PostController::class, 'publish'])
            ->middleware('permission:posts.publish') // Permiso directo o Policy check dentro del método
            ->name('publish');

        // Eliminar Post (Editor, Admin)
        Route::delete('/{post}', [PostController::class, 'destroy'])->name('destroy'); // Policy verifica 'delete'
    });

    // --- Gestión de Comentarios (asociados a un Post) ---
    Route::prefix('posts/{post}/comments')->name('posts.comments.')->group(function() {
        // Crear comentario (Cualquier usuario autenticado con permiso 'comments.create')
        Route::post('/', [CommentController::class, 'store'])->name('store'); // Policy verifica 'create'

        // Editar/Actualizar comentario (Moderador o autor con permiso 'edit.own')
        Route::get('/{comment}/edit', [CommentController::class, 'edit'])->name('edit'); // Policy verifica 'update'
        Route::put('/{comment}', [CommentController::class, 'update'])->name('update'); // Policy verifica 'update'

        // Eliminar comentario (Moderador o autor con permiso 'delete.own')
        Route::delete('/{comment}', [CommentController::class, 'destroy'])->name('destroy'); // Policy verifica 'delete'
    });


    // --- Sección de Administración ---
    Route::prefix('admin')->middleware('role:Admin|Editor')->name('admin.')->group(function() {

        // Dashboard Admin (opcional)
        // Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Ver TODOS los posts (para gestión)
        Route::get('/posts', [PostController::class, 'indexAll'])
            ->middleware('permission:posts.view') // Solo Editor/Admin
            ->name('posts.index');

        // Gestión de Categorías (Editor, Admin) - Usa authorizeResource en Controller
        Route::resource('categories', CategoryController::class)->except(['show']);

        // Gestión de Tags (Editor, Admin) - Usa authorizeResource en Controller
        Route::resource('tags', TagController::class)->except(['show']);

        // Moderación de Comentarios (Editor, Admin)
        Route::get('/comments', [CommentController::class, 'indexForModeration'])
            ->middleware('permission:comments.moderate')
            ->name('comments.index');
        // Aquí podrías añadir rutas PUT/PATCH para aprobar/rechazar comentarios si lo necesitas

        // Gestión de Usuarios (SOLO Admin)
        Route::middleware('role:Admin')->group(function() {
            // Route::resource('users', UserController::class); // Si tienes UserController
            // Ejemplo ruta simple:
            // Route::get('/users', [UserController::class, 'index'])->name('users.index');
        });
    });
});

require __DIR__.'/auth.php';
