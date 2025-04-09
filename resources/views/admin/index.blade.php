@extends('layouts.app') {{-- O layout admin --}}

@section('content')
    <div class="container">
        <h1>Moderar Comentarios</h1>

        @include('partials.alerts') {{-- Para mensajes de éxito/error --}}

        @if($comments->count())
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Autor</th>
                    <th>Comentario</th>
                    <th>En Post</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                @foreach($comments as $comment)
                    <tr>
                        <td>{{ $comment->id }}</td>
                        <td>{{ $comment->user->name ?? 'Usuario Eliminado' }}</td>
                        <td>{{ Str::limit($comment->body, 100) }}</td> {{-- Limitar texto largo --}}
                        <td>
                            <a href="{{ route('posts.show', $comment->post_id) }}" target="_blank">
                                {{ $comment->post->title ?? 'Post Eliminado' }}
                            </a>
                        </td>
                        <td>{{ $comment->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            {{-- El permiso 'comments.moderate' ya fue verificado para acceder aquí, --}}
                            {{-- por lo que estos usuarios SIEMPRE podrán editar/eliminar CUALQUIER comentario --}}
                            {{-- No necesitamos @can adicional aquí si la ruta está bien protegida --}}

                            {{-- Enlace para ver/editar (podría ser un modal o la ruta separada) --}}
                            {{-- <a href="{{ route('posts.comments.edit', [$comment->post_id, $comment]) }}" class="btn btn-sm btn-warning">Editar</a> --}}
                            <a href="{{ route('posts.show', $comment->post_id) }}#comment-{{ $comment->id }}" target="_blank" class="btn btn-sm btn-info">Ver</a> {{-- Enlace directo al comentario en el post --}}

                            <form action="{{ route('posts.comments.destroy', [$comment->post_id, $comment]) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Eliminar este comentario permanentemente?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                            </form>
                            {{-- Podrías añadir botones para Aprobar/Marcar Spam si implementas esa lógica --}}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{-- Paginación --}}
            {{ $comments->links() }}
        @else
            <p>No hay comentarios para moderar.</p>
        @endif
    </div>
@endsection
