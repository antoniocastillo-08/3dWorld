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
                <form action="{{ route('join.request') }}" method="POST">
                    @csrf
                    <select name="company_id">
                        @foreach ($companies as $company)
                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded">Solicitar unirse</button>
                </form>
                
            </div>
        </div>
    </div>
</x-app-layout>