@extends('app')
@section('title', 'Printers')
@section('content')
    <!--Indice de todas las Impresoras-->
    <div class="flex flex-wrap justify-between gap-4 mx-4 mt-4 mb-6">
        <a href="/filaments" class="bg-green-600 text-white px-5 py-3 rounded hover:bg-green-700 text-sm">
            Add Filaments
        </a>
        <a href="/printers/add" class="bg-indigo-600 text-white px-6 py-3 rounded hover:bg-indigo-700 text-sm">
            Add print
        </a>

        <!--Mensaje de Exito -->
        @if (session('success'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" x-transition
                class="fixed top-6 right-6 bg-green-100 text-green-800 px-6 py-4 rounded-lg shadow-md z-50">
                {{ session('success') }}
            </div>
        @endif

        <!--Mensaje de Error -->
        @if (session('error'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" x-transition
                class="fixed top-6 right-6 bg-red-100 text-red-800 px-6 py-4 rounded-lg shadow-md z-50">
                {{ session('error') }}
            </div>
        @endif

    </div>

    <!-- Lista de Impresoras -->
    <div
        class="container bg-gradient-to-b from-white to-gray-200 py-16 md:py-36 px-4 mx-auto my-8 border border-gray-400 rounded-lg shadow-lg">
        @if ($printers->isEmpty())
            <div class="flex flex-col items-center bg-gray-300 border border-dashed border-gray-800 py-9 rounded-lg shadow-lg">
                <p class="text-center text-gray-600 mb-4">You don't have printers added</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
                @foreach ($printers as $userPrinter)
                    <a href="{{ route('printers.edit', $userPrinter->id) }}"
                        class="bg-white border border-black shadow-md rounded-lg p-4 hover:shadow-2xl transition-shadow duration-300">
                        @if ($userPrinter->printer->image)
                            <img src="{{ asset('storage/' . $userPrinter->printer->image) }}" alt="{{ $userPrinter->printer->name }}"
                                class="w-full h-48 object-cover rounded-lg border border-black mb-4">
                        @endif
                        <p class="text-sm text-gray-900">Nick: {{ $userPrinter->name }}</p>
                        <h3 class="text-lg font-semibold text-gray-500">{{ $userPrinter->printer->name }}</h3>
                        <p class="text-sm font-semibold
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

    <!-- Tabla de filamentos -->
    <div class="flex flex-col items-center mx-4">
        <div class="overflow-x-auto w-full max-w-screen-lg">
            <table class="table-auto border border-gray-300 w-full text-sm text-center">
                <thead class="bg-gray-400">
                    <tr>
                        <th class="border border-gray-300 px-4 py-2">Material</th>
                        <th class="border border-gray-300 px-4 py-2">Color</th>
                        <th class="border border-gray-300 px-4 py-2">Weight</th>
                        <th class="border border-gray-300 px-4 py-2">Diameter</th>
                        <th class="border border-gray-300 px-4 py-2">Brand</th>
                        <th class="border border-gray-300 px-4 py-2">Amount</th>
                        <th class="border border-gray-300 px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($filaments as $filament)
                        <tr class="hover:bg-gray-50">
                            <td class="border px-4 py-2 text-gray-600">
                                <span class="view-mode">{{ $filament->material }}</span>
                                <input type="text" name="filaments[{{ $filament->id }}][material]"
                                    value="{{ $filament->material }}" class="edit-mode border rounded px-2 py-1 w-full hidden">
                            </td>
                            <td class="border px-4 py-2 text-gray-600">
                                <span class="view-mode">{{ $filament->color }}</span>
                                <input type="text" name="filaments[{{ $filament->id }}][color]" value="{{ $filament->color }}"
                                    class="edit-mode border rounded px-2 py-1 w-full hidden">
                            </td>
                            <td class="border px-4 py-2 text-gray-600">
                                <span class="view-mode">{{ $filament->weight }}</span>
                                <input type="number" name="filaments[{{ $filament->id }}][weight]"
                                    value="{{ $filament->weight }}" class="edit-mode border rounded px-2 py-1 w-full hidden">
                            </td>
                            <td class="border px-4 py-2 text-gray-600">
                                <span class="view-mode">{{ $filament->diameter }}</span>
                                <input type="number" step="0.01" name="filaments[{{ $filament->id }}][diameter]"
                                    value="{{ $filament->diameter }}" class="edit-mode border rounded px-2 py-1 w-full hidden">
                            </td>
                            <td class="border px-4 py-2 text-gray-600">
                                <span class="view-mode">{{ $filament->brand }}</span>
                                <input type="text" name="filaments[{{ $filament->id }}][brand]" value="{{ $filament->brand }}"
                                    class="edit-mode border rounded px-2 py-1 w-full hidden">
                            </td>
                            <td class="border px-4 py-2 text-gray-600">
                                <span class="view-mode">{{ $filament->amount }}</span>
                                <input type="number" name="filaments[{{ $filament->id }}][amount]"
                                    value="{{ $filament->amount }}" class="edit-mode border rounded px-2 py-1 w-full hidden">
                            </td>
                            <td class="border px-4 py-2">
                                <form method="POST" action="{{ route('filaments.destroy', $filament->id) }}"
                                    onsubmit="return confirm('Are you sure you want to remove this filament?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="bg-red-500 hover:bg-red-700 text-white px-4 py-2 rounded text-xs">
                                        Remove
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-2 text-center text-gray-500">
                                No filaments available
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Botón para editar los filamentos -->
        <div class="w-full max-w-screen-lg my-5 text-right px-2">
            @if ($filaments->isNotEmpty())
                <a href="{{ route('filaments.edit') }}"
                    class="bg-blue-500 text-white px-6 py-3 rounded hover:bg-blue-700 text-sm">
                    Edit
                </a>
            @endif
        </div>
    </div>

    <!-- Botón para hacer a tabla editable-->
    <script>
        document.getElementById('edit-button')?.addEventListener('click', function () {
            document.querySelectorAll('.view-mode').forEach(el => el.classList.add('hidden'));
            document.querySelectorAll('.edit-mode').forEach(el => el.classList.remove('hidden'));

            document.getElementById('edit-button')?.classList.add('hidden');
            document.getElementById('save-button')?.classList.remove('hidden');
        });
    </script>
@endsection