@extends('app')
@section('title', 'Edit My Printer')
@section('content')
<div class="container bg-gradient-to-b from-white to-gray-200 py-20 mx-auto my-8 px-4 text-xl border border-gray-400 rounded-lg shadow-lg">
    <div class="flex justify-around mx-20">
    <h1 class="text-3xl font-bold mb-4">Edit My Printer</h1>
    
    <img src="{{ asset('storage/' . $userPrinter->printer->image) }}" alt="{{ $userPrinter->printer->name }}"
        class="w-64 h-64 rounded-lg border border-black mb-4">
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
                <option value="Not Available" {{ $userPrinter->status === 'Not Available' ? 'selected' : '' }}>Not Available</option>
            </select>
        </div>
    
        <div class="mb-4">
            <label for="nozzle_size" class="block text-sm font-medium text-gray-700">Nozzle Size (mm)</label>
            <input type="number" name="nozzle_size" id="nozzle_size" value="{{ $userPrinter->nozzle_size }}" step="0.1" min="0.1" 
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
        </div>
      
    
        <!-- Botón de enviar -->
        <div class="flex justify-end">
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                Update Printer
            </button>
            
        </div>
    </form>
 
    <div class="flex justify-end my-10">
        <button type="submit" class="bg-green-500 text-white px-10 py-6 rounded-xl hover:bg-green-700">
            Filaments
        </button>
    </div>
  
    <form action="{{ route('printers.destroy', $userPrinter->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this printer?');">
        @csrf
        @method('DELETE')
        <div class="flex justify-end">
        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-xl hover:bg-red-700">
            Delete
        </button>
        </div>
    </form>

 </div>
</div>
@endsection