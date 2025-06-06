<x-app-layout>

    <!-- Vista individual de una empresa -->
    <div class="container mx-auto px-4 py-10">
        <div class="mb-8">
            <!-- Mostrar mensaje de éxito si existe -->
            @if (session('success'))
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" x-transition
                    class="fixed top-6 right-6 bg-green-100 text-green-800 px-6 py-4 rounded-lg shadow-md z-50">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Detalles de la empresa -->
            <h1 class="text-3xl md:text-5xl font-bold mb-4">{{ $company->name }}</h1>
            <p class="text-sm md:text-base"><strong>Phone:</strong> {{ $company->phone }}</p>
            <p class="text-sm md:text-base"><strong>Email:</strong> {{ $company->email }}</p>
            <p class="text-sm md:text-base"><strong>Address:</strong> {{ $company->address }}</p>
            <p class="text-sm md:text-base">
                <strong>Website:</strong>
                <a href="{{ $company->website }}" target="_blank" class="text-blue-600 hover:underline">
                    {{ $company->website }}
                </a>
            </p>
        </div>

        <!--Botón para editar la empresa si el usuario es el boss-->
        @if (Auth::user()->hasRole('boss'))
            <a href="{{ route('company.edit', $company->id) }}"
                class="inline-block bg-blue-500 text-white px-4 py-2 mt-4 rounded hover:bg-blue-700">
                Edit
            </a>
        @endif

        <!-- Mostrar integrantes de la empresa -->
        <div class="mt-10">
            <h2 class="text-xl font-semibold mb-4">Employees</h2>

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white shadow rounded text-sm">
                    <thead>
                        <tr class="bg-gray-100 text-left font-semibold text-gray-700">
                            <th class="py-2 px-4">Name</th>
                            <th class="py-2 px-4">Email</th>
                            <th class="py-2 px-4">Workstation</th>
                            @if (Auth::user()->hasRole('boss'))
                                <th class="py-2 px-4">Actions</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($company->workstations as $workstation)
                            @foreach ($workstation->users as $user)
                                <tr class="border-t">
                                    <td class="py-2 px-4 {{ $user->hasRole('boss') ? 'bg-green-300 font-semibold' : '' }}">
                                        {{ $user->name }}
                                        @if ($user->hasRole('boss'))
                                            <span
                                                class="ml-2 inline-block bg-green-600 text-white text-xs font-bold px-2 py-1 rounded-full">Boss</span>
                                        @endif
                                    </td>
                                    <td class="py-2 px-4">{{ $user->email }}</td>
                                    <td class="py-2 px-4">{{ $workstation->name }}</td>

                                    <!-- Accion de despedir solo visible para el boss -->
                                    @if (Auth::user()->hasRole('boss') && Auth::id() !== $user->id)
                                        <td class="py-2 px-4">
                                            <form action="{{ route('company.fire', $user->id) }}" method="POST"
                                                onsubmit="return confirm('¿Estás seguro de que quieres despedir a este empleado?');">
                                                @csrf
                                                @method('PATCH')
                                                <button class="bg-red-500 hover:bg-red-700 text-white px-3 py-1 text-xs rounded">
                                                    Despedir
                                                </button>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Mostrar solicitudes de ingreso si el usuario es el boss -->
        @if (Auth::user()->hasRole('boss'))
            <div class="mt-10 bg-gray-100 p-4 rounded shadow">
                <h3 class="text-lg font-semibold mb-3">Solicitudes de ingreso</h3>
                @forelse ($company->joinRequests->where('status', 'pending') as $request)
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-3 gap-2">
                        <div>
                            <strong>{{ $request->user->name }}</strong> ({{ $request->user->email }})
                        </div>
                        <form method="POST" action="{{ route('join.respond', $request->id) }}" class="flex gap-2">
                            @csrf
                            @method('PATCH')
                            <button name="action" value="accept"
                                class="bg-green-500 text-white px-3 py-1 rounded text-sm">Aceptar</button>
                            <button name="action" value="reject"
                                class="bg-red-500 text-white px-3 py-1 rounded text-sm">Rechazar</button>
                        </form>
                    </div>
                @empty
                    <p class="text-sm">No hay solicitudes pendientes.</p>
                @endforelse

            </div>
        @endif

        <!-- Botón para eliminar la empresa -->
        @if (Auth::user()->hasRole('boss'))
        <form action="{{ route('company.destroy', $company->id) }}" method="POST"
            onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta empresa? Esta acción no se puede deshacer.');"
            class="inline-block ml-2">
            @csrf
            @method('DELETE')
            <button class="bg-red-600 text-white my-8 px-4 py-2 rounded hover:bg-red-800">
                Eliminar Empresa
            </button>
        </form>
        @endif
    </div>
</x-app-layout>