<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <script src="https://cdn.tailwindcss.com"></script>
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        /* Estilos personalizados adicionales */
        [x-cloak] { 
            display: none !important; 
        }

        /* Si quieres usar las variables que tenías antes, 
           puedes dejarlas aquí, pero el fondo ahora lo controla Tailwind 
        */
        :root {
            --bg-color: #f0f4f8; 
        }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-[#f0f4f8]">
        @include('layouts.navigation')

        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <main>
            @yield('content')
            
            {{-- 
               Esto permite que los componentes que usen <x-app-layout> 
               también muestren su contenido aquí 
            --}}
            @isset($slot)
                {{ $slot }}
            @endisset
        </main>
    </div>
</body>
</html>