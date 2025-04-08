{{-- resources/views/posts/index.blade.php --}}
{{-- Esta vista muestra la lista pública de posts publicados --}}

@extends('layouts.app') {{-- Utiliza tu layout base --}}

@section('content')
    <div class="container">
        <h1 class="mb-4">Últimos Posts del Blog</h1>

        @include('partials.alerts') {{-- Mostrar alertas si es necesario --}}

        @if($posts->count())
            <div class="row row-cols-1 row-cols-md-2 g-4"> {{-- Ejemplo de layout en 2 columnas en pantallas medianas --}}
                @foreach($posts as $post)
                    <div class="col">
                        <div class="card h-100"> {{-- h-100 para igualar altura de tarjetas --}}
                            {{-- Podrías añadir una imagen destacada aquí si la tuvieras --}}
                            {{-- <img src="..." class="card-img-top" alt="..."> --}}
                            <div class="card-body d-flex flex-column"> {{-- flex-column para empujar el footer abajo --}}
                                <h5 class="card-title">
                                    <a href="{{ route('posts.show', $post) }}" class="text-decoration-none">
                                        {{ $post->title }}
                                    </a>
                                </h5>

                                {{-- Mostrar Categorías --}}
                                @if($post->categories->count())
                                    <div class="mb-2">
                                        @foreach($post->categories as $category)
                                            <span class="badge bg-secondary">{{ $category->name }}</span>
                                        @endforeach
                                    </div>
                                @endif

                                {{-- Extracto del contenido (puedes crear un helper o un método en el modelo para esto) --}}
                                <p class="card-text flex-grow-1">{{ Str::limit(strip_tags($post->content), 150) }}</p> {{-- flex-grow-1 para ocupar espacio --}}

                                {{-- Mostrar Tags --}}
                                @if($post->tags->count())
                                    <div class="mb-3">
                                        @foreach($post->tags as $tag)
                                            <span class="badge rounded-pill bg-info text-dark">{{ $tag->name }}</span>
                                        @endforeach
                                    </div>
                                @endif

                                <a href="{{ route('posts.show', $post) }}" class="btn btn-primary mt-auto">Leer Más</a> {{-- mt-auto para alinear al fondo --}}
                            </div>
                            <div class="card-footer text-muted">
                                Publicado por {{ $post->user->name ?? 'Usuario Desconocido' }} - {{ $post->created_at->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Paginación --}}
            <div class="mt-4">
                {{ $posts->links() }}
            </div>

        @else
            <div class="alert alert-info" role="alert">
                Aún no hay posts publicados. ¡Vuelve pronto!
            </div>
        @endif

    </div>
@endsection
