<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Bloggest')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=nunito:400,600,700" rel="stylesheet" />

    <!-- Scripts y Estilos con Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="flex flex-col min-h-screen bg-background text-text">
        <nav class="bg-primary shadow-md">
            <div class="container mx-auto px-4">
                <div class="flex justify-between items-center py-4">
                    <!-- Logo -->
                    <a href="{{ route('posts.index') }}" class="text-2xl font-bold text-accent">
                        Bloggest
                    </a>

                    <!-- Links de Navegación -->
                    <div class="flex items-center space-x-6">
                        <a href="{{ route('posts.index') }}" class="nav-link">Posts</a>

                        @auth
                            <a href="{{ route('dashboard') }}" class="nav-link">Dashboard</a>

                            @can('access-admin-panel')
                                <a href="{{ route('admin.users.index') }}" class="nav-link">Panel Admin</a>
                            @endcan

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="nav-link">Cerrar Sesión</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="nav-link">Login</a>
                            <a href="{{ route('register') }}" class="nav-link">Registro</a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Contenido de la Página -->
        <main class="container mx-auto px-4 py-8 flex-grow">
            
            <!-- Mensajes de Sesión (Success/Error) -->
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            @yield('content')
        </main>

        <footer class="bg-primary-dark text-center text-sm text-gray-400 py-4 mt-auto">
            © {{ date('Y') }} Bloggest. Todos los derechos reservados.
        </footer>
    </div>
</body>
</html>