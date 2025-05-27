@extends('app')
@section('title', 'Printers')
@section('content')
    <div class="flex justify-between mx-6 mt-2 mb-3">
        <a href="/filaments" class="inline-block bg-green-600 text-white p-4 rounded hover:bg-indigo-700">
            Add Filaments
        </a>
        <a href="printers/add" class="inline-block bg-indigo-600 text-white px-7 py-4 rounded hover:bg-indigo-700">
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
                    <a href="{{ route('printers.edit', $userPrinter->id) }}"
                        class=" bg-white border border-black shadow-md rounded-lg p-4 hover:shadow-2xl transition-shadow duration-300">
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

    <div class="flex justify-center m-4">
        <div class="overflow-x-auto w-full  max-w-screen-lg">

            <table class="table-auto border border-gray-300 w-full text-sm text-center">
                <thead class="bg-gray-400">
                    <tr>
                        <th class="border border-gray-300 px-4 py-2 font-medium text-gray-700">Material</th>
                        <th class="border border-gray-300 px-4 py-2 font-medium text-gray-700">Color</th>
                        <th class="border border-gray-300 px-4 py-2 font-medium text-gray-700">Weight</th>
                        <th class="border border-gray-300 px-4 py-2 font-medium text-gray-700">Diameter</th>
                        <th class="border border-gray-300 px-4 py-2 font-medium text-gray-700">Brand</th>
                        <th class="border border-gray-300 px-4 py-2 font-medium text-gray-700">Amount</th>
                        <th class="border border-gray-300 px-4 py-2 font-medium text-gray-700">Actions</th>
                        <!-- Nueva columna -->
                    </tr>
                </thead>
                <tbody>
                    @forelse ($filaments as $filament)
                        <tr class="hover:bg-gray-50">
                            <td class="border border-gray-300 px-4 py-2 text-gray-600">
                                <span class="view-mode">{{ $filament->material }}</span>
                                <input type="text" name="filaments[{{ $filament->id }}][material]"
                                    value="{{ $filament->material }}"
                                    class="edit-mode border border-gray-300 rounded px-2 py-1 w-full hidden">
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-gray-600">
                                <span class="view-mode">{{ $filament->color }}</span>
                                <input type="text" name="filaments[{{ $filament->id }}][color]" value="{{ $filament->color }}"
                                    class="edit-mode border border-gray-300 rounded px-2 py-1 w-full hidden">
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-gray-600">
                                <span class="view-mode">{{ $filament->weight }}</span>
                                <input type="number" name="filaments[{{ $filament->id }}][weight]"
                                    value="{{ $filament->weight }}"
                                    class="edit-mode border border-gray-300 rounded px-2 py-1 w-full hidden">
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-gray-600">
                                <span class="view-mode">{{ $filament->diameter }}</span>
                                <input type="number" step="0.01" name="filaments[{{ $filament->id }}][diameter]"
                                    value="{{ $filament->diameter }}"
                                    class="edit-mode border border-gray-300 rounded px-2 py-1 w-full hidden">
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-gray-600">
                                <span class="view-mode">{{ $filament->brand }}</span>
                                <input type="text" name="filaments[{{ $filament->id }}][brand]" value="{{ $filament->brand }}"
                                    class="edit-mode border border-gray-300 rounded px-2 py-1 w-full hidden">
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-gray-600">
                                <span class="view-mode">{{ $filament->amount }}</span>
                                <input type="number" name="filaments[{{ $filament->id }}][amount]"
                                    value="{{ $filament->amount }}"
                                    class="edit-mode border border-gray-300 rounded px-2 py-1 w-full hidden">
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-gray-600">
                                <!-- Botón Remove -->
                                <form method="POST" action="{{ route('filaments.destroy', $filament->id) }}"
                                    onsubmit="return confirm('Are you sure you want to remove this filament?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-700">
                                        Remove
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="border border-gray-300 px-4 py-2 text-center text-gray-500">
                                No filaments available
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            
        </div>
        <div class="ml-20 text-right">
            <a href="{{ route('filaments.edit') }}" class="bg-blue-500 text-white px-6 py-3 rounded hover:bg-blue-700">
                Edit
            </a>
        </div>
    </div>

    <script>
        document.getElementById('edit-button').addEventListener('click', function () {
            // Mostrar los inputs y ocultar los spans
            document.querySelectorAll('.view-mode').forEach(el => el.classList.add('hidden'));
            document.querySelectorAll('.edit-mode').forEach(el => el.classList.remove('hidden'));

            // Mostrar el botón de guardar y ocultar el botón de editar
            document.getElementById('edit-button').classList.add('hidden');
            document.getElementById('save-button').classList.remove('hidden');
        });
    </script>
@endsection