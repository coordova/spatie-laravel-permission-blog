{{-- resources/views/admin/posts/index.blade.php --}}
{{-- Esta vista es para que Admins/Editors gestionen TODOS los posts --}}

@extends('layouts.app') {{-- O tu layout de administración si tienes uno específico --}}

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Gestionar Posts</h1>
            {{-- Solo muestra el botón Crear si el usuario tiene permiso --}}
            @can('create', App\Models\Post::class)
                <a href="{{ route('posts.create') }}" class="btn btn-primary">Crear Nuevo Post</a>
            @endcan
        </div>

        @include('partials.alerts') {{-- Mostrar mensajes de éxito/error --}}

        @if($posts->count())
            <div class="table-responsive"> {{-- Para mejor visualización en pantallas pequeñas --}}
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Autor</th>
                        <th>Categorías</th>
                        <th>Tags</th>
                        <th>Estado</th>
                        <th>Creado</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($posts as $post)
                        <tr>
                            <td>{{ $post->id }}</td>
                            <td>
                                {{-- Enlace al post público para previsualizar --}}
                                <a href="{{ route('posts.show', $post) }}" target="_blank" title="Ver Post Público">
                                    {{ Str::limit($post->title, 50) }} {{-- Limitar título largo --}}
                                </a>
                            </td>
                            <td>{{ $post->user->name ?? 'N/A' }}</td>
                            <td>
                                {{-- Mostrar algunas categorías, hacer clic podría llevar a filtrar (más avanzado) --}}
                                @forelse($post->categories->take(3) as $category)
                                    <span class="badge bg-secondary">{{ $category->name }}</span>
                                @empty
                                    <small class="text-muted">Ninguna</small>
                                @endforelse
                                @if($post->categories->count() > 3)
                                    <small class="text-muted">...</small>
                                @endif
                            </td>
                            <td>
                                {{-- Mostrar algunos tags --}}
                                @forelse($post->tags->take(4) as $tag)
                                    <span class="badge bg-info text-dark">{{ $tag->name }}</span>
                                @empty
                                    <small class="text-muted">Ninguno</small>
                                @endforelse
                                @if($post->tags->count() > 4)
                                    <small class="text-muted">...</small>
                                @endif
                            </td>
                            <td>
                                @if($post->is_published)
                                    <span class="badge bg-success">Publicado</span>
                                @else
                                    <span class="badge bg-warning text-dark">Borrador</span>
                                @endif
                            </td>
                            <td>{{ $post->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                {{-- Botón Editar (si tiene permiso) --}}
                                @can('update', $post)
                                    <a href="{{ route('posts.edit', $post) }}" class="btn btn-sm btn-warning mb-1" title="Editar">
                                        <i class="fas fa-edit"></i> Editar <!-- Asume FontAwesome o similar -->
                                    </a>
                                @endcan

                                {{-- Botón Publicar/Despublicar (si tiene permiso) --}}
                                @can('posts.publish')
                                    <form action="{{ route('posts.publish', $post) }}" method="POST" class="d-inline-block mb-1" title="{{ $post->is_published ? 'Despublicar' : 'Publicar' }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm {{ $post->is_published ? 'btn-secondary' : 'btn-success' }}">
                                            <i class="fas {{ $post->is_published ? 'fa-eye-slash' : 'fa-eye' }}"></i> {{ $post->is_published ? 'Ocultar' : 'Publicar' }}
                                        </button>
                                    </form>
                                @endcan

                                {{-- Botón Eliminar (si tiene permiso) --}}
                                @can('delete', $post)
                                    <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-inline-block mb-1" onsubmit="return confirm('¿Estás seguro de eliminar este post?');" title="Eliminar">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i> Eliminar
                                        </button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Paginación --}}
            <div class="mt-4">
                {{ $posts->links() }}
            </div>

        @else
            <div class="alert alert-info" role="alert">
                No se encontraron posts. ¡Puedes <a href="{{ route('posts.create') }}">crear uno nuevo</a>!
            </div>
        @endif

    </div>
    {{-- Añadir FontAwesome si usas los iconos --}}
    {{-- @push('scripts')
    <script src="https://kit.fontawesome.com/xxxxxxxxxx.js" crossorigin="anonymous"></script>
    @endpush --}}
@endsection
