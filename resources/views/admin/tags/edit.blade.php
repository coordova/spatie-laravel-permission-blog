@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Editar Tag: {{ $tag->name }}</h1>
        <form action="{{ route('admin.tags.update', $tag) }}" method="POST">
            @method('PUT')
            @include('admin.tags._form')
        </form>
    </div>
@endsection