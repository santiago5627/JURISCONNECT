<!DOCTYPE html>
<html lang="es">

<head> <!-- pagina para editar proceso juridico -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Proceso Judicial - CSS Puro</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Enlace a CSS corregido -->
    <link rel="stylesheet" href="{{ asset('css/editPro.css') }}">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-brand">
                <i class="fas fa-balance-scale"></i>
                <span>Sistema Jurídico</span>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="main-card fade-in-up">
            <!-- Header -->
            <div class="card-header">
                <h1>
                    <i class="fas fa-edit"></i>
                    Editar Proceso Judicial
                </h1>
                <a href="#" class="back-btn" onclick="window.history.back()">
                    <i class="fas fa-arrow-left"></i>
                    Volver
                </a>
            </div>

            <!-- Contenido -->
            <div class="card-body">
                <!-- Alerta de errores (ejemplo) -->
                <div class="alert alert-danger" style="display: none;" id="error-alert">
                    <ul>
                        <li>El campo tipo de proceso es obligatorio.</li>
                        <li>El número de radicado debe ser único.</li>
                    </ul>
                </div>

                <!-- Formulario -->
                <form class="form" method="POST" enctype="multipart/form-data" action="{{ route('procesos.update', $proceso->id) }}">
                    @csrf
                    @method('PUT')
                    <!-- Primera fila -->

                    <div class="form-row">
                        <div class="form-group">
                            <label for="estado" class="form-label">
                                Estado de proceso <span class="required">*</span>
                            </label>
                            <select class="form-select @error('estado') is-invalid @enderror" id="estado" name="estado" required>
                                <option value="Pendiente" {{ old('estado', $proceso->estado) == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="Primera instancia" {{ old('estado', $proceso->estado) == 'Primera instancia' ? 'selected' : '' }}>primera instancia</option>
                                <option value="En curso" {{ old('estado', $proceso->estado) == 'En curso' ? 'selected' : '' }}>En curso</option>
                                <option value="Finalizado" {{ old('estado', $proceso->estado) == 'Finalizado' ? 'selected' : '' }}>Finalizado</option>
                                <option value="En audiencia" {{ old('estado', $proceso->estado) == 'En audiencia' ? 'selected' : '' }}>en audiencia</option>
                                <option value="Pendiente fallo" {{ old('estado', $proceso->estado) == 'Pendiente fallo' ? 'selected' : '' }}>pendiente fallo</option>
                                <option value="Favorable primera" {{ old('estado', $proceso->estado) == 'Favorable primera' ? 'selected' : '' }}>favorable primera</option>
                                <option value="Desfavorable primera" {{ old('estado', $proceso->estado) == 'Desfavorable primera' ? 'selected' : '' }}>desfavorable primera</option>
                                <option value="En apelacion" {{ old('estado', $proceso->estado) == 'En apelacion' ? 'selected' : '' }}>en apelacion</option>
                                <option value="Conciliacion pendiente" {{ old('estado', $proceso->estado) == 'Conciliacion pendiente' ? 'selected' : '' }}>conciliacion pendiente</option>
                                <option value="Conciliado" {{ old('estado', $proceso->estado) == 'Conciliado' ? 'selected' : '' }}>conciliado</option>
                                <option value="Sentencia ejecutoriada" {{ old('estado', $proceso->estado) == 'Sentencia ejecutoriada' ? 'selected' : '' }}>sentencia ejecutoriada</option>
                                <option value="En proceso pago" {{ old('estado', $proceso->estado) == 'En proceso pago' ? 'selected' : '' }}>en proceso pago</option>
                                <option value="Terminado" {{ old('estado', $proceso->estado) == 'Terminado' ? 'selected' : '' }}>terminado</option>
                            </select>
                            @error('estado')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="tipo_proceso" class="form-label">
                                Tipo de Proceso <span class="required">*</span>
                            </label>
                            <select class="form-select @error('tipo_proceso') is-invalid @enderror" id="tipo_proceso" name="tipo_proceso" required>
                                <option value="Civil" {{ old('tipo_proceso', $proceso->tipo_proceso) == 'Civil' ? 'selected' : '' }}>Civil</option>
                                <option value="Penal" {{ old('tipo_proceso', $proceso->tipo_proceso) == 'Penal' ? 'selected' : '' }}>Penal</option>
                                <option value="Laboral" {{ old('tipo_proceso', $proceso->tipo_proceso) == 'Laboral' ? 'selected' : '' }}>Laboral</option>
                                <option value="Administrativo" {{ old('tipo_proceso', $proceso->tipo_proceso) == 'Administrativo' ? 'selected' : '' }}>Administrativo</option>
                                <option value="Familia" {{ old('tipo_proceso', $proceso->tipo_proceso) == 'Familia' ? 'selected' : '' }}>Familia</option>
                                <option value="Comercial" {{ old('tipo_proceso', $proceso->tipo_proceso) == 'Comercial' ? 'selected' : '' }}>Comercial</option>
                            </select>
                            @error('tipo_proceso')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="numero_radicado" class="form-label">
                                Número de Radicado <span class="required">*</span>
                            </label>
                            <input type="text"
                                class="form-control @error('numero_radicado') is-invalid @enderror"
                                id="numero_radicado"
                                name="numero_radicado"
                                value="{{ old('numero_radicado', $proceso->numero_radicado) }}"
                                placeholder="Ej: 2024-001-JC"
                                required>
                            @error('numero_radicado')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Segunda fila -->
                    <div class="form-row">
                        <div class="form-group">
                            <label for="demandante" class="form-label">
                                Demandante <span class="required">*</span>
                            </label>
                            <input type="text"
                                class="form-control @error('demandante') is-invalid @enderror"
                                id="demandante"
                                name="demandante"
                                placeholder="Nombre completo del demandante"
                                value="{{ old('demandante', $proceso->demandante) }}"
                                required>
                            @error('demandante')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="demandado" class="form-label">
                                Demandado <span class="required">*</span>
                            </label>
                            <input type="text"
                                class="form-control @error('demandado') is-invalid @enderror"
                                id="demandado"
                                name="demandado"
                                placeholder="Nombre completo del demandado"
                                value="{{ old('demandado', $proceso->demandado) }}"
                                required>
                            @error('demandado')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!--  -->
                    <div class="form-group full-width">
                        <label for="descripcion" class="form-label">
                             <span class="required">*</span> 
                        </label>
                        <textarea class="form-textarea @error('descripcion') is-invalid @enderror"
                            id="descripcion"
                            name="descripcion"
                            rows="4"
                            placeholder="Describa los detalles del proceso judicial..."
                            required>{{ old('descripcion', $proceso->descripcion) }}</textarea>
                        @error('descripcion')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Documento -->
                    <div class="form-group full-width">
                        <label for="documento" class="form-label">
                            <i class="fas fa-file-upload"></i>
                            Documento
                        </label>

                        <!-- Archivo actual -->
                        @if($proceso->documento)
                        <div class="current-file">
                            <div class="current-file-info">
                                <span>
                                    <i class="fas fa-file-pdf"></i>
                                    Archivo actual: {{ basename($proceso->documento) }}
                                </span>
                            </div>
                            <div class="current-file-actions">
                                <a href="{{ Storage::url($proceso->documento) }}" class="btn-view" target="_blank">
                                    <i class="fas fa-eye"></i>
                                    Ver
                                </a>
                                <label class="btn-delete-file">
                                    <button type="submit" name="eliminar_documento" value="1" class="delete-checkbox"></button>
                                    <i class="fas fa-trash"></i>
                                    Eliminar
                                </label>
                            </div>
                        </div>
                        @endif

                        <!-- Input para nuevo archivo -->
                        <div class="file-input">
                            <input type="file"
                                class="form-control @error('documento') is-invalid @enderror"
                                id="documento"
                                name="documento"
                                accept=".pdf,.doc,.docx">
                            <label for="documento" class="file-input-label">
                                <i class="fas fa-cloud-upload-alt file-input-icon"></i>
                                <span>Seleccionar nuevo archivo o arrastra aquí</span>
                            </label>
                        </div>

                        <div class="form-text">
                            <i class="fas fa-info-circle"></i>
                            Formatos permitidos: PDF, DOC, DOCX. Tamaño máximo: 2MB
                        </div>
                        @error('documento')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Botones de acción -->
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i>
                            Actualizar Proceso
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <script>
        // Función para mostrar/ocultar alertas
        function showErrorAlert() {
            document.getElementById('error-alert').style.display = 'block';
            document.getElementById('error-alert').scrollIntoView({
                behavior: 'smooth'
            });
        }

        // Función para mostrar estado de carga
        function showLoading(button) {
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Actualizando...';
            button.disabled = true;
            // Simular carga (en aplicación real esto se manejaría con el envío del formulario)
            setTimeout(() => {
                button.innerHTML = '<i class="fas fa-check"></i> ¡Actualizado!';
                setTimeout(() => {
                    button.innerHTML = '<i class="fas fa-save"></i> Actualizar Proceso';
                    button.disabled = false;
                }, 1000);
            }, 2000);
        }

        // Mejorar la experiencia del file input
        document.getElementById('documento').addEventListener('change', function(e) {
            const label = document.querySelector('.file-input-label span');
            if (e.target.files.length > 0) {
                label.textContent = `Archivo seleccionado: ${e.target.files[0].name}`;
                label.parentElement.style.borderColor = '#3b82f6';
                label.parentElement.style.background = '#eff6ff';
                label.parentElement.style.color = '#3b82f6';
            } else {
                label.textContent = 'Seleccionar nuevo archivo o arrastra aquí';
            }
        });

        // Drag and drop para el file input
        const fileInput = document.querySelector('.file-input');
        const fileInputLabel = document.querySelector('.file-input-label');

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            fileInput.addEventListener(eventName, preventDefaults, false);
            document.body.addEventListener(eventName, preventDefaults, false);
        });

        ['dragenter', 'dragover'].forEach(eventName => {
            fileInput.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            fileInput.addEventListener(eventName, unhighlight, false);
        });

        fileInput.addEventListener('drop', handleDrop, false);

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        function highlight(e) {
            fileInputLabel.style.borderColor = '#3b82f6';
            fileInputLabel.style.background = '#eff6ff';
            fileInputLabel.style.color = '#3b82f6';
        }

        function unhighlight(e) {
            fileInputLabel.style.borderColor = '#d1d5db';
            fileInputLabel.style.background = '#f9fafb';
            fileInputLabel.style.color = '#6b7280';
        }

        function handleDrop(e) {
            const files = e.dataTransfer.files;
            document.getElementById('documento').files = files;

            if (files.length > 0) {
                const label = document.querySelector('.file-input-label span');
                label.textContent = `Archivo seleccionado: ${files[0].name}`;
            }
        }

        // Validación en tiempo real
        document.querySelectorAll('input[required], select[required], textarea[required]').forEach(field => {
            field.addEventListener('blur', function() {
                if (!this.value.trim()) {
                    this.classList.add('is-invalid');
                } else {
                    this.classList.remove('is-invalid');
                }
            });

            field.addEventListener('input', function() {
                if (this.classList.contains('is-invalid') && this.value.trim()) {
                    this.classList.remove('is-invalid');
                }
            });
        });

        // Ejemplo de mostrar alerta de error (descomenta para probar)
        // setTimeout(() => showErrorAlert(), 1000);
    </script>
</body>

</html>