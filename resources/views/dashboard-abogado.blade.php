<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold">Panel del Abogado</h2>
    </x-slot>

    <div class="py-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6 welcome-text">
            Bienvenido, <strong>{{ Auth::user()->name }}</strong>. Este es tu panel de abogado.
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="dashboard-card">
                <h3>Registrar Proceso</h3>
                <p>Agrega un nuevo proceso jurídico al sistema.</p>
                <a href="{{ route('legal_processes.create') }}">Registrar</a>
            </div>

            <div class="dashboard-card">
                <h3>Mis Procesos</h3>
                <p>Consulta y actualiza tus procesos asignados.</p>
                <a href="{{ route('mis.procesos') }}">Ver procesos</a>
            </div>

            <div class="dashboard-card">
                <h3>Conceptos Jurídicos</h3>
                <p>Emite nuevos conceptos y clasifícalos por tema.</p>
                <a href="{{ route('conceptos.create') }}">Emitir</a>
            </div>
        </div>
    </div>
</x-app-layout>
