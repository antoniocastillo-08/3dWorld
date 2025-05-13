@extends('app')
@section('title', 'Printers')
@section('content')
<div class="container mx-auto px-4 py-6 max-w-5xl">
    <h1 class="text-2xl font-bold mb-4">Lista de Impresoras</h1>

    @if ($printersByBrand->isEmpty())
        <p class="text-gray-600">Error: Sin Impresoras</p>
    @else
        @foreach ($printersByBrand as $brand => $printers)
            <div class="mb-6">
                <h2 class="text-5xl font-semibold text-gray-800 mb-2">{{ $brand }}</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach ($printers as $printer)
                        <form action="{{ route('printers.attach') }}" method="POST" class="bg-white shadow-md rounded-lg p-2 w-full max-w-xs mx-auto min-h-[250px] flex flex-col justify-between">
                            @csrf
                            <input type="hidden" name="printer_id" value="{{ $printer->id }}">
                            @if ($printer->image)
                                <button type="submit" class="focus:outline-none">
                                    <img src="{{ asset('storage/' . $printer->image) }}" alt="{{ $printer->name }}" class="w-full h-96 object-cover rounded-lg mb-2">
                                </button>
                            @endif
                            <h3 class="text-md font-semibold text-gray-800 text-center">{{ $printer->name }}</h3>
                        </form>
                    @endforeach
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection