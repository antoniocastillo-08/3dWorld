@extends('app')
@section('title', 'Filaments')
@section('content')
    <div class="max-w-3xl mx-auto py-10">
        <h1 class="text-2xl font-bold mb-6">Add New Filament</h1>

        <form action="{{ route('filaments.store') }}" method="POST" class="bg-white p-6 rounded-lg shadow-md">
            @csrf

            {{-- Material --}}
            <div class="mb-4">
                <label for="material" class="block text-sm font-medium text-gray-700">Material</label>
                <input list="materials" name="material" id="material" value="{{ old('material') }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                <datalist id="materials">
                    <option value="PLA">
                    <option value="ABS">
                    <option value="PETG">
                    <option value="TPU">
                    <option value="Nylon">
                    <option value="PC">
                </datalist>
                @error('material')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Brand --}}
            <div class="mb-4">
                <label for="brand" class="block text-sm font-medium text-gray-700">Brand</label>
                <input type="text" name="brand" id="brand" value="{{ old('brand') }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                @error('brand')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Color --}}
            <div class="mb-4">
                <label for="color" class="block text-sm font-medium text-gray-700">Color</label>
                <input type="text" name="color" id="color" value="{{ old('color') }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                @error('color')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Diameter --}}
            <div class="mb-4">
                <label for="diameter" class="block text-sm font-medium text-gray-700">Diameter (mm)</label>
                <input type="number" name="diameter" id="diameter" value="1.75"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                @error('diameter')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Weight --}}
            <div class="mb-4">
                <label for="weight" class="block text-sm font-medium text-gray-700">Weight (g)</label>
                <input type="number" name="weight" id="weight" value="{{ old('weight') }}" min="1"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                @error('weight')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Amount --}}
            <div class="mb-4">
                <label for="amount" class="block text-sm font-medium text-gray-700">Amount (m)</label>
                <input type="number" name="amount" id="amount" value="{{ old('amount') }}" min="1"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                @error('amount')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Submit Button --}}
            <div class="flex justify-end">
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                    Add Filament
                </button>
            </div>
        </form>
    </div>
@endsection