<x-app-layout>
<div class="max-w-7xl mx-auto bg-white shadow-lg rounded-xl p-6">
    
    <!-- Encabezado -->
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-2">
            Procesos Judiciales
        </h1>
    </div>

    <!-- Mensaje de éxito -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-300 text-green-800 p-4 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tabla -->
    <div class="overflow-x-auto border border-gray-200 rounded-lg shadow">
        <table class="min-w-full text-sm text-left">
            <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3">#</th>
                    <th class="px-4 py-3">Radicado</th>
                    <th class="px-4 py-3">Tipo</th>
                    <th class="px-4 py-3">Demandante</th>
                    <th class="px-4 py-3">Demandado</th>
                    <th class="px-4 py-3 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($procesos as $proceso)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 font-medium">{{ $proceso->id }}</td>
                        <td class="px-4 py-3">{{ $proceso->numero_radicado }}</td>
                        <td class="px-4 py-3">{{ $proceso->tipo_proceso }}</td>
                        <td class="px-4 py-3">{{ $proceso->demandante }}</td>
                        <td class="px-4 py-3">{{ $proceso->demandado }}</td>
                        <td class="px-4 py-3 flex justify-center gap-2">
                            <a href="{{ route('procesos.show', $proceso->id) }}" 
                               class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition">
                                Ver
                            </a>
                            <a href="{{ route('procesos.edit', $proceso->id) }}" 
                               class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 transition">
                                Editar
                            </a>
                            <form action="{{ route('procesos.destroy', $proceso->id) }}" method="POST" 
                                  onsubmit="return confirm('¿Seguro que deseas eliminar este proceso?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center p-6 text-gray-500">
                            No hay procesos registrados
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Paginación -->
    <div class="mt-6">
        {{ $procesos->links() }}
    </div>
</div>
</x-app-layout>
