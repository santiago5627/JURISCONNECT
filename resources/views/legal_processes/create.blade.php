<!DOCTYPE html>
<html lang="es"><!-- pagina para crear un nuevo proceso judicial -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Proceso Judicial</title>
    <!-- Enlace a CSS corregido -->
    <link rel="stylesheet" href="{{ asset('css/createPro.css') }}">
</head>

<body>
    <div class="container">
        <div class="form-wrapper">
<!-- Header -->
            <div class="header">

                <form id="formProceso" action="{{ route('procesos.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <h1>
                    <svg class="header-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Crear Nuevo Proceso Judicial
                </h1>
                <p>Complete los datos del proceso judicial</p>
<!-- Botones -->
                    <div class="button-container">
                        <a href="{{ route('dashboard.abogado') }}" class="btn btn-cancel">
                            <svg class="btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <svg class="btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Crear Proceso Judicial
                        </button>
                    </div>
                
            </div>
            <div class="form-content">
<!-- Mensajes de error -->
                <div class="error-container" id="errorContainer" style="display: none;">
                    <div class="error-header">
                        <svg class="error-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="error-title">Se encontraron errores:</h3>
                    </div>
                    <ul class="error-list">
                        <li>Ejemplo de error de validación</li>
                    </ul>
                </div>

<!-- Grid de campos principales -->
                    <div class="form-grid">
<!-- Tipo de Proceso -->
                        <div class="field-group">
                            <label for="tipo_proceso" class="field-label">
                                <span class="label-content">
                                    <svg class="label-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                    Tipo de proceso
                                </span>
                            </label>
                            <select name="tipo_proceso" id="tipo_proceso" class="form-select">
                                <option value="">-- Seleccione un tipo --</option>
                                <option value="Civil">Civil</option>
                                <option value="Penal">Penal</option>
                                <option value="Laboral">Laboral</option>
                                <option value="Familia">Familia</option>
                            </select>
                        </div>
<!-- Número de radicado -->
                        <div class="field-group">
                            <label for="numero_radicado" class="field-label">
                                <span class="label-content">
                                    <svg class="label-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                                    </svg>
                                    Número de radicado
                                </span>
                            </label>
                            <input type="text" name="numero_radicado" id="numero_radicado" class="form-input" 
                                placeholder="11001-2025-00001">
                                @error('numero_radicado')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                        </div>
                    </div>
<!-- Partes del proceso -->
                    <div class="parties-section">
                        <h3 class="section-title">Partes del Proceso</h3>
                        
                        <div class="parties-grid">
<!-- Demandante -->
                            <div class="field-group">
                                <label for="demandante" class="field-label">
                                    <span class="label-content">
                                        <svg class="label-icon demandante-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        Demandante
                                    </span>
                                </label>
                                <input type="text" name="demandante" id="demandante" 
                                    class="form-input demandante-input" 
                                    placeholder="Nombre completo del demandante">
                            </div>
<!-- Demandado -->
                            <div class="field-group">
                                <label for="demandado" class="field-label">
                                    <span class="label-content">
                                        <svg class="label-icon demandado-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        Demandado
                                    </span>
                                </label>
                                <input type="text" name="demandado" id="demandado" 
                                    class="form-input demandado-input" 
                                    placeholder="Nombre completo del demandado">
                            </div>
                        </div>
                    </div>
<!-- Descripción -->
                    <div class="field-group">
                        <label for="descripcion" class="field-label">
                            <span class="label-content">
                                <svg class="label-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Descripción del caso
                            </span>
                        </label>
                        <textarea name="descripcion" id="descripcion" class="form-textarea" 
                                placeholder="Describa detalladamente el caso, los hechos relevantes y las pretensiones..."></textarea>
                        <p class="help-text">Proporcione una descripción clara y detallada del proceso judicial</p>
                    </div>
<!-- Documentos -->
                    <div class="document-section">
                        <div class="document-header">
                            <svg class="document-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.586-6.586a2 2 0 000-2.828L15.172 7z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7V5a2 2 0 00-2-2H8a2 2 0 00-2 2v2"></path>
                            </svg>
                            <h3 class="document-title">Adjuntar Documento</h3>
                        </div>
                        
                        <div class="field-group">
                            <label for="documento" class="field-label" style="color: #1d4ed8;">
                                Documento inicial del proceso
                            </label>
                            <div class="file-input">
                                <input type="file" name="documento" id="documento" class="form-input">
                            </div>
                            <p class="file-help">Formatos permitidos: PDF, DOC, DOCX. Tamaño máximo: 10MB</p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

<script>
document.getElementById('formProceso').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    try {
        const response = await fetch('{{ route("procesos.store") }}', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                // NO pongas 'Content-Type' cuando usas FormData
            },
            body: formData // Envía FormData directamente
        });
        




        
        const result = await response.json();
        
        if (result.success) {
            alert('Proceso creado exitosamente');
            window.location.href = '{{ route("legal_processes.index") }}';
        } else {
            // Mostrar errores de validación
            if (result.errors) {
                let errores = '';
                for (let campo in result.errors) {
                    errores += result.errors[campo].join('\n') + '\n';
                }
                alert('Errores:\n' + errores);
            } else {
                alert('Error: ' + result.message);
            }
        }
        
    } catch (error) {
        console.error('Error:', error);
        alert('Error de conexión');
    }
});
</script>
