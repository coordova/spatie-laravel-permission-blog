@extends('layouts.app') {{-- Asume que tienes un layout base --}}

@section('content')
    <div class="container">
        <h1>{{ $post->title }}</h1>
        <p><em>Por: {{ $post->user->name }} el {{ $post->created_at->format('d/m/Y') }}</em></p>

        {{-- Mostrar Categorías --}}
        @if($post->categories->count())
            <p>
                Categorías:
                @foreach($post->categories as $category)
                    <span class="badge bg-secondary">{{ $category->name }}</span>
                @endforeach
            </p>
        @endif

        {{-- Mostrar Tags --}}
        @if($post->tags->count())
            <p>
                Tags:
                @foreach($post->tags as $tag)
                    <span class="badge bg-info text-dark">{{ $tag->name }}</span>
                @endforeach
            </p>
        @endif

        {{-- Contenido del Post (usa {!! !!} con precaución si permites HTML) --}}
        <div>{!! nl2br(e($post->content)) !!}</div>

        <hr>

        {{-- Acciones sobre el Post (Editar, Publicar, Eliminar) --}}
        @auth {{-- Solo mostrar a usuarios autenticados --}}
        <div class="my-3">
            @can('update', $post)
                <a href="{{ route('posts.edit', $post) }}" class="btn btn-sm btn-warning">Editar Post</a>
            @endcan

            @can('posts.publish') {{-- Permiso directo o policy --}}
            <form action="{{ route('posts.publish', $post) }}" method="POST" style="display:inline;">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn btn-sm {{ $post->is_published ? 'btn-secondary' : 'btn-success' }}">
                    {{ $post->is_published ? 'Despublicar' : 'Publicar' }}
                </button>
            </form>
            @endcan

            @can('delete', $post)
                <form action="{{ route('posts.destroy', $post) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Estás seguro de eliminar este post?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">Eliminar Post</button>
                </form>
            @endcan
        </div>
        @endauth


        {{-- Sección de Comentarios --}}
        <h3>Comentarios ({{ $post->comments->count() }})</h3>

        {{-- Formulario para Añadir Comentario --}}
        @can('create', App\Models\Comment::class) {{-- Verifica si puede crear comentarios --}}
        <div class="card my-3">
            <div class="card-body">
                <h5 class="card-title">Añadir Comentario</h5>
                <form action="{{ route('posts.comments.store', $post) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <textarea name="body" class="form-control @error('body') is-invalid @enderror" rows="3" required>{{ old('body') }}</textarea>
                        @error('body')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Enviar Comentario</button>
                </form>
            </div>
        </div>
        @else
            @guest {{-- Si no está logueado y no puede comentar --}}
            <p><a href="{{ route('login') }}">Inicia sesión</a> para comentar.</p>
            @else {{-- Si está logueado pero no tiene permiso (raro con config actual) --}}
            <p>No tienes permiso para comentar.</p>
            @endguest
        @endcan

        {{-- Lista de Comentarios Existentes --}}
        @forelse ($post->comments as $comment)
            <div class="card mb-3">
                <div class="card-body">
                    <p class="card-text">{{ $comment->body }}</p>
                    <small class="text-muted">
                        Por: {{ $comment->user->name }} - {{ $comment->created_at->diffForHumans() }}
                    </small>

                    {{-- Acciones sobre el Comentario (Editar/Eliminar) --}}
                    @auth
                        <div class="mt-2">
                            @can('update', $comment)
                                {{-- Podrías enlazar a una ruta de edición o usar JS para edición inline --}}
                                <a href="{{ route('posts.comments.edit', [$post, $comment]) }}" class="btn btn-sm btn-outline-secondary">Editar</a>
                            @endcan
                            @can('delete', $comment)
                                <form action="{{ route('posts.comments.destroy', [$post, $comment]) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Eliminar este comentario?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Eliminar</button>
                                </form>
                            @endcan
                        </div>
                    @endauth
                </div>
            </div>
        @empty
            <p>No hay comentarios aún.</p>
        @endforelse

    </div>
@endsection
