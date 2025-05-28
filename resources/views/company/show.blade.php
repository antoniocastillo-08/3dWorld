<x-app-layout>
    <div class="container mx-auto py-10">
        <h1 class="text-2xl font-bold mb-6">{{ $company->name }}</h1>

        <p><strong>Phone:</strong> {{ $company->phone }}</p>
        <p><strong>Email:</strong> {{ $company->email }}</p>
        <p><strong>Address:</strong> {{ $company->address }}</p>
        <p><strong>Website:</strong> <a href="{{ $company->website }}" target="_blank">{{ $company->website }}</a></p>

        @if (Auth::user()->hasRole('boss'))
            <a href="{{ route('company.edit', $company->id) }}"
                class="bg-blue-500 text-white px-4 py-2 mt-10 rounded hover:bg-blue-700">
                Edit
            </a>
        @endif

        <div class="mt-10">
            <h2 class="text-xl font-semibold mb-4">Employees</h2>

            <table class="min-w-full bg-white shadow rounded">
                <thead>
                    <tr class="bg-gray-100 text-left text-sm font-semibold text-gray-700">
                        <th class="py-2 px-4">Name</th>
                        <th class="py-2 px-4">Email</th>
                        <th class="py-2 px-4">Workstation</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($company->workstations as $workstation)
                        @foreach ($workstation->users as $user)
                            <tr class="border-t">
                                <td class="py-2 px-4">{{ $user->name }}</td>
                                <td class="py-2 px-4">{{ $user->email }}</td>
                                <td class="py-2 px-4">{{ $workstation->name }}</td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>



</x-app-layout>