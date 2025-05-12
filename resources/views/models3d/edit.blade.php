@extends('app')

@section('title', 'Editar modelo 3D - 3dWorld')

@section('content')
<div class="min-h-screen py-10 px-4 bg-gradient-to-br from-gray-100 to-gray-300">
    <div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Editar Modelo 3D</h1>

        <form action="{{ route('models3d.update', $model->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Nombre -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nombre del modelo</label>
                <input type="text" name="name" id="name" value="{{ old('name', $model->name) }}" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Descripción -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Descripción</label>
                <textarea name="description" id="description" rows="4" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('description', $model->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Imagen -->
            <div>
                <label for="image" class="block text-sm font-medium text-gray-700">Imagen del modelo (PNG, JPG, GIF)</label>
                <input type="file" name="image" id="image" accept=".png,.jpg,.jpeg,.gif"
                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                @if ($model->image)
                    <p class="mt-2 text-sm text-gray-600">Imagen actual: <a href="{{ asset('storage/' . $model->image) }}" target="_blank" class="text-indigo-600 hover:underline">Ver imagen</a></p>
                @endif
                @error('image')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Archivo STL -->
            <div>
                <label for="file" class="block text-sm font-medium text-gray-700">Archivo STL</label>
                <input type="file" name="file" id="file" accept=".stl"
                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                @if ($model->file)
                    <p class="mt-2 text-sm text-gray-600">Archivo actual: <a href="{{ asset('storage/' . $model->file) }}" target="_blank" class="text-indigo-600 hover:underline">Descargar archivo</a></p>
                @endif
                @error('file')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Botones -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('models3d.show', $model->id) }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition">Cancelar</a>
                <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded-lg transition">Guardar cambios</button>
            </div>
        </form>
    </div>
</div>
@endsection