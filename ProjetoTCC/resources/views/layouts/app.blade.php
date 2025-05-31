<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    {{-- Inclui os assets compilados pelo Vite (CSS/JS) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Stack para estilos específicos da página --}}
    @stack('styles')
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        {{-- Aqui você pode adicionar um menu de navegação, se tiver --}}
        {{-- Exemplo: @include('layouts.navigation') --}}

        {{-- Conteúdo principal da página --}}
        <main>
            @yield('content')
        </main>

        {{-- Aqui você pode adicionar um rodapé, se tiver --}}
        {{-- Exemplo: @include('layouts.footer') --}}
    </div>
    {{-- Stack para scripts específicos da página --}}
    @stack('scripts')
</body>
</html>

