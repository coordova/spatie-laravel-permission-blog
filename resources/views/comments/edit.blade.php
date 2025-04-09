@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Editar Comentario</h1>
        <p>Comentario original en el post: <a href="{{ route('posts.show', $comment->post_id) }}">{{ $comment->post->title }}</a></p>

        <form action="{{ route('posts.comments.update', [$comment->post_id, $comment]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="body" class="form-label">Contenido del Comentario</label>
                <textarea name="body" id="body" class="form-control @error('body') is-invalid @enderror" rows="5" required>{{ old('body', $comment->body) }}</textarea>
                @error('body') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <button type="submit" class="btn btn-primary">Actualizar Comentario</button>
            <a href="{{ route('posts.show', $comment->post_id) }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
@endsection
