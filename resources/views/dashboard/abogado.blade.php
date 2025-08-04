{{-- resources/views/dashboard-abogado.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard del Abogado') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Bienvenida personalizada --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    Bienvenido, <strong>{{ Auth::user()->name }}</strong>. Este es tu panel de abogado.
                </div>
            </div>

            {{-- Acciones rápidas --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                {{-- Registrar nuevo proceso --}}
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-bold mb-2">Registrar Proceso</h3>
                    <p class="mb-4">Agrega un nuevo proceso jurídico al sistema.</p>
                    <a href="{{ route('legal_processes.create') }}" class="text-indigo-600 font-semibold">Registrar</a>
                </div>

                {{-- Ver procesos asignados --}}
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-bold mb-2">Mis Procesos</h3>
                    <p class="mb-4">Consulta y actualiza tus procesos asignados.</p>
                    <a href="{{ route('mis.procesos') }}" class="text-indigo-600 font-semibold">Ver procesos</a>
                </div>

                {{-- Emitir conceptos jurídicos --}}
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-bold mb-2">Conceptos Jurídicos</h3>
                    <p class="mb-4">Emite nuevos conceptos y clasifícalos por tema.</p>
                    <a href="{{ route('conceptos.create') }}" class="text-indigo-600 font-semibold">Emitir</a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
