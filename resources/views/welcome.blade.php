@extends('app')

@section('content')
    <div class="h-screen py-10 px-4 bg-gradient-to-b from-white to-slate-400 overflow-y-auto">
        <div class="max-w-6xl mx-auto mb-8">
            <h1 class="text-3xl font-mono font-bold text-gray-800">Welcome to 3DWorld!!</h1>
            <p class="mt-4 text-lg text-gray-600">Manage your 3D printers</p>
        </div>

        @auth
            {{-- Carrusel de impresoras --}}
            <div class="max-w-6xl mx-auto mb-20">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Your Printers</h2>
                <div class="relative">
                    <a href="/printers">
                    <div id="printer-carousel" class="flex overflow-hidden gap-4">
                        @foreach ($printers as $printer)
                            <div
                                class="flex-none w-64 bg-white rounded-lg shadow hover:shadow-xl transition duration-300 overflow-hidden">
                                @if ($printer->printer->image)
                                    <img src="{{ asset('storage/' . $printer->printer->image) }}" alt="{{ $printer->printer->name }}"
                                        class="w-full h-40 object-cover">
                                @else
                                    <div class="w-full h-40 flex items-center justify-center bg-gray-200 text-gray-500">
                                        No image available
                                    </div>
                                @endif
                                <div class="p-4">
                                    <h3 class="text-lg font-semibold text-gray-800">{{ $printer->name }}</h3>
                                    <p class="text-sm text-gray-600 mt-1">Status: {{ $printer->status }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    </a>

                    {{-- Botones de navegación --}}
                    <button id="prev-button"
                        class="absolute left-0 top-1/2 transform -translate-y-1/2 bg-gray-800 text-white p-2 rounded-full shadow hover:bg-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <button id="next-button"
                        class="absolute right-0 top-1/2 transform -translate-y-1/2 bg-gray-800 text-white p-2 rounded-full shadow hover:bg-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </div>
        @endauth

        <div class="max-w-6xl mx-auto mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">3D Models</h2>
            <p class="mt-4 text-lg text-gray-600">Explore and share amazing and wonderful 3D models</p>
        </div>
        {{-- Buscador y filtros --}}
        <div class="max-w-5xl mx-auto mb-7">
            <form method="GET" action="{{ route('models3d.index') }}"
                class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4">
                {{-- Campo de búsqueda --}}
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por nombre..."
                    class="flex-1 px-4 py-2 rounded-lg mr-9 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-pink-400">

                {{-- Filtro por nombre A-Z / Z-A --}}
                <select name="name_order"
                    class="px-8 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-pink-400">
                    <option value="">Orden alfabético</option>
                    <option value="asc" {{ request('name_order') == 'asc' ? 'selected' : '' }}>A - Z</option>
                    <option value="desc" {{ request('name_order') == 'desc' ? 'selected' : '' }}>Z - A</option>
                </select>

                {{-- Filtro por fecha subida --}}
                <select name="date_order"
                    class="px-8 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-pink-400">
                    <option value="">Orden de subida</option>
                    <option value="newest" {{ request('date_order') == 'newest' ? 'selected' : '' }}>Más reciente</option>
                    <option value="oldest" {{ request('date_order') == 'oldest' ? 'selected' : '' }}>Más antiguo</option>
                </select>

                <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white px-4 py-2 rounded-lg transition">
                    Buscar
                </button>
            </form>
        </div>

        {{-- Galería de modelos --}}
        <div class="max-w-6xl mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($models as $model)
                <a href="{{ route('models3d.show', $model->id) }}"
                    class="bg-white rounded-lg shadow hover:shadow-xl transition duration-300 overflow-hidden group">
                    @if ($model->image)
                        <img src="{{ asset('storage/' . $model->image) }}" alt="{{ $model->name }}"
                            class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                    @else
                        <div class="w-full h-48 flex items-center justify-center bg-gray-200 text-gray-500">
                            No image available
                        </div>
                    @endif

                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-gray-800">{{ $model->name }}</h3>
                        <p class="text-sm text-gray-600 mt-1">{{ Str::limit($model->description, 100) }}</p>
                    </div>
                </a>
            @endforeach
        </div>
        
    </div>

    {{-- Script para el carrusel --}}
    <script>
        const carousel = document.getElementById('printer-carousel');
        const prevButton = document.getElementById('prev-button');
        const nextButton = document.getElementById('next-button');

        prevButton.addEventListener('click', () => {
            carousel.scrollBy({ left: -300, behavior: 'smooth' });
        });

        nextButton.addEventListener('click', () => {
            carousel.scrollBy({ left: 300, behavior: 'smooth' });
        });
    </script>
@endsection