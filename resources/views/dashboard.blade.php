<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Mensaje de éxito -->
            @if (session('success'))
                <div id="error-message" class="w-auto bg-green-500 text-white p-4 rounded mb-4">
                    {{ session('success') }}
                </div>

                <script>
                    setTimeout(() => {
                        const errorMessage = document.getElementById('error-message');
                        if (errorMessage) {
                            errorMessage.style.display = 'none';
                        }
                    }, 5000); // Ocultar después de 5 segundos
                </script>
            @endif


            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Welcome to your personal space!") }}
                </div>
            </div>

            <!-- Widget de impresoras -->
            <div class="bg-white border border-black border-separate overflow-hidden shadow-xl sm:rounded-lg mt-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Your Printers</h3>
                    @if ($printers->isEmpty())
                        <p class="text-gray-600">You don't have any printers associated</p>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach ($printers as $userPrinter)
                                <a href="/printers" class="bg-gray-100 border border-gray-300 shadow-md rounded-lg p-4">
                                    @if ($userPrinter->printer->image)
                                        <img src="{{ asset('storage/' . $userPrinter->printer->image) }}"
                                            alt="{{ $userPrinter->printer->name }}"
                                            class="w-full h-32 object-cover rounded-lg mb-2">
                                    @endif
                                    <h4 class="text-md font-semibold text-gray-800">{{ $userPrinter->printer->name }}</h4>
                                    <p class="text-sm text-gray-600">Apodo: {{ $userPrinter->name }}</p>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            {{-- Sección de modelos que el usuario ha dado "like" --}}
            <div class="mt-6">
                <h3 class="text-lg font-semibold mb-4">Models You Liked</h3>
                @if ($likedModels->isEmpty())
                    <p class="text-gray-600">You haven't liked any models yet.</p>
                @else
                    <ul class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @foreach ($likedModels as $model)
                            <li>
                                <a href="{{ route('models3d.show', $model) }}">
                                    <div
                                        class="bg-white rounded-lg shadow hover:shadow-xl transition duration-300 overflow-hidden">
                                        @if ($model->image)
                                            <img src="{{ asset('storage/' . $model->image) }}" alt="{{ $model->name }}"
                                                class="w-full h-48 object-cover">
                                        @else
                                            <div class="w-full h-48 flex items-center justify-center bg-gray-200 text-gray-500">
                                                No image available
                                            </div>
                                        @endif
                                        <div class="p-4">
                                            <h3 class="text-lg font-bold text-gray-800">{{ $model->name }}</h3>
                                            <p class="text-sm text-gray-600">{{ Str::limit($model->description, 100) }}</p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
            {{-- Sección de modelos creados por el usuario --}}
            <div class="mt-6">
                <h3 class="text-lg font-semibold mb-4">Your Created Models</h3>
                @if ($userModels->isEmpty())
                    <p class="text-gray-600">You haven't created any models yet.</p>
                @else
                    <ul class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @foreach ($userModels as $model)
                            <li>
                                <a href="{{ route('models3d.show', $model) }}">
                                    <div
                                        class="bg-white rounded-lg shadow hover:shadow-xl transition duration-300 overflow-hidden">
                                        @if ($model->image)
                                            <img src="{{ asset('storage/' . $model->image) }}" alt="{{ $model->name }}"
                                                class="w-full h-48 object-cover">
                                        @else
                                            <div class="w-full h-48 flex items-center justify-center bg-gray-200 text-gray-500">
                                                No image available
                                            </div>
                                        @endif
                                        <div class="p-4">
                                            <h3 class="text-lg font-bold text-gray-800">{{ $model->name }}</h3>
                                            <p class="text-sm text-gray-600">{{ Str::limit($model->description, 100) }}</p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>