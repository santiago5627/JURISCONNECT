<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gray-900">Panel del Abogado</h2>
    </x-slot>

    <div class="py-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6 text-lg text-gray-700">
            Bienvenido, <strong>{{ Auth::user()->name }}</strong>. Este es tu panel de abogado.
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Registrar proceso -->
            <div class="bg-white shadow rounded-lg p-6 hover:shadow-md transition">
                <h3 class="text-lg font-semibold mb-2">Registrar Proceso</h3>
                <p class="text-gray-600 mb-4">Agrega un nuevo proceso jurídico al sistema.</p>
                <a href="{{ route('legal_processes.create') }}" class="text-indigo-600 hover:underline font-medium">Registrar</a>
            </div>

            <!-- Mis procesos -->
            <div class="bg-white shadow rounded-lg p-6 hover:shadow-md transition">
                <h3 class="text-lg font-semibold mb-2">Mis Procesos</h3>
                <p class="text-gray-600 mb-4">Consulta y actualiza tus procesos asignados.</p>
                <a href="{{ route('mis.procesos') }}" class="text-indigo-600 hover:underline font-medium">Ver procesos</a>
            </div>

            <!-- Conceptos Jurídicos -->
            <div class="bg-white shadow rounded-lg p-6 hover:shadow-md transition">
                <h3 class="text-lg font-semibold mb-2">Conceptos Jurídicos</h3>
                <p class="text-gray-600 mb-4">Emite nuevos conceptos y clasifícalos por tema.</p>
                <a href="{{ route('conceptos.create') }}" class="text-indigo-600 hover:underline font-medium">Emitir</a>
            </div>
        </div>
    </div>
</x-app-layout>
