<x-app-layout>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Redactar Concepto Jurídico</h2>
                <a href="{{ route('abogado.crear-concepto') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Volver a la Lista
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(isset($proceso))
<!-- Información del Proceso -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-dark text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="fas fa-info-circle"></i> Información del Proceso
                            </h5>
                            <span class="badge bg-warning text-dark">{{ ucfirst($proceso->estado) }}</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-item mb-3">
                                    <strong><i class="fas fa-hashtag text-primary"></i> Número de Radicado:</strong>
                                    <span class="text-primary fw-bold">{{ $proceso->numero_radicado }}</span>
                                </div>
                                <div class="info-item mb-3">
                                    <strong><i class="fas fa-balance-scale text-success"></i> Tipo de Proceso:</strong>
                                    <span>{{ $proceso->tipo_proceso }}</span>
                                </div>
                                <div class="info-item mb-3">
                                    <strong><i class="fas fa-calendar-alt text-info"></i> Fecha de Radicación:</strong>
                                    <span>{{ $proceso->fecha_radicacion?->format('d/m/Y') ?? 'N/A' }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item mb-3">
                                    <strong><i class="fas fa-user-plus text-warning"></i> Demandante:</strong>
                                    <span>{{ $proceso->demandante }}</span>
                                </div>
                                <div class="info-item mb-3">
                                    <strong><i class="fas fa-user-minus text-danger"></i> Demandado:</strong>
                                    <span>{{ $proceso->demandado }}</span>
                                </div>
                                <div class="info-item mb-3">
                                    <strong><i class="fas fa-clock text-muted"></i> Proceso creado:</strong>
                                    <span>{{ $proceso->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

<!-- Formulario del Concepto Jurídico -->
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-pen-alt"></i> Redactar Concepto Jurídico
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('abogado.guardar-concepto', $proceso->id) }}" method="POST" id="conceptoForm">
                            @csrf
                            @method('PUT')

<!-- Concepto Jurídico Principal -->
                            <div class="mb-4">
                                <label for="concepto" class="form-label fw-bold">
                                    <i class="fas fa-gavel text-primary"></i> Concepto Jurídico *
                                </label>
                                <div class="form-text mb-2">
                                    Redacta un análisis jurídico completo y fundamentado del caso (mínimo 50 caracteres).
                                </div>
                                <textarea name="concepto" id="concepto" rows="10" 
                                    class="form-control @error('concepto') is-invalid @enderror" 
                                    placeholder="Ingresa aquí el análisis jurídico detallado del proceso..."
                                    required>{{ old('concepto') }}</textarea>
                                <div class="form-text">
                                    <small id="conceptoCounter" class="text-muted">0 caracteres</small>
                                </div>
                                @error('concepto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

<!-- Recomendaciones -->
                            <div class="mb-4">
                                <label for="recomendaciones" class="form-label fw-bold">
                                    <i class="fas fa-lightbulb text-warning"></i> Recomendaciones (Opcional)
                                </label>
                                <div class="form-text mb-2">
                                    Proporciona recomendaciones estratégicas para el manejo del caso.
                                </div>
                                <textarea name="recomendaciones" id="recomendaciones" rows="6" 
                                    class="form-control"
                                    placeholder="Ingresa recomendaciones adicionales para el caso...">{{ old('recomendaciones') }}</textarea>
                            </div>

<!-- Botones de Acción -->
                            <div class="d-flex justify-content-between">
                                <div>
                                    <a href="{{ route('abogado.crear-concepto') }}" class="btn btn-outline-secondary btn-lg">
                                        <i class="fas fa-times"></i> Cancelar
                                    </a>
                                </div>
                                <div>
                                    <button type="button" class="btn btn-outline-primary btn-lg me-2" onclick="guardarBorrador()">
                                        <i class="fas fa-save"></i> Guardar Borrador
                                    </button>
                                    <button type="submit" class="btn btn-success btn-lg" id="submitBtn">
                                        <i class="fas fa-check"></i> Finalizar Concepto
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

<!-- Panel de Ayuda -->
                <div class="card bg-light mt-4">
                    <div class="card-header bg-transparent">
                        <h6 class="mb-0">
                            <i class="fas fa-question-circle text-info"></i> Guía para Redactar el Concepto
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Estructura Sugerida:</h6>
                                <ul class="list-unstyled small">
                                    <li><i class="fas fa-check text-success"></i> Análisis de hechos</li>
                                    <li><i class="fas fa-check text-success"></i> Marco jurídico aplicable</li>
                                    <li><i class="fas fa-check text-success"></i> Análisis legal</li>
                                    <li><i class="fas fa-check text-success"></i> Conclusiones</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h6>Consideraciones:</h6>
                                <ul class="list-unstyled small">
                                    <li><i class="fas fa-exclamation-triangle text-warning"></i> Fundamentar en normatividad vigente</li>
                                    <li><i class="fas fa-exclamation-triangle text-warning"></i> Usar lenguaje técnico apropiado</li>
                                    <li><i class="fas fa-exclamation-triangle text-warning"></i> Ser claro y preciso</li>
                                    <li><i class="fas fa-exclamation-triangle text-warning"></i> Incluir jurisprudencia si aplica</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            @else
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle"></i> 
                    No se encontró información del proceso. 
                    <a href="{{ route('abogado.crear-concepto') }}">Volver a la lista</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .info-item {
        padding: 0.5rem 0;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .info-item:last-child {
        border-bottom: none;
    }
    
    .form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }
    
    .btn-lg {
        padding: 0.75rem 1.5rem;
        font-weight: 600;
    }
    
    #conceptoCounter {
        float: right;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const conceptoTextarea = document.getElementById('concepto');
    const counter = document.getElementById('conceptoCounter');
    const submitBtn = document.getElementById('submitBtn');

// Contador de caracteres
    conceptoTextarea.addEventListener('input', function() {
        const length = this.value.length;
        counter.textContent = length + ' caracteres';

// Cambiar color según la longitud
        if (length < 50) {
            counter.className = 'text-danger';
            submitBtn.disabled = true;
        } else {
            counter.className = 'text-success';
            submitBtn.disabled = false;
        }
    });

// Trigger inicial
    conceptoTextarea.dispatchEvent(new Event('input'));

// Confirmación antes de enviar
    document.getElementById('conceptoForm').addEventListener('submit', function(e) {
        if (!confirm('¿Estás seguro de que deseas finalizar este concepto? Una vez enviado, no podrás modificarlo.')) {
            e.preventDefault();
        }
    });
});

function guardarBorrador() {
    // Aquí podrías implementar la funcionalidad de guardar borrador
    // Por ahora, solo mostramos un mensaje
    alert('Funcionalidad de borrador en desarrollo. Por favor, guarda el concepto completo.');
}
</script>

</x-app-layout>