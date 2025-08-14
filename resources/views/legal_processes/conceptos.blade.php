<x-app-layout>
<div class="container">
    <h1 class="mb-4">Detalles del Proceso Judicial</h1>

    <div class="card">
        <div class="card-body">
            {{-- Datos Generales --}}
            <h4>Datos Generales</h4>
            <p><strong>Tipo de proceso:</strong> {{ $proceso->tipo_proceso }}</p>
            <p><strong>Número de radicado:</strong> {{ $proceso->numero_radicado }}</p>
            <p><strong>Fecha de radicación:</strong> {{ $proceso->fecha_radicacion ?? 'No registrada' }}</p>
            <p><strong>Juzgado / Tribunal:</strong> {{ $proceso->juzgado ?? 'No registrado' }}</p>
            <p><strong>Etapa procesal:</strong> {{ $proceso->etapa_procesal ?? 'No registrada' }}</p>

            <hr>

            {{-- Partes Involucradas --}}
            <h4>Partes Involucradas</h4>
            <p><strong>Demandante(s):</strong> {{ $proceso->demandante }}</p>
            <p><strong>Demandado(s):</strong> {{ $proceso->demandado }}</p>
            <p><strong>Abogado(s):</strong> {{ $proceso->abogado ?? 'No registrado' }}</p>

            <hr>

            {{-- Información Jurídica --}}
            <h4>Información Jurídica</h4>
            <p><strong>Pretensiones:</strong> {{ $proceso->pretensiones ?? 'No registradas' }}</p>
            <p><strong>Hechos:</strong> {{ $proceso->hechos ?? 'No registrados' }}</p>
            <p><strong>Fundamentos de derecho:</strong> {{ $proceso->fundamentos_derecho ?? 'No registrados' }}</p>
            <p><strong>Pruebas:</strong> {{ $proceso->pruebas ?? 'No registradas' }}</p>
            <p><strong>Medidas cautelares:</strong> {{ $proceso->medidas_cautelares ?? 'No registradas' }}</p>

            <hr>

            {{-- Documentos --}}
            <h4>Documentos</h4>
            @if($proceso->documento)
                <a href="{{ asset('storage/' . $proceso->documento) }}" target="_blank" class="btn btn-sm btn-primary">
                    Ver documento adjunto
                </a>
            @else
                <p>No hay documento adjunto</p>
            @endif

            <hr>

            {{-- Seguimiento --}}
            <h4>Seguimiento</h4>
            <p><strong>Estado actual:</strong> {{ $proceso->estado ?? 'No registrado' }}</p>
            <p><strong>Observaciones:</strong> {{ $proceso->observaciones ?? 'No registradas' }}</p>

            <div class="mt-4">
                <a href="{{ route('procesos.edit', $proceso->id) }}" class="btn btn-warning">Editar</a>
                <a href="{{ route('procesos.index') }}" class="btn btn-secondary">Volver al listado</a>
            </div>
        </div>
    </div>
</div>

</x-app-layout>