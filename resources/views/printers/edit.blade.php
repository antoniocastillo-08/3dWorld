@extends('app')
@section('title', 'Edit My Printer')
@section('content')
    <div
        class="container bg-gradient-to-b from-white to-gray-200 py-20 mx-auto my-8 px-4 text-xl border border-gray-400 rounded-lg shadow-lg">
        <div class="flex flex-col md:flex-row items-center md:justify-around mx-4 md:mx-20">
            <h1 class="text-2xl md:text-5xl font-bold mb-4 md:mb-0 text-center md:text-left">{{ $userPrinter->name }}</h1>
        
            <img src="{{ asset('storage/' . $userPrinter->printer->image) }}" alt="{{ $userPrinter->printer->name }}"
                class="w-64 h-64 md:w-80 md:h-80 rounded-lg border border-black">
        </div>

        <form action="{{ route('printers.update', $userPrinter->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Campos del formulario -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Printer Name</label>
                <input type="text" name="name" id="name" value="{{ $userPrinter->name }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div class="mb-4">
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" id="status"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="Available" {{ $userPrinter->status === 'Available' ? 'selected' : '' }}>Available</option>
                    <option value="On Use" {{ $userPrinter->status === 'On Use' ? 'selected' : '' }}>On Use</option>
                    <option value="Not Available" {{ $userPrinter->status === 'Not Available' ? 'selected' : '' }}>Not
                        Available</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="nozzle_size" class="block text-sm font-medium text-gray-700">Nozzle Size (mm)</label>
                <input type="number" name="nozzle_size" id="nozzle_size" value="{{ $userPrinter->nozzle_size }}" step="0.1"
                    min="0.1"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>


            <!-- Botón de enviar -->

            <div class="flex justify-end">
                <button type="submit" class="bg-indigo-600 text-white px-4 py-5 rounded hover:bg-indigo-700">
                    Update Printer
                </button>
            </div>

        </form>
        <div class="flex justify-between my-8">
            <button type="button" onclick="toggleFilaments()"
                class="bg-green-500 text-white px-10 py-6 rounded-xl hover:bg-green-700">
                Filaments
            </button>

            <form action="{{ route('printers.destroy', $userPrinter->id) }}" method="POST"
                onsubmit="return confirm('Are you sure you want to delete this printer?');">
                @csrf
                @method('DELETE')

                <button type="submit" class="bg-red-500 text-white px-6 py-4 rounded-xl hover:bg-red-700">
                    Delete
                </button>
            </form>

        </div>

        <h2 class="text-xl font-bold mb-4">Loaded Filaments</h2>
        <table class="table-auto border border-gray-300 w-full text-sm text-center">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border border-gray-300 px-4 py-2">Material</th>
                    <th class="border border-gray-300 px-4 py-2">Color</th>
                    <th class="border border-gray-300 px-4 py-2">Weight</th>
                    <th class="border border-gray-300 px-4 py-2">Diameter</th>
                    <th class="border border-gray-300 px-4 py-2">Brand</th>
                    <th class="border border-gray-300 px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($filamentsPrinters as $filamentPrinter)
                    @if ($filamentPrinter->filament) {{-- Verificar que la relación no sea null --}}
                        <tr class="hover:bg-gray-50">
                            <td class="border border-gray-300 px-4 py-2">{{ $filamentPrinter->filament->material }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $filamentPrinter->filament->color }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $filamentPrinter->filament->weight }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $filamentPrinter->filament->diameter }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $filamentPrinter->filament->brand }}</td>
                            <td class="border border-gray-300 px-4 py-2">
                                <form action="{{ route('printers.removeFilament', [$userPrinter->id, $filamentPrinter->filament->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-700">
                                        Remove
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>


    <div class="mt-8">
       
    </div>

    <div id="filamentsTable" class="hidden mt-8">
        <h2 class="text-xl font-bold mb-4">Available Filaments</h2>
        <table class="table-auto border border-gray-300 w-full text-sm text-center">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border border-gray-300 px-4 py-2">Material</th>
                    <th class="border border-gray-300 px-4 py-2">Color</th>
                    <th class="border border-gray-300 px-4 py-2">Weight</th>
                    <th class="border border-gray-300 px-4 py-2">Diameter</th>
                    <th class="border border-gray-300 px-4 py-2">Brand</th>
                    <th class="border border-gray-300 px-4 py-2">Available Amount</th> <!-- Nueva columna para la cantidad -->
                    <th class="border border-gray-300 px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($filaments as $filament)
                    <tr>
                        <td>{{ $filament->material }}</td>
                        <td>{{ $filament->color }}</td>
                        <td>{{ $filament->weight }}</td>
                        <td>{{ $filament->diameter }}</td>
                        <td>{{ $filament->brand }}</td>
                        <td>{{ $filament->amount }}</td> <!-- Mostrar la cantidad disponible -->
                        <td>
                            <form action="{{ route('printers.addFilament', [$userPrinter->id, $filament->id]) }}" method="POST">
                                @csrf

                                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">
                                    Add
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

    {{-- Script para mostrar/ocultar la tabla de filamentos --}}

    <script>
        function toggleFilaments() {
            const table = document.getElementById('filamentsTable');
            table.classList.toggle('hidden');
        }
        
    </script>
@endsection