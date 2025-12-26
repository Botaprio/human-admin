<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else

    @endif
</head>
<body style="background-image: url('{{ asset('img/fondo.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat; height: 100vh; margin: 0;" class="text-[#FFFFFF] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">
<header class="w-full lg:max-w-4xl max-w-[335px] text-sm mb-6 not-has-[nav]:hidden">
    @if (Route::has('login'))
        <nav class="flex items-center justify-end gap-4">
            @auth
                <a
                    href="{{ url('/dashboard') }}"
                    class="inline-block px-5 py-1.5 border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] rounded-sm text-sm leading-normal"
                >
                    Agregar Usuario
                </a>
            @else
                <a
                    href="{{ route('login') }}"
                    class="inline-block px-6 py-3 text-lg text-[#1b1b18] border border-gray-300 hover:border-gray-400 rounded-lg shadow-md hover:shadow-lg leading-normal"
                >
                    Iniciar Sesión
                </a>

                @if (Route::has('register'))
                    <a
                        href="{{ route('register') }}"
                        class="inline-block px-6 py-3 text-lg text-[#1b1b18] border border-gray-300 hover:border-gray-400 rounded-lg shadow-md hover:shadow-lg leading-normal"
                    >
                        Registrarse
                    </a>
                @endif
            @endauth
        </nav>
    @endif
</header>
<div class="flex items-center justify-center w-full transition-opacity opacity-100 duration-750 lg:grow starting:opacity-0">
    <div class="flex flex-col items-center justify-center w-full max-w-4xl">
        <img src="{{ asset('img/Logo_FondoOscuro.svg') }}" alt="Logo" class="w-full h-auto mb-6">
        <h1 class="text-4xl font-bold mb-2 text-gray-200" style="text-shadow: 1px 1px 2px #000000;">Bienvenido a la Plataforma de creación de Usuarios</h1>
        <p class="text-xl text-gray-300" style="text-shadow: 1px 1px 2px #000000;">Inicia sesión o regístrate para continuar.</p>
    </div>
</div>

@if (Route::has('login'))
    <div class="h-14.5 hidden lg:block"></div>
@endif
</body>
</html>
