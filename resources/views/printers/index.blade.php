        @extends('app')
        @section('title', 'Printers')
        @section('content')
        <a href="printers/add" class="inline-block bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
            Añadir impresora
        </a>
        <div class="container bg-gray-900 mx-auto my-12 px-4 border-gray-800 rounded-lg shadow-lg">
            @if ($printers->isEmpty())
                <div class="flex flex-col items-center bg-gray-300 border border-dashed border-gray-800 rounded-lg shadow-lg py-6">
                    <p class="text-center text-gray-600 mb-4">No tienes impresoras añadidas</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($printers as $userPrinter)
                        <div class="bg-gradient-to-t from-white to-teal-400 shadow-md rounded-lg p-4">
                            @if ($userPrinter->printer->image)
                                <img src="{{ asset('storage/' . $userPrinter->printer->image) }}" alt="{{ $userPrinter->printer->name }}" class="w-full h-48 object-cover rounded-lg mb-4">
                            @endif
                            <h3 class="text-lg font-semibold text-gray-800">{{ $userPrinter->printer->name }}</h3>
                            <p class="text-sm text-gray-600">Apodo: {{ $userPrinter->name }}</p>
                            <p class="text-sm text-gray-600">Estado: {{ $userPrinter->status }}</p>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
        @endsection