@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Crear Nuevo Post</h1>

        <form action="{{ route('posts.store') }}" method="POST">
            @include('posts._form') {{-- Incluye el parcial del formulario --}}
        </form>
    </div>
@endsection
