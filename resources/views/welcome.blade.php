@extends('app')

@section('content')
<div class="min-h-screen py-10 px-4 bg-gray-100">
    <div class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach ($models as $model)
            <a href="{{ route('models3d.show', $model->id) }}" class="bg-white rounded-lg shadow hover:shadow-xl transition duration-300 overflow-hidden group">
                @if ($model->image)
                    <img src="{{ asset('storage/' . $model->image) }}" alt="{{ $model->name }}" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                @else
                    <div class="w-full h-48 flex items-center justify-center bg-gray-200 text-gray-500">
                        No image available
                    </div>
                @endif

                <div class="p-4">
                    <h3 class="text-lg font-semibold text-gray-800">{{ $model->name }}</h3>
                    <p class="text-sm text-gray-600 mt-1">{{ Str::limit($model->description, 100) }}</p>
                </div>

                <div class="px-4 pb-4 flex justify-end">
                    <button class="text-purple-600 hover:text-purple-800 transition">
                        <svg height="20" width="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 4v16M4 12h16" />
                        </svg>
                    </button>
                </div>
            </a>
        @endforeach
    </div>
</div>
@endsection
