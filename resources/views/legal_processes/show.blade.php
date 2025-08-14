<x-app-layout>

<div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-6">
    <h1 class="text-2xl font-bold mb-6">Detalle del Proceso #{{ $proceso->id }}</h1>

    <div class="mb-4">
        <strong class="block font-semibold">Tipo de Proceso:</strong>
        <p>{{ $proceso->tipo_proceso }}</p>
    </div>

    <div class="mb-4">
        <strong class="block font-semibold">Número de Radicado:</strong>
        <p>{{ $proceso->numero_radicado }}</p>
    </div>

    <div class="mb-4">
        <strong class="block font-semibold">Demandante:</strong>
        <p>{{ $proceso->demandante }}</p>
    </div>

    <div class="mb-4">
        <strong class="block font-semibold">Demandado:</strong>
        <p>{{ $proceso->demandado }}</p>
    </div>

    <div class="mb-4">
        <strong class="block font-semibold">Descripción:</strong>
        <p>{{ $proceso->descripcion }}</p>
    </div>

    <div class="mb-4">
        <strong class="block font-semibold">Documento:</strong>
        @if($proceso->documento)
            <a href="{{ asset('storage/'.$proceso->documento) }}" target="_blank" class="text-blue-600 underline">
                Ver documento adjunto
            </a>
        @else
            <p class="text-gray-500">No hay documento adjunto</p>
        @endif
    </div>

    <div class="flex justify-end gap-4">
        <a href="{{ route('procesos.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Volver</a>
        <a href="{{ route('procesos.edit', $proceso->id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Editar</a>
    </div>
</div>

</x-app-layout>
