<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Lista de Abogados
        </h2>
    </x-slot>

    <div class="py-4 px-6">
        @foreach($lawyers as $lawyer)
            <div class="mb-2">
                {{ $lawyer->nombre }} {{ $lawyer->apellido }} - {{ $lawyer->user->email ?? 'Sin usuario' }}
            </div>
        @endforeach
    </div>
</x-app-layout>
