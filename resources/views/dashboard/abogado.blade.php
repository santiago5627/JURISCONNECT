{{-- resources/views/dashboard-abogado.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-900 leading-tight">
            {{ __('Dashboard del Abogado ⚖️') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Bienvenida personalizada --}}
            <div class="bg-gradient-to-r from-green-600 to-green-800 text-white rounded-2xl shadow-lg p-6 mb-8">
                <h1 class="text-2xl font-bold">Bienvenido, {{ Auth::user()->name }}</h1>
                <p class="mt-1 text-green-100">Este es tu panel de abogado. Administra tus procesos y conceptos fácilmente.</p>
            </div>

            {{-- Acciones rápidas --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

                {{-- Registrar nuevo proceso --}}
                <div class="bg-white rounded-2xl shadow-md hover:shadow-lg transition p-6 text-center">
                    <div class="flex justify-center mb-4">
                        <div class="p-3 rounded-full bg-green-100 text-green-700">
                            📑
                        </div>
                    </div>
                    <h3 class="text-lg font-semibold mb-2">Registrar Proceso</h3>
                    <p class="text-gray-600 mb-4">Agrega un nuevo proceso jurídico al sistema.</p>
                    <a href="{{ route('legal_processes.create') }}" 
                        class="inline-block px-4 py-2 bg-green-700 text-white rounded-lg hover:bg-green-800 transition">
                        Registrar
                    </a>
                </div>

                {{-- Ver procesos asignados --}}
                <div class="bg-white rounded-2xl shadow-md hover:shadow-lg transition p-6 text-center">
                    <div class="flex justify-center mb-4">
                        <div class="p-3 rounded-full bg-blue-100 text-blue-700">
                            📂
                        </div>
                    </div>
                    <h3 class="text-lg font-semibold mb-2">Mis Procesos</h3>
                    <p class="text-gray-600 mb-4">Consulta y actualiza tus procesos asignados.</p>
                    <a href="{{ route('mis.procesos') }}" 
                        class="inline-block px-4 py-2 bg-blue-700 text-white rounded-lg hover:bg-blue-800 transition">
                        Ver procesos
                    </a>
                </div>

                {{-- Emitir conceptos jurídicos --}}
                <div class="bg-white rounded-2xl shadow-md hover:shadow-lg transition p-6 text-center">
                    <div class="flex justify-center mb-4">
                        <div class="p-3 rounded-full bg-purple-100 text-purple-700">
                            🖋️
                        </div>
                    </div>
                    <h3 class="text-lg font-semibold mb-2">Conceptos Jurídicos</h3>
                    <p class="text-gray-600 mb-4">Emite nuevos conceptos y clasifícalos por tema.</p>
                    <a href="{{ route('conceptos.create') }}" 
                        class="inline-block px-4 py-2 bg-purple-700 text-white rounded-lg hover:bg-purple-800 transition">
                        Emitir
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
