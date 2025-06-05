<x-app-layout>
    <div class="container mx-auto py-10">
        <h1 class="text-2xl font-bold mb-6">Choose Your Company Option</h1>

        @if (session('success'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" x-transition
                class="fixed top-6 right-6 bg-green-100 text-green-800 px-6 py-4 rounded-lg shadow-md z-50">
                {{ session('success') }}
            </div>
        @endif
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Crear una empresa -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-lg font-semibold mb-4">Create a Company</h2>
                <a href="{{ route('company.create') }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-700">
                    Create Company
                </a>
            </div>

            <!-- Unirse a una empresa -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-lg font-semibold mb-4">Join a Company</h2>
                <form action="{{ route('join.request') }}" method="POST">
                    @csrf
                    <label for="company_name" class="block text-sm font-medium text-gray-700 mb-1">Company Name</label>
                    <input type="text" name="company_name" id="company_name" required
                        class="w-full border border-gray-300 rounded px-3 py-2 mb-4 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Request to Join
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>