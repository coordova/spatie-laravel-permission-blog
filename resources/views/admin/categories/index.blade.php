@extends('layouts.app') {{-- O un layout de admin si lo tienes --}}

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Gestionar Categorías</h1>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">Crear Nueva Categoría</a>
        </div>

        @include('partials.alerts') {{-- Incluir parcial para mostrar mensajes success/error --}}

        @if($categories->count())
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Slug</th>
                    <th>Creado</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                @foreach($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->slug }}</td>
                        <td>{{ $category->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-warning">Editar</a>
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Estás seguro de eliminar esta categoría?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{-- Paginación --}}
            {{ $categories->links() }}
        @else
            <p>No hay categorías creadas.</p>
        @endif
    </div>
@endsection
