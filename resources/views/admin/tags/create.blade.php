@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Crear Nuevo Tag</h1>
        <form action="{{ route('admin.tags.store') }}" method="POST">
            @include('admin.tags._form')
        </form>
    </div>
@endsection
{{-- Este archivo es para crear una nueva categoría. Se incluye el formulario de creación de categorías. --}}
{{-- El formulario se encuentra en el archivo _form.blade.php dentro de la carpeta admin/categories --}}
{{-- El método POST se utiliza para enviar datos al servidor para crear un nuevo recurso. --}}
{{-- La ruta 'admin.categories.store' se encarga de manejar la lógica de almacenamiento de la nueva categoría. --}}
{{-- El archivo _form.blade.php contiene el formulario para crear o editar una categoría. --}}
{{-- Se utiliza la directiva @include para incluir el formulario en esta vista. --}}
{{-- La directiva @section se utiliza para definir una sección de contenido que se puede extender en un layout. --}}
{{-- La directiva @extends se utiliza para extender un layout base. --}}
{{-- La directiva @csrf se utiliza para proteger contra ataques CSRF (Cross-Site Request Forgery). --}}