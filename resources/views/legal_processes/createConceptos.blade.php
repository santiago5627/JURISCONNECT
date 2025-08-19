<x-app-layout>
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            
            {{-- Información del Proceso --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0"> Información del Proceso</h5>
                </div>
                <div class="card-body">
                    <p><strong>Radicado:</strong> {{ $procesos->numero_radicado }}</p>
                    <p><strong>Tipo de Proceso:</strong> {{ $procesos->tipo_proceso }}</p>
                    <p><strong>Demandante:</strong> {{ $procesos->demandante }}</p>
                    <p><strong>Demandado:</strong> {{ $procesos->demandado }}</p>
                    <p><strong>Fecha Radicación:</strong> {{ $procesos->fecha_radicacion?->format('d/m/Y') ?? 'N/A' }}</p>
                    <p><strong>Estado Concepto:</strong> 
                        @if($proceso->concepto_juridico)
                            <span class="badge bg-success"> Completado</span>
                        @else
                            <span class="badge bg-warning text-dark"> Pendiente</span>
                        @endif
                    </p>
                </div>
            </div>

            {{-- Formulario Concepto Jurídico --}}
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"> Redactar Concepto Jurídico</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('abogado.guardar-concepto', $proceso->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Concepto Jurídico --}}
                        <div class="mb-3">
                            <label for="concepto" class="form-label fw-bold">Concepto Jurídico *</label>
                            <textarea name="concepto" id="concepto" rows="8" 
                                class="form-control @error('concepto') is-invalid @enderror" 
                                required>{{ old('concepto', $proceso->concepto_juridico) }}</textarea>
                            @error('concepto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Recomendaciones --}}
                        <div class="mb-3">
                            <label for="recomendaciones" class="form-label fw-bold">Recomendaciones</label>
                            <textarea name="recomendaciones" id="recomendaciones" rows="4" 
                                class="form-control">{{ old('recomendaciones', $proceso->recomendaciones) }}</textarea>
                        </div>

                        {{-- Botones --}}
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('abogado.mis-procesos') }}" class="btn btn-secondary">
                                Volver
                            </a>
                            <button type="submit" class="btn btn-success">
                                Guardar Concepto
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- CKEditor 5 --}}
<script src="https://cdn.ckeditor.com/ckeditor5/41.2.1/classic/ckeditor.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        ClassicEditor
            .create(document.querySelector('#concepto'))
            .catch(error => {
                console.error(error);
            });
    });
</script>

</x-app-layout>
