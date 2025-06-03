@extends('app')
@section('title', 'Edit My Printer')
@section('content')
    <div
        class="container bg-gradient-to-b from-white to-gray-200 py-20 mx-auto my-8 px-4 text-xl border border-gray-400 rounded-lg shadow-lg">
        <div class="flex justify-end items-center mb-8">
            <h1 class=" text-3xl font-bold
                            @if ($userPrinter->status === 'Available') text-green-600 
                            @elseif ($userPrinter->status === 'On Use') text-yellow-600 
                            @elseif ($userPrinter->status === 'Not Available') text-red-600 
                            @endif">
                {{ $userPrinter->status }}
            </h1>
        </div>
        <div class="flex flex-col md:flex-row items-center md:justify-around mx-4 md:mx-20">
            <h1 class="text-2xl md:text-5xl font-bold mb-4 md:mb-0 text-center md:text-left">{{ $userPrinter->name }}</h1>

            <img src="{{ asset('storage/' . $userPrinter->printer->image) }}" alt="{{ $userPrinter->printer->name }}"
                class="w-64 h-64 md:w-80 md:h-80 rounded-lg border border-black">
        </div>

        <form class="mx-40" action="{{ route('printers.update', $userPrinter->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Campos del formulario -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Printer Name</label>
                <input type="text" name="name" id="name" value="{{ $userPrinter->name }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2 text-center md:text-left">Status</label>
                <input type="hidden" name="status" id="status" value="{{ $userPrinter->status }}">

                <div class="flex flex-wrap justify-center gap-4">
                    <button type="button" class="status-btn px-4 py-2 rounded font-semibold 
                    {{ $userPrinter->status === 'Available' ? 'bg-green-600 text-white' : 'bg-gray-200' }}"
                        data-status="Available">
                        Available
                    </button>
                    <button type="button" class="status-btn px-4 py-2 rounded font-semibold 
                    {{ $userPrinter->status === 'On Use' ? 'bg-yellow-500 text-white' : 'bg-gray-200' }}"
                        data-status="On Use">
                        On Use
                    </button>
                    <button type="button" class="status-btn px-4 py-2 rounded font-semibold 
                    {{ $userPrinter->status === 'Not Available' ? 'bg-red-600 text-white' : 'bg-gray-200' }}"
                        data-status="Not Available">
                        Not Available
                    </button>
                </div>
            </div>


            @if ($userPrinter->printer->type !== 'SLA')
                <div class="mb-4">
                    <label for="nozzle_size" class="block text-sm font-medium text-gray-700">Nozzle Size (mm)</label>
                    <input type="number" name="nozzle_size" id="nozzle_size" value="{{ $userPrinter->nozzle_size }}" step="0.1"
                        min="0.1"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
            @endif


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
                @forelse ($filamentsPrinters as $filamentPrinter)
                    @if ($filamentPrinter->filament) {{-- Verificar que la relación no sea null --}}
                        <tr class="hover:bg-gray-50">
                            <td class="border border-gray-300 px-4 py-2">{{ $filamentPrinter->filament->material }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $filamentPrinter->filament->color }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $filamentPrinter->filament->weight }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $filamentPrinter->filament->diameter }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $filamentPrinter->filament->brand }}</td>
                            <td class="border border-gray-300 px-4 py-2">
                                <form
                                    action="{{ route('printers.removeFilament', [$userPrinter->id, $filamentPrinter->filament->id]) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-700">
                                        Remove
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endif
                @empty
                    <tr>
                        <td colspan="6" class="border border-gray-300 px-4 py-2 text-center text-gray-500">
                            No loaded filaments ...
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>


    <div class="mt-8">

    </div>

    <div id="filamentsTable" class="hidden mt-8">
        <h2 class="text-xl font-bold mb-4">Available Filaments</h2>

        <div class="overflow-x-auto w-full">
            <table class="min-w-[700px] border border-gray-300 w-full text-sm text-center">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border border-gray-300 px-4 py-2">Material</th>
                        <th class="border border-gray-300 px-4 py-2">Color</th>
                        <th class="border border-gray-300 px-4 py-2">Weight</th>
                        <th class="border border-gray-300 px-4 py-2">Diameter</th>
                        <th class="border border-gray-300 px-4 py-2">Brand</th>
                        <th class="border border-gray-300 px-4 py-2">Available Amount</th>
                        <th class="border border-gray-300 px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($filaments as $filament)
                        <tr class="hover:bg-gray-50">
                            <td class="border border-gray-300 px-4 py-2">{{ $filament->material }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $filament->color }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $filament->weight }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $filament->diameter }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $filament->brand }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $filament->amount }}</td>
                            <td class="border border-gray-300 px-4 py-2">
                                <form action="{{ route('printers.addFilament', [$userPrinter->id, $filament->id]) }}"
                                    method="POST">
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

        document.querySelectorAll('.status-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                // Cambiar el valor del input oculto
                document.getElementById('status').value = btn.dataset.status;

                // Quitar estilos activos de todos
                document.querySelectorAll('.status-btn').forEach(b => {
                    b.classList.remove('bg-green-600', 'bg-yellow-500', 'bg-red-600', 'text-white');
                    b.classList.add('bg-gray-200');
                });

                // Activar el botón seleccionado
                btn.classList.remove('bg-gray-200');
                if (btn.dataset.status === 'Available') {
                    btn.classList.add('bg-green-600', 'text-white');
                } else if (btn.dataset.status === 'On Use') {
                    btn.classList.add('bg-yellow-500', 'text-white');
                } else if (btn.dataset.status === 'Not Available') {
                    btn.classList.add('bg-red-600', 'text-white');
                }
            });
        });

    </script>
@endsection