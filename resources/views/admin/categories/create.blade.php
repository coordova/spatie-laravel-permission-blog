@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Crear Nueva Categoría</h1>
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @include('admin.categories._form')
        </form>
    </div>
@endsection
