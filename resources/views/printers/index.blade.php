@extends('app')
@section('title', 'Printers')
@section('content')
    <div class="flex justify-end mx-5 mt-2 mb-3">
        <a href="printers/add" class="inline-block bg-indigo-600 text-white px-7 py-2 rounded hover:bg-indigo-700">
            Add print
        </a>
    </div>

    <div
        class="container bg-gradient-to-b from-white to-gray-200 py-36 mx-auto my-8 px-4 border border-gray-400 rounded-lg shadow-lg">
        @if ($printers->isEmpty())
            <div class="flex flex-col items-center bg-gray-300 border border-dashed border-gray-800 py-9 rounded-lg shadow-lg">
                <p class="text-center text-gray-600 mb-4">You don't have printers added</p>
            </div>
        @else
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
                @foreach ($printers as $userPrinter)
                    <a href="{{ route('printers.edit', $userPrinter->id) }}" class=" bg-white border border-black shadow-md rounded-lg p-4 hover:shadow-2xl transition-shadow duration-300">
                        @if ($userPrinter->printer->image)
                            <img src="{{ asset('storage/' . $userPrinter->printer->image) }}" alt="{{ $userPrinter->printer->name }}"
                                class="w-full h-48 rounded-lg border border-black mb-4">
                        @endif
                        <p class="text-sm text-gray-900">Nick: {{ $userPrinter->name }}</p>
                        <h3 class="text-lg font-semibold text-gray-500">{{ $userPrinter->printer->name }}</h3>
                        <p class="text-3sm font-semibold 
                            @if ($userPrinter->status === 'Available') text-green-600 
                            @elseif ($userPrinter->status === 'On Use') text-yellow-600 
                            @elseif ($userPrinter->status === 'Not Available') text-red-600 
                            @endif">
                            Status: {{ $userPrinter->status }}
                        </p>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
@endsection