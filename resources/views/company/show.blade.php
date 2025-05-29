<x-app-layout>
    <div class="container mx-auto py-10">
        <div class="mb-8">
        <h1 class="text-5xl font-bold mb-6">{{ $company->name }}</h1>
        <p><strong>Phone:</strong> {{ $company->phone }}</p>
        <p><strong>Email:</strong> {{ $company->email }}</p>
        <p><strong>Address:</strong> {{ $company->address }}</p>
        <p><strong>Website:</strong> <a href="{{ $company->website }}" target="_blank">{{ $company->website }}</a></p>
        </div>
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
                            <td class="py-2 px-4 {{ $user->hasRole('boss') ? 'bg-green-300 font-semibold' : '' }}">
                                {{ $user->name }}
                                @if ($user->hasRole('boss'))
                                    <span class="ml-2 inline-block bg-green-600 text-white text-xs font-bold px-2 py-1 rounded-full">Boss</span>
                                @endif
                            </td>
                            <td class="py-2 px-4">{{ $user->email }}</td>
                            <td class="py-2 px-4">{{ $workstation->name }}</td>
                        
                            @if (Auth::user()->hasRole('boss') && Auth::id() !== $user->id)
                                <td class="py-2 px-4">
                                    <form action="{{ route('company.fire', $user->id) }}" method="POST"
                                        onsubmit="return confirm('¿Estás seguro de que quieres despedir a este empleado?');">
                                      @csrf
                                      @method('PATCH')
                                      <button class="bg-red-500 hover:bg-red-700 text-white px-3 py-1 text-sm rounded">
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
        @if (Auth::user()->hasRole('boss'))
    <div class="mt-10 bg-gray-100 p-4 rounded shadow">
        <h3 class="text-lg font-semibold mb-3">Solicitudes de ingreso</h3>
        @forelse ($company->joinRequests->where('status', 'pending') as $request)
            <div class="flex items-center justify-between mb-2">
                <div>
                    <strong>{{ $request->user->name }}</strong> ({{ $request->user->email }})
                </div>
                <form method="POST" action="{{ route('join.respond', $request->id) }}">
                    @csrf
                    @method('PATCH')
                    <button name="action" value="accept" class="bg-green-500 text-white px-3 py-1 rounded mr-2">Aceptar</button>
                    <button name="action" value="reject" class="bg-red-500 text-white px-3 py-1 rounded">Rechazar</button>
                </form>
            </div>
        @empty
            <p>No hay solicitudes pendientes.</p>
        @endforelse
    </div>
@endif


    </div>



</x-app-layout>