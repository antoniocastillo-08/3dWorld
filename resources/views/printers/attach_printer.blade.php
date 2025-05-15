@extends('app')
@section('title', 'Personalizar Impresora')
@section('content')
<div class="container mx-auto px-4 py-6 max-w-3xl">
    <h1 class="text-2xl font-bold mb-4">Characteristics</h1>

    <form action="{{ route('printers.attach') }}" method="POST" class="bg-white shadow-md rounded-lg p-6">
        @csrf
        <input type="hidden" name="printer_id" value="{{ $printer->id }}">

        <!-- Nombre personalizado -->
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Printer's Nickname</label>
            <input type="text" name="name" id="name" required value="{{ $printer->name }}"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <!-- Estado -->
        <div class="mb-4">
            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
            <select name="status" id="status" required
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                <option value="Available">Available</option>
                <option value="On Use">On Use</option>
                <option value="Not Available">Not Available</option>
            </select>
        </div>

        <!-- Tamaño de la boquilla (solo si no es de tipo Resina) -->
        @if ($printer->type !== 'SLA')
            <div class="mb-4">
                <label for="nozzle_size" class="block text-sm font-medium text-gray-700">Nozzle Size (mm)</label>
                <input type="number" name="nozzle_size" id="nozzle_size" value="0.4" step="0.1" min="0.1" 
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>
        @endif

        <!-- Botón de enviar -->
        <div class="flex justify-end">
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                Submit
            </button>
        </div>
    </form>
</div>
@endsection 