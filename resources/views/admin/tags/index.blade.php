@extends('layouts.app') {{-- O un layout de admin si lo tienes --}}

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Gestionar Categorías</h1>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">Crear Nueva Categoría</a>
        </div>

        @include('partials.alerts') {{-- Incluir parcial para mostrar mensajes success/error --}}

    </div>
@endsection