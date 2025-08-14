<x-app-layout>

<div class="max-w-6xl mx-auto bg-white shadow-md rounded-lg p-6">
    <h1 class="text-2xl font-bold mb-6">Procesos Judiciales</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-4 flex justify-end">
        <a href="{{ route('procesos.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            + Nuevo Proceso
        </a>
        <a href="{{ route('dashboard.abogado') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Cancelar</a>
    </div>
    
<!--Sidebar -->
    <table class="min-w-full border-collapse border border-gray-300">
        <thead class="bg-gray-100">
            <tr>
                <th class="border border-gray-300 px-4 py-2">#</th>
                <th class="border border-gray-300 px-4 py-2">Radicado</th>
                <th class="border border-gray-300 px-4 py-2">Tipo</th>
                <th class="border border-gray-300 px-4 py-2">Demandante</th>
                <th class="border border-gray-300 px-4 py-2">Demandado</th>
                <th class="border border-gray-300 px-4 py-2">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($procesos as $proceso)
                <tr>
                    <td class="border border-gray-300 px-4 py-2">{{ $proceso->id }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $proceso->numero_radicado }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $proceso->tipo_proceso }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $proceso->demandante }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $proceso->demandado }}</td>
                    <td class="border border-gray-300 px-4 py-2 flex gap-2">
                        <a href="{{ route('procesos.show', $proceso->id) }}" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                            Ver
                        </a>
                        <a href="{{ route('procesos.edit', $proceso->id) }}" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">
                            Editar
                        </a>
                        <form action="{{ route('procesos.destroy', $proceso->id) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este proceso?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center p-4 text-gray-500">No hay procesos registrados</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $procesos->links() }}
    </div>
</div>
</x-app-layout>