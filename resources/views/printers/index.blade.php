@extends('app')
@section('title', 'Printers')
@section('content')
    <div class="flex justify-end mx-5 mt-2 mb-3">
        <a href="printers/add" class="inline-block bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
            Añadir impresora
        </a>
    </div>

    <div
        class="container bg-gradient-to-b from-white to-gray-700 py-36 mx-auto my-8 px-4 border border-gray-400 rounded-lg shadow-lg">
        @if ($printers->isEmpty())
            <div class="flex flex-col items-center bg-gray-300 border border-dashed border-gray-800 py-9 rounded-lg shadow-lg">
                <p class="text-center text-gray-600 mb-4">No tienes impresoras añadidas</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-6">
                @foreach ($printers as $userPrinter)
                    <div class=" bg-white border border-black shadow-md rounded-lg p-4">
                        @if ($userPrinter->printer->image)
                            <img src="{{ asset('storage/' . $userPrinter->printer->image) }}" alt="{{ $userPrinter->printer->name }}"
                                class="w-full h-48 rounded-lg border border-black mb-4">
                        @endif
                        <p class="text-sm text-gray-600">Apodo: {{ $userPrinter->name }}</p>
                        <h3 class="text-lg font-semibold text-gray-800">{{ $userPrinter->printer->name }}</h3>
                        <p class="text-3sm font-semibold 
                            @if ($userPrinter->status === 'Available') text-green-600 
                            @elseif ($userPrinter->status === 'On Use') text-yellow-600 
                            @elseif ($userPrinter->status === 'Not Available') text-red-600 
                            @endif">
                            Estado: {{ $userPrinter->status }}
                        </p>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection