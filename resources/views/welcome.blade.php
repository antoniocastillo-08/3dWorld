@extends('app')

@section('content')
<div class="h-screen py-10 px-4 bg-gradient-to-b from-white to-slate-400 overflow-y-auto">
    <div class="max-w-6xl mx-auto mb-8">
        <h1 class="text-3xl font-mono font-bold text-gray-800">Bienvenido a 3DWorld</h1>
        <p class="mt-4 text-lg text-gray-600">Explora y comparte modelos 3D increíbles.</p>
    </div>

{{-- Buscador y filtros --}}
<div class="max-w-5xl mx-auto mb-7">
    <form method="GET" action="{{ route('models3d.index') }}" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4">
        {{-- Campo de búsqueda --}}
        <input 
            type="text" 
            name="search" 
            value="{{ request('search') }}" 
            placeholder="Buscar por nombre..." 
            class="flex-1 px-4 py-2 rounded-lg mr-9 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-pink-400"
        >

        {{-- Filtro por nombre A-Z / Z-A --}}
        <select name="name_order" class="px-8 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-pink-400">
            <option value="">Orden alfabético</option>
            <option value="asc" {{ request('name_order') == 'asc' ? 'selected' : '' }}>A - Z</option>
            <option value="desc" {{ request('name_order') == 'desc' ? 'selected' : '' }}>Z - A</option>
        </select>

        {{-- Filtro por fecha subida --}}
        <select name="date_order" class="px-8 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-pink-400">
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
            <a href="{{ route('models3d.show', $model->id) }}" class="bg-white rounded-lg shadow hover:shadow-xl transition duration-300 overflow-hidden group">
                @if ($model->image)
                    <img src="{{ asset('storage/' . $model->image) }}" alt="{{ $model->name }}" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                @else
                    <div class="w-full h-48 flex items-center justify-center bg-gray-200 text-gray-500">
                        No image available
                    </div>
                @endif

                <div class="p-4">
                    <h3 class="text-lg font-semibold text-gray-800">{{ $model->name }}</h3>
                    <p class="text-sm text-gray-600 mt-1">{{ Str::limit($model->description, 100) }}</p>
                </div>

                <div class="px-4 pb-4 flex justify-end">
                    <button class="text-purple-600 hover:text-purple-800 transition">
                        <svg height="20" width="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 4v16M4 12h16" />
                        </svg>
                    </button>
                </div>
            </a>
        @endforeach
    </div>
</div>
@endsection
