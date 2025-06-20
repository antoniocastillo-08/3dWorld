<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased bg-gradient-to-l from-white to-violet-950">

    <!--Fondo para el login-->
    <div class="min-h-screen flex flex-col md:flex-row">
        <!-- Imagen (solo visible en pantallas medianas o más grandes) -->
        <div class="hidden md:flex w-1/2 items-center justify-center bg-cover bg-center" style="background-image: url('/images/login_image.jpg');">
        </div>

        <!-- Login -->
        <div class="w-full md:w-1/2 flex items-center justify-center">
            <div class="w-full sm:max-w-md px-6 py-8 bg-white shadow-md overflow-hidden sm:rounded-lg">
                <div class="flex justify-center mb-6">
                    <a href="/">
                        <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                    </a>
                </div>
                {{ $slot }}
            </div>
        </div>
    </div>

</body>
</html>
