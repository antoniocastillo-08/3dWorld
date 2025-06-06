@extends('app')
@section('title', 'Edit Filaments')
@section('content')
    {{-- Vista para editar filamentos del espacio de trabajo --}}
    <div class="flex justify-center mx-4 my-10">
        <div class="overflow-x-auto w-full max-w-screen-lg">
            <form method="POST" action="{{ route('filaments.update') }}">
                @csrf
                @method('PUT')
                {{-- Tabla de filamentos desde la que se puede editar --}}
                <table class="table-auto border border-gray-300 w-full text-sm text-center">
                    <thead class="bg-gray-400 hidden md:table-header-group">
                        <tr>
                            <th class="border border-gray-300 px-4 py-2 font-medium text-gray-700">Material</th>
                            <th class="border border-gray-300 px-4 py-2 font-medium text-gray-700">Color</th>
                            <th class="border border-gray-300 px-4 py-2 font-medium text-gray-700">Weight</th>
                            <th class="border border-gray-300 px-4 py-2 font-medium text-gray-700">Diameter</th>
                            <th class="border border-gray-300 px-4 py-2 font-medium text-gray-700">Brand</th>
                            <th class="border border-gray-300 px-4 py-2 font-medium text-gray-700">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($filaments as $filament)
                            <tr class="hover:bg-gray-50 md:table-row flex flex-col md:flex-row border border-gray-300 mb-4 md:mb-0">

                                {{--Editar Material--}}
                                <td class="border border-gray-300 px-4 py-2 text-gray-600 md:table-cell">
                                    <span class="font-medium md:hidden">Material:</span>
                                    <input type="text" name="filaments[{{ $filament->id }}][material]"
                                        value="{{ $filament->material }}"
                                        class="border border-gray-300 rounded px-2 py-1 w-full">
                                </td>

                                {{--Editar Color--}}
                                <td class="border border-gray-300 px-4 py-2 text-gray-600 md:table-cell">
                                    <span class="font-medium md:hidden">Color:</span>
                                    <input type="text" name="filaments[{{ $filament->id }}][color]"
                                        value="{{ $filament->color }}"
                                        class="border border-gray-300 rounded px-2 py-1 w-full">
                                </td>

                                {{--Editar Peso--}}
                                <td class="border border-gray-300 px-4 py-2 text-gray-600 md:table-cell">
                                    <span class="font-medium md:hidden">Weight:</span>
                                    <input type="number" name="filaments[{{ $filament->id }}][weight]"
                                        value="{{ $filament->weight }}"
                                        class="border border-gray-300 rounded px-2 py-1 w-full">
                                </td>
                                
                                {{--Editar Diámetro--}}
                                <td class="border border-gray-300 px-4 py-2 text-gray-600 md:table-cell">
                                    <span class="font-medium md:hidden">Diameter:</span>
                                    <input type="number" step="0.01" name="filaments[{{ $filament->id }}][diameter]"
                                        value="{{ $filament->diameter }}"
                                        class="border border-gray-300 rounded px-2 py-1 w-full">
                                </td>

                                {{--Editar Marca--}}
                                <td class="border border-gray-300 px-4 py-2 text-gray-600 md:table-cell">
                                    <span class="font-medium md:hidden">Brand:</span>
                                    <input type="text" name="filaments[{{ $filament->id }}][brand]"
                                        value="{{ $filament->brand }}"
                                        class="border border-gray-300 rounded px-2 py-1 w-full">
                                </td>

                                {{--Editar Cantidad--}}
                                <td class="border border-gray-300 px-4 py-2 text-gray-600 md:table-cell">
                                    <span class="font-medium md:hidden">Amount:</span>
                                    <input type="number" name="filaments[{{ $filament->id }}][amount]"
                                        value="{{ $filament->amount }}"
                                        class="border border-gray-300 rounded px-2 py-1 w-full">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4 text-right">
                    {{-- Botón para guardar los cambios --}}
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Responsividad para pantallas pequeñas -->
    <style>
        @media (max-width: 768px) {
            table {
                border: none;
            }

            thead {
                display: none;
            }

            tr {
                display: flex;
                flex-direction: column;
                margin-bottom: 1rem;
                border: 1px solid #ccc;
                border-radius: 0.5rem;
                padding: 1rem;
            }

            td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 0.5rem 0;
                border: none;
            }

            td span {
                font-weight: bold;
                margin-right: 1rem;
            }
        }
    </style>
@endsection