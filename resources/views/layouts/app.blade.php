<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    {{-- Asumiendo Bootstrap 5 si usaste Laravel UI --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- O si usas Vite: --}}
    {{-- @vite(['resources/sass/app.scss', 'resources/js/app.js']) --}}

    {{-- Estilos adicionales si los tienes --}}
    {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}

</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto">
                    {{-- Enlace público a Posts --}}
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('posts.index.published') }}">Blog</a>
                    </li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        {{-- USUARIO AUTENTICADO --}}

                        {{-- Enlace para Crear Post --}}
                        @can('create', App\Models\Post::class)
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('posts.create') }}">Crear Post</a>
                            </li>
                        @endcan

                        {{-- Menú desplegable para Administración --}}
                        @hasanyrole('Admin|Editor') {{-- Verifica si tiene ROL Admin o Editor --}}
                        {{-- Alternativamente, podrías verificar permisos individuales si es más granular --}}
                        {{-- @canany(['posts.view', 'categories.manage', 'tags.manage', 'comments.moderate', 'users.manage']) --}}
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Administración
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="adminDropdown">
                                @can('posts.view') {{-- Permiso para ver lista admin de posts --}}
                                <li><a class="dropdown-item" href="{{ route('admin.posts.index') }}">Gestionar Posts</a></li>
                                @endcan
                                @can('categories.manage')
                                    <li><a class="dropdown-item" href="{{ route('admin.categories.index') }}">Gestionar Categorías</a></li>
                                @endcan
                                @can('tags.manage')
                                    <li><a class="dropdown-item" href="{{ route('admin.tags.index') }}">Gestionar Tags</a></li>
                                @endcan
                                @can('comments.moderate')
                                    <li><a class="dropdown-item" href="{{ route('admin.comments.index') }}">Moderar Comentarios</a></li>
                                @endcan
                                @role('Admin') {{-- Solo para ROL Admin --}}
                                <li><hr class="dropdown-divider"></li>
                                {{-- Ruta real si la tienes --}}
                                {{-- <li><a class="dropdown-item" href="{{ route('admin.users.index') }}">Gestionar Usuarios</a></li> --}}
                                <li><a class="dropdown-item" href="#">Gestionar Usuarios</a></li> {{-- Placeholder --}}
                                @endrole
                            </ul>
                        </li>
                        {{-- @endcanany --}} {{-- Cierre si usas canany --}}
                        @endhasanyrole {{-- Cierre si usas hasanyrole --}}


                        {{-- Menú desplegable del Usuario Logueado (Nombre y Logout) --}}
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                {{-- Puedes añadir enlaces a perfil, configuración, etc. aquí --}}
                                {{-- <a class="dropdown-item" href="#">Mi Perfil</a> --}}
                                {{-- <hr class="dropdown-divider"> --}}

                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        {{-- Contenedor para mensajes flash de sesión (éxito, error, etc.) --}}
        @include('partials.alerts') {{-- Asegúrate de tener este parcial --}}

        @yield('content') {{-- Aquí se inyecta el contenido de cada vista --}}
    </main>
</div>

<!-- Scripts -->
{{-- Asumiendo Bootstrap 5 --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
{{-- O si usas Vite (ya incluido arriba): --}}
{{-- @vite('resources/js/app.js') --}}

{{-- Scripts adicionales si los tienes --}}
{{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}
@stack('scripts') {{-- Para añadir scripts específicos desde otras vistas --}}
</body>
</html>
