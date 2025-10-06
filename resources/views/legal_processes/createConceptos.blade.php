<!DOCTYPE html>
<html lang="es"><!-- pagina para redactar un concepto juridico para un proceso especifico -->
<head> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redactar Concepto Jurídico</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Enlace a CSS corregido -->
    <link rel="stylesheet" href="{{ asset('css/createCon.css') }}">
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h2>Redactar Concepto Jurídico</h2>
            <a href="{{ route('conceptos.create') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> 
                Volver a la Lista
            </a>
        </div>

        <!-- Alert -->
        <div id="successAlert" class="alert">
            <i class="fas fa-check-circle"></i>
            <span>Concepto guardado exitosamente</span>
            <button onclick="this.parentElement.classList.remove('show')">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Información del Proceso -->
        <div class="card">
            <div class="card-header">
                <h5>
                    <i class="fas fa-info-circle"></i> 
                    Información del Proceso
                </h5>
                <span class="badge">{{ $proceso->estado }}</span>
            </div>
            <div class="card-body">
                <div class="info-grid">
                    <div>
                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-hashtag" style="color: #3b82f6;"></i>
                                Número de Radicado:
                            </div>
                            <div class="info-value primary">{{ $proceso->numero_radicado }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-balance-scale" style="color: #10b981;"></i>
                                Tipo de Proceso:
                            </div>
                            <div class="info-value">{{ $proceso->tipo_proceso }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-calendar-alt" style="color: #8b5cf6;"></i>
                                Fecha de Radicación:
                            </div>
                            <div class="info-value">{{ $proceso->created_at }}</div>
                        </div>
                    </div>
                    <div>
                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-user-plus" style="color: #f59e0b;"></i>
                                Demandante:
                            </div>
                            <div class="info-value">{{ $proceso->demandante }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-user-minus" style="color: #ef4444;"></i>
                                Demandado:
                            </div>
                            <div class="info-value">{{ $proceso->demandado }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Formulario del Concepto Jurídico -->
        <div class="card">
            <div class="card-header primary">
                <h5>
                    <i class="fas fa-pen-alt"></i> 
                    Redactar Concepto Jurídico
                </h5>
            </div>
            <div class="card-body">
                <form id="conceptoForm" method="POST" action="{{ route('conceptos.store', $proceso->id) }}">
                    @csrf
                    <!-- Título del Concepto Jurídico -->
    <div class="form-group">
        <label for="titulo" class="form-label">
            <i class="fas fa-heading" style="color: #6366f1;"></i>
            Título del Concepto
            <span class="required">*</span>
        </label>
        <input
            type="text"
            id="titulo"
            name="titulo"
            class="form-input"
            placeholder="Ejemplo: Análisis de la responsabilidad civil en el caso"
            required
            maxlength="120"
        >
        <div class="form-help">
            Escribe un título breve y descriptivo para el concepto (máx. 120 caracteres).
        </div>
    </div>
                    <!-- Concepto Jurídico Principal -->
                    <div class="form-group">
                        <label for="concepto" class="form-label">
                            <i class="fas fa-gavel" style="color: #3b82f6;"></i> 
                            Concepto Jurídico 
                            <span class="required">*</span>
                        </label>
                        <div class="form-help">
                            Redacta un análisis jurídico completo y fundamentado del caso (mínimo 50 caracteres).
                        </div>
                        <div class="textarea-container">
                            <textarea 
                                id="concepto" 
                                name="concepto" 
                                rows="12" 
                                class="form-textarea"
                                placeholder="Ingresa aquí el análisis jurídico detallado del proceso...

    Estructura sugerida:
    1. Análisis de hechos
    2. Marco jurídico aplicable
    3. Análisis legal
    4. Conclusiones"
                                required
                            ></textarea>
                            <div id="conceptoCounter" class="char-counter">0 caracteres</div>
                        </div>
                        <div id="conceptoError" class="form-error">
                            El concepto debe tener al menos 50 caracteres.
                        </div>
                    </div>

                    <!-- Botones de Acción -->
                    <div class="btn-group">
                        <a href="{{ route('conceptos.create') }}" class="btn btn-cancel">
                            <i class="fas fa-times"></i> 
                            Cancelar
                        </a>
                        <div class="btn-actions">
                            <button type="button" onclick="guardarBorrador()" class="btn btn-draft">
                                <i class="fas fa-save"></i> 
                                Guardar Borrador
                            </button>
                            <button type="submit" id="submitBtn" disabled class="btn btn-submit">
                                <i class="fas fa-check"></i> 
                                Finalizar Concepto
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Panel de Ayuda -->
        <div class="help-panel">
            <div class="help-header">
                <h6>
                    <i class="fas fa-question-circle" style="color: #3b82f6;"></i> 
                    Guía para Redactar el Concepto
                </h6>
            </div>
            <div class="help-body">
                <div class="help-grid">
                    <div class="help-section">
                        <h6>Estructura Sugerida:</h6>
                        <div class="help-list">
                            <div class="help-item success">
                                <i class="fas fa-check" style="color: #10b981;"></i>
                                <span>Análisis de hechos</span>
                            </div>
                            <div class="help-item success">
                                <i class="fas fa-check" style="color: #10b981;"></i>
                                <span>Marco jurídico aplicable</span>
                            </div>
                            <div class="help-item success">
                                <i class="fas fa-check" style="color: #10b981;"></i>
                                <span>Análisis legal</span>
                            </div>
                            <div class="help-item success">
                                <i class="fas fa-check" style="color: #10b981;"></i>
                                <span>Conclusiones</span>
                            </div>
                        </div>
                    </div>
                    <div class="help-section">
                        <h6>Consideraciones:</h6>
                        <div class="help-list">
                            <div class="help-item warning">
                                <i class="fas fa-exclamation-triangle" style="color: #f59e0b;"></i>
                                <span>Fundamentar en normatividad vigente</span>
                            </div>
                            <div class="help-item warning">
                                <i class="fas fa-exclamation-triangle" style="color: #f59e0b;"></i>
                                <span>Usar lenguaje técnico apropiado</span>
                            </div>
                            <div class="help-item warning">
                                <i class="fas fa-exclamation-triangle" style="color: #f59e0b;"></i>
                                <span>Ser claro y preciso</span>
                            </div>
                            <div class="help-item warning">
                                <i class="fas fa-exclamation-triangle" style="color: #f59e0b;"></i>
                                <span>Incluir jurisprudencia si aplica</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const conceptoTextarea = document.getElementById('concepto');
            const counter = document.getElementById('conceptoCounter');
            const submitBtn = document.getElementById('submitBtn');
            const errorDiv = document.getElementById('conceptoError');

            // Contador de caracteres
            conceptoTextarea.addEventListener('input', function() {
                const length = this.value.length;
                counter.textContent = length + ' caracteres';

                // Cambiar color según la longitud
                if (length < 50) {
                    counter.className = 'char-counter error';
                    submitBtn.disabled = true;
                    errorDiv.classList.add('show');
                    this.classList.add('error');
                } else {
                    counter.className = 'char-counter success';
                    submitBtn.disabled = false;
                    errorDiv.classList.remove('show');
                    this.classList.remove('error');
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
            // Mostrar mensaje temporal
            const originalText = event.target.innerHTML;
            event.target.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';
            event.target.disabled = true;

            setTimeout(() => {
                event.target.innerHTML = '<i class="fas fa-check"></i> Guardado';
                setTimeout(() => {
                    event.target.innerHTML = originalText;
                    event.target.disabled = false;
                }, 1000);
            }, 1500);
        }
    </script>
</body>
</html>