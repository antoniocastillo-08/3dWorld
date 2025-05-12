<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title', config('app.name', '3dWorld'))</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

        <!-- Tailwind via Vite -->
        @vite('resources/css/app.css')
        @vite('resources/js/app.js')
    </head>
    <body class="font-sans antialiased bg-neutral-30 text-gray-800 flex flex-col min-h-screen">

        <nav class="bg-gradient-to-b from-teal-300 to-white border-b border-black shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16 items-center">
                    <!-- Brand -->
                    <a href="/" class="text-xl font-semibold text-indigo-600">3dWorld</a>

                    <!-- Mobile menu button -->
                    <div class="lg:hidden">
                        <button type="button" class="text-gray-500 hover:text-gray-700 focus:outline-none focus:text-gray-700" id="mobile-menu-toggle">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>
                    </div>

                    <!-- Desktop Menu -->
                    <div class="hidden lg:flex space-x-4 items-center">
                        @guest
                            <a href="/login" class="text-gray-700 hover:text-indigo-600 transition">Login</a>
                            <a href="/register" class="text-gray-700 hover:text-indigo-600 transition">Register</a>
                        @else
                            <a href="/models3d/create" class="text-gray-700 hover:text-indigo-600 flex items-center space-x-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M8 4a.5.5 0 0 1 .5.5V7h2.5a.5.5 0 0 1 0 1H8.5v2.5a.5.5 0 0 1-1 0V8H5a.5.5 0 0 1 0-1h2.5V4.5A.5.5 0 0 1 8 4z"/>
                                </svg>
                                <span>Create</span>
                            </a>
                            <a href="/profile" class="text-gray-700 hover:text-indigo-600 transition">Profile</a>
                            <a href="/printers" class="block text-gray-700 hover:text-indigo-600">Printers</a>

                        @endguest
                    </div>
                </div>
            </div>

            <!-- Mobile Menu (hidden by default) -->
            <div id="mobile-menu" class="lg:hidden hidden px-4 pb-4 space-y-2">
                @guest
                    <a href="/login" class="block text-gray-700 hover:text-indigo-600">Login</a>
                    <a href="/register" class="block text-gray-700 hover:text-indigo-600">Register</a>
                @else
                    <a href="/models3d/create" class="block text-gray-700 hover:text-indigo-600">Create</a>
                    <a href="/profile" class="block text-gray-700 hover:text-indigo-600">Profile</a>
                    <a href="/printers" class="block text-gray-700 hover:text-indigo-600">Printers</a>

                @endguest
            </div>
        </nav>

        <main class="flex-grow">
            @yield('content')
            
        </main>
        <footer class="bg-gray-500 py-6 text-white">
            <div class="max-w-7xl mx-auto px-4 flex flex-col md:flex-row justify-between gap-8 text-center md:text-left">
                
                <div class="flex-auto">
                    <h3 class="font-semibold text-lg mb-2">Contacto</h3>
                    <p>Email: contacto@3dworld.com</p>
                    <p>Teléfono: +34 123 456 789</p>
                </div>
                

                
                <div class="flex-auto">
                    <h3 class="font-semibold text-lg mb-2">Redes Sociales</h3>
                    <a href="#" class="block hover:underline">Twitter</a>
                    <a href="#" class="block hover:underline">LinkedIn</a>
                    <a href="#" class="block hover:underline">Instagram</a>
                </div>
        
            </div>
        </footer>
        
        <!-- Toggle mobile menu -->
        <script>
            document.getElementById('mobile-menu-toggle')?.addEventListener('click', function () {
                const menu = document.getElementById('mobile-menu');
                menu.classList.toggle('hidden');
            });
        </script>

    </body>
</html>