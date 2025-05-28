<x-app-layout>
    <div class="container mx-auto py-10">
        <h1 class="text-2xl font-bold mb-6">Choose Your Company Option</h1>

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
                <form action="{{ route('company.join') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="company_id" class="block text-sm font-medium text-gray-700">Select Company</label>
                        <select name="company_id" id="company_id" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            @foreach ($companies as $company)
                                <option value="{{ $company->id }}">{{ $company->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Join Company
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>