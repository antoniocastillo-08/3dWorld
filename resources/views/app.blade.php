<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', config('app.name', '3DWorld'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <!-- Tailwind via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="font-sans antialiased bg-neutral-30 text-gray-800 flex flex-col min-h-screen">

    <!-- Navbar -->
    <nav class="bg-teal-100 border-b border-black shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <!-- Brand -->
                <a href="/" class="text-xl font-semibold text-indigo-600">3DWorld</a>



                <!-- Menu Principal de Escritorio -->
                <div class="flex space-x-4 items-center">
                    @guest
                        <a href="/login" class="text-gray-700 hover:text-indigo-600 transition">Login</a>
                        <a href="/register" class="text-gray-700 hover:text-indigo-600 transition">Register</a>
                    @else

                        <a href="/company/options" class="text-gray-700 hover:text-indigo-600 transition">Company</a>

                        <a href="/printers" class="block text-gray-700 hover:text-indigo-600">Printers</a>

                        <a href="/models3d/create" class="text-gray-700 hover:text-indigo-600 flex items-center space-x-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500" fill="currentColor"
                                viewBox="0 0 16 16">
                                <path
                                    d="M8 4a.5.5 0 0 1 .5.5V7h2.5a.5.5 0 0 1 0 1H8.5v2.5a.5.5 0 0 1-1 0V8H5a.5.5 0 0 1 0-1h2.5V4.5A.5.5 0 0 1 8 4z" />
                            </svg>
                            <span>Create</span>
                        </a>
                        <a href="/profile" class="hover:opacity-80 transition">
                            <x-application-logo class="w-10 h-10 text-indigo-600" />
                    </a> @endguest
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-500 py-6 text-white mt-auto">
        <div class="max-w-4xl mx-auto flex flex-col md:flex-row justify-around gap-8 text-center md:text-center">

            <!-- Contacto -->
            <div class="flex-auto">
                <h3 class="font-semibold text-lg mb-2">Contact</h3>
                <p>Email: contacto@3dworld.com</p>
                <p>Phone: +34 123 456 789</p>
            </div>

            <!-- Redes Sociales -->
            <div class="flex-auto">
                <h3 class="font-semibold text-lg mb-2"></h3>
                <div class="flex gap-7 justify-center">
                    <!-- Twitter -->
                    <a href="#" class="block hover:underline" aria-label="X">
                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="32" height="32"
                            viewBox="0,0,256,256">
                            <g fill="#ffffff" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt"
                                stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0"
                                font-family="none" font-weight="none" font-size="none" text-anchor="none"
                                style="mix-blend-mode: normal">
                                <g transform="scale(8,8)">
                                    <path
                                        d="M4.01758,4l9.07422,13.60938l-8.75586,10.39063h2.61523l7.29492,-8.65625l5.77148,8.65625h0.53516h7.46289l-9.30273,-13.95703l8.46289,-10.04297h-2.61523l-7.00195,8.31055l-5.54102,-8.31055zM7.75586,6h3.19141l13.33203,20h-3.19141z">
                                    </path>
                                </g>
                            </g>
                        </svg>
                    </a>

                    <!-- Instagram -->
                    <a href="#" class="block hover:underline" aria-label="Instagram">
                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="40" height="30"
                            viewBox="0,0,256,256">
                            <g fill="#ffffff" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt"
                                stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0"
                                font-family="none" font-weight="none" font-size="none" text-anchor="none"
                                style="mix-blend-mode: normal">
                                <g transform="scale(5.12,5.12)">
                                    <path
                                        d="M16,3c-7.16752,0 -13,5.83248 -13,13v18c0,7.16752 5.83248,13 13,13h18c7.16752,0 13,-5.83248 13,-13v-18c0,-7.16752 -5.83248,-13 -13,-13zM16,5h18c6.08648,0 11,4.91352 11,11v18c0,6.08648 -4.91352,11 -11,11h-18c-6.08648,0 -11,-4.91352 -11,-11v-18c0,-6.08648 4.91352,-11 11,-11zM37,11c-1.10457,0 -2,0.89543 -2,2c0,1.10457 0.89543,2 2,2c1.10457,0 2,-0.89543 2,-2c0,-1.10457 -0.89543,-2 -2,-2zM25,14c-6.06329,0 -11,4.93671 -11,11c0,6.06329 4.93671,11 11,11c6.06329,0 11,-4.93671 11,-11c0,-6.06329 -4.93671,-11 -11,-11zM25,16c4.98241,0 9,4.01759 9,9c0,4.98241 -4.01759,9 -9,9c-4.98241,0 -9,-4.01759 -9,-9c0,-4.98241 4.01759,-9 9,-9z">
                                    </path>
                                </g>
                            </g>
                        </svg>
                </div>
            </div>
        </div>

        <!-- Derechos de autor -->
        <div class="text-center mt-4 text-sm text-gray-300">
            &copy; {{ date('Y') }} 3dWorld. Todos los derechos reservados.
        </div>
    </footer>
</body>

</html>