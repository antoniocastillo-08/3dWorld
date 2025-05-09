@extends('app')
@section('title', 'Crear 3D Model')

@section('content')
<div class="container">
    <h1>Crear Nuevo Modelo 3D</h1>
    
    <form action="{{ route('models3d.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <!-- Name -->
        <div class="mb-3">
            <label for="name" class="form-label">Nombre del Modelo</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
            @error('name')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <!-- Description -->
        <div class="mb-3">
            <label for="description" class="form-label">Descripción</label>
            <textarea class="form-control" id="description" name="description" rows="3" required>{{ old('description') }}</textarea>
            @error('description')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <!-- File (STL file) -->
        <div class="mb-3">
            <label for="file" class="form-label">Archivo STL</label>
            <input type="file" class="form-control" id="file" name="file" accept=".stl" required>
            @error('file')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <!-- Image -->
        <div class="mb-3">
            <label for="image" class="form-label">Imagen del Modelo</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*">
            @error('image')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <!-- Preview -->
        <div class="mb-3">
            <img id="image-preview" src="#" alt="Previsualización" class="img-fluid d-none rounded border" style="max-height: 300px;">
        </div>

        <!-- Hidden author -->
        <input type="hidden" name="author" value="{{ auth()->id() }}">

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Crear Modelo</button>
    </form>
</div>

{{-- Script para la previsualización de imagen --}}
<script>
    document.getElementById('image').addEventListener('change', function (event) {
        const [file] = this.files;
        const preview = document.getElementById('image-preview');

        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.classList.remove('d-none');
        } else {
            preview.src = '#';
            preview.classList.add('d-none');
        }
    });
</script>
@endsection
