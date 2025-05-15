<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Welcome to 3dWorld !") }}
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
                                <div class="bg-gray-100 border border-gray-300 shadow-md rounded-lg p-4">
                                    @if ($userPrinter->printer->image)
                                        <img src="{{ asset('storage/' . $userPrinter->printer->image) }}" alt="{{ $userPrinter->printer->name }}"
                                            class="w-full h-32 object-cover rounded-lg mb-2">
                                    @endif
                                    <h4 class="text-md font-semibold text-gray-800">{{ $userPrinter->printer->name }}</h4>
                                    <p class="text-sm text-gray-600">Apodo: {{ $userPrinter->name }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>