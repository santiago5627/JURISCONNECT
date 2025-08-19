<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Proceso Judicial') }}
        </h2>
    </x-slot>

<div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-6">
    <h1 class="text-2xl font-bold mb-6">Crear nuevo proceso judicial</h1>

    {{-- Mensajes de error --}}
    @if ($errors->any())
        <div class="bg-red-100 text-red-800 p-4 rounded mb-4">
            <ul class="list-disc ml-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('procesos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Tipo de Proceso --}}
        <div class="mb-4">
            <label for="tipo_proceso" class="block font-semibold">Tipo de proceso:</label>
            <select name="tipo_proceso" id="tipo_proceso" class="w-full border rounded p-2">
                <option value="">-- Seleccione --</option>
                <option value="Civil">Civil</option>
                <option value="Penal">Penal</option>
                <option value="Laboral">Laboral</option>
                <option value="Familia">Familia</option>
            </select>
        </div>

        {{-- Número de radicado --}}
        <div class="mb-4">
            <label for="numero_radicado" class="block font-semibold">Número de radicado:</label>
            <input type="text" name="numero_radicado" id="numero_radicado" class="w-full border rounded p-2" placeholder="Ej: 11001-31-05-001-2025-00001-00">
        </div>

        {{-- Demandante --}}
        <div class="mb-4">
            <label for="demandante" class="block font-semibold">Demandante:</label>
            <input type="text" name="demandante" id="demandante" class="w-full border rounded p-2">
        </div>

        {{-- Demandado --}}
        <div class="mb-4">
            <label for="demandado" class="block font-semibold">Demandado:</label>
            <input type="text" name="demandado" id="demandado" class="w-full border rounded p-2">
        </div>

        {{-- Descripción --}}
        <div class="mb-4">
            <label for="descripcion" class="block font-semibold">Descripción del caso:</label>
            <textarea name="descripcion" id="descripcion" rows="4" class="w-full border rounded p-2"></textarea>
        </div>

        {{-- Documentos --}}
        <div class="mb-4">
            <label for="documento" class="block font-semibold">Adjuntar documento inicial:</label>
            <input type="file" name="documento" id="documento" class="w-full border rounded p-2">
        </div>

        <div class="flex justify-end gap-4">
            <a href="{{ route('dashboard.abogado') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Cancelar</a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Crear Proceso</button>
        </div>
    </form>
</div>

</x-app-layout>