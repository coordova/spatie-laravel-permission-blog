@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Editar Post: {{ $post->title }}</h1>

        <form action="{{ route('posts.update', $post) }}" method="POST">
            @method('PUT') {{-- Método HTTP para actualizar --}}
            @include('posts._form') {{-- Reutiliza el parcial del formulario --}}
        </form>
    </div>
@endsection
