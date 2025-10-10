<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Lista de Abogados
        </h2>
    </x-slot>

    <div class="py-4 px-6">
        <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-sm">
            <thead>
                <tr>
                    <th class="px-4 py-2 border-b">Nombre</th>
                    <th class="px-4 py-2 border-b">Correo</th>
                    <th class="px-4 py-2 border-b">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lawyers as $lawyer)
                    <tr id="lawyer-{{ $lawyer->id }}">
                        <td class="px-4 py-2 border-b">{{ $lawyer->nombre }} {{ $lawyer->apellido }}</td>
                        <td class="px-4 py-2 border-b">{{ $lawyer->user->email ?? 'Sin usuario' }}</td>
                        <td class="px-4 py-2 border-b text-center">
                            <button 
                                onclick="deleteLawyer({{ $lawyer->id }})"
                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">
                                Eliminar
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        function deleteLawyer(id) {
            if (!confirm('¿Seguro que deseas eliminar este abogado?')) return;

            fetch(`/lawyers/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(res => {
                if (res.ok) {
                    document.getElementById(`lawyer-${id}`).remove();
                } else {
                    alert('No se pudo eliminar el abogado.');
                }
            })
            .catch(() => alert('Error al eliminar el abogado.'));
        }
    </script>
</x-app-layout>
