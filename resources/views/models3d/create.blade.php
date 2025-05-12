@extends('app')
@section('title', 'Crear 3D Model')

@section('content')
<div class="max-w-2xl mx-auto p-6 bg-white dark:bg-gray-800 shadow-lg rounded-xl mt-6">
    <h1 class="text-2xl font-bold mb-6 text-gray-900 dark:text-white">Crear Nuevo Modelo 3D</h1>

    <form action="{{ route('models3d.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Name -->
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Nombre del Modelo</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <!-- Description -->
        <div class="mb-4">
            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Descripción</label>
            <textarea id="description" name="description" rows="3" required
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ old('description') }}</textarea>
            @error('description')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <!-- File (STL) -->
        <div class="mb-4">
            <label for="file" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Archivo STL</label>
            <input type="file" id="file" name="file" accept=".stl" required
                class="mt-1 block w-full text-sm text-gray-700 dark:text-white dark:bg-gray-700 dark:border-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
            @error('file')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <!-- Image -->
        <div class="mb-4">
            <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Imagen del Modelo</label>
            <input type="file" id="image" name="image" accept="image/*"
                class="mt-1 block w-full text-sm text-gray-700 dark:text-white dark:bg-gray-700 dark:border-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
            @error('image')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <!-- Preview -->
        <div class="mb-6">
            <img id="image-preview" src="#" alt="Previsualización"
                class="hidden w-full max-h-72 rounded-md border border-gray-300 dark:border-gray-600 object-cover">
        </div>

        <!-- Hidden author -->
        <input type="hidden" name="author" value="{{ auth()->id() }}">

        <!-- Submit Button -->
        <div class="flex justify-end">
            <button type="submit"
                class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-md shadow-md transition">
                Crear Modelo
            </button>
        </div>
    </form>
</div>

{{-- Script para la previsualización de imagen --}}
<script>
    document.getElementById('image').addEventListener('change', function (event) {
        const [file] = this.files;
        const preview = document.getElementById('image-preview');

        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.classList.remove('hidden');
        } else {
            preview.src = '#';
            preview.classList.add('hidden');
        }
    });
</script>
@endsection
