@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Editar Categoría: {{ $category->name }}</h1>
        <form action="{{ route('admin.categories.update', $category) }}" method="POST">
            @method('PUT')
            @include('admin.categories._form')
        </form>
    </div>
@endsection
