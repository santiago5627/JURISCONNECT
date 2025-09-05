<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Proceso Judicial - CSS Puro</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Reset y base */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            min-height: 100vh;
            color: #1f2937;
            line-height: 1.6;
        }

        /* Navbar */
        .navbar {
            background: #ffffff;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1), 0 1px 2px rgba(0, 0, 0, 0.06);
            border-bottom: 1px solid #e5e7eb;
        }

        .nav-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 64px;
        }

        .nav-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .nav-brand i {
            color: #3b82f6;
            font-size: 1.5rem;
        }

        .nav-brand span {
            font-size: 1.25rem;
            font-weight: 700;
            color: #111827;
        }

        /* Container principal */
        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 2rem 1rem;
            display: flex;
            justify-content: center;
        }

        /* Card principal */
        .main-card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            border: 1px solid #f3f4f6;
            overflow: hidden;
            width: 100%;
            max-width: 900px;
            transition: all 0.3s ease;
        }

        .main-card:hover {
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        }

        /* Header del card */
        .card-header {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            padding: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .card-header h1 {
            font-size: 1.875rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .back-btn {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            padding: 0.75rem 1.5rem;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 0.5rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 600;
            transition: all 0.2s ease;
            backdrop-filter: blur(10px);
        }

        .back-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            border-color: rgba(255, 255, 255, 0.5);
            transform: translateY(-1px);
            color: white;
        }

        /* Contenido del card */
        .card-body {
            padding: 2.5rem;
        }

        /* Alertas de error */
        .alert {
            margin-bottom: 2rem;
            padding: 1.5rem;
            border-radius: 0.75rem;
            border: 1px solid;
        }

        .alert-danger {
            background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
            border-color: #fca5a5;
            color: #dc2626;
        }

        .alert ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .alert li {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.5rem;
        }

        .alert li:before {
            content: "\f06a";
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            color: #dc2626;
        }

        .alert li:last-child {
            margin-bottom: 0;
        }

        /* Formulario */
        .form {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-label {
            font-weight: 600;
            color: #374151;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .form-label .required {
            color: #dc2626;
        }

        .form-control {
            padding: 0.875rem 1rem;
            border: 2px solid #e5e7eb;
            border-radius: 0.5rem;
            font-size: 1rem;
            transition: all 0.2s ease;
            background: #ffffff;
            font-family: inherit;
        }

        .form-control:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            transform: translateY(-1px);
        }

        .form-control:hover {
            border-color: #d1d5db;
        }

        .form-control.is-invalid {
            border-color: #dc2626;
            background: #fef2f2;
        }

        .form-control.is-invalid:focus {
            border-color: #dc2626;
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
        }

        /* Select personalizado */
        .form-select {
            padding: 0.875rem 1rem;
            border: 2px solid #e5e7eb;
            border-radius: 0.5rem;
            font-size: 1rem;
            transition: all 0.2s ease;
            background: #ffffff url("data:image/svg+xml;charset=utf-8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3E%3Cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3E%3C/svg%3E") no-repeat right 0.75rem center;
            background-size: 16px 12px;
            appearance: none;
            font-family: inherit;
            cursor: pointer;
        }

        .form-select:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .form-select:hover {
            border-color: #d1d5db;
        }

        /* Textarea */
        .form-textarea {
            padding: 0.875rem 1rem;
            border: 2px solid #e5e7eb;
            border-radius: 0.5rem;
            font-size: 1rem;
            transition: all 0.2s ease;
            background: #ffffff;
            font-family: inherit;
            resize: vertical;
            min-height: 120px;
        }

        .form-textarea:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .form-textarea:hover {
            border-color: #d1d5db;
        }

        /* File input */
        .file-input {
            position: relative;
            display: inline-block;
            width: 100%;
        }

        .file-input input[type="file"] {
            position: absolute;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        .file-input-label {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.875rem 1rem;
            border: 2px dashed #d1d5db;
            border-radius: 0.5rem;
            background: #f9fafb;
            color: #6b7280;
            cursor: pointer;
            transition: all 0.2s ease;
            font-weight: 500;
        }

        .file-input:hover .file-input-label {
            border-color: #3b82f6;
            background: #eff6ff;
            color: #3b82f6;
        }

        .file-input-icon {
            font-size: 1.25rem;
            color: #9ca3af;
        }

        .file-input:hover .file-input-icon {
            color: #3b82f6;
        }

        /* Archivo actual */
        .current-file {
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            border: 1px solid #bfdbfe;
            border-radius: 0.75rem;
            padding: 1.5rem;
            margin-bottom: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .current-file-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: #1e40af;
        }

        .current-file-info i {
            font-size: 1.5rem;
            color: #3b82f6;
        }

        .current-file-actions {
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }

        .btn-view {
            background: #3b82f6;
            color: white;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 0.375rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .btn-view:hover {
            background: #2563eb;
            transform: translateY(-1px);
            color: white;
        }

        .btn-delete-file {
            background: #ef4444;
            color: white;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 0.375rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-delete-file:hover {
            background: #dc2626;
            transform: translateY(-1px);
        }

        .delete-checkbox {
            margin-right: 0.5rem;
            transform: scale(1.2);
        }

        /* Texto de ayuda */
        .form-text {
            font-size: 0.875rem;
            color: #6b7280;
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-text i {
            color: #9ca3af;
        }

        /* Mensajes de error */
        .invalid-feedback {
            color: #dc2626;
            font-size: 0.875rem;
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .invalid-feedback:before {
            content: "\f06a";
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
        }

        /* Botones de acción */
        .form-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            padding-top: 2rem;
            border-top: 1px solid #e5e7eb;
            margin-top: 1rem;
            flex-wrap: wrap;
        }

        .btn {
            padding: 0.875rem 2rem;
            border: none;
            border-radius: 0.5rem;
            font-weight: 600;
            font-size: 1rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            cursor: pointer;
            transition: all 0.2s ease;
            justify-content: center;
            min-width: 150px;
        }

        .btn-secondary {
            background: #f3f4f6;
            color: #374151;
            border: 2px solid #e5e7eb;
        }

        .btn-secondary:hover {
            background: #e5e7eb;
            color: #1f2937;
            transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            border: 2px solid transparent;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.3);
            color: white;
        }

        /* Animaciones */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in-up {
            animation: fadeInUp 0.6s ease-out forwards;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }

            .card-header {
                padding: 1.5rem;
                flex-direction: column;
                align-items: stretch;
                text-align: center;
            }

            .card-header h1 {
                font-size: 1.5rem;
                justify-content: center;
            }

            .card-body {
                padding: 1.5rem;
            }

            .form-row {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .form-actions {
                flex-direction: column;
                align-items: stretch;
            }

            .btn {
                min-width: unset;
                width: 100%;
            }

            .current-file {
                flex-direction: column;
                align-items: stretch;
                text-align: center;
            }

            .current-file-actions {
                justify-content: center;
            }
        }

        @media (max-width: 480px) {
            .nav-container {
                padding: 0 0.5rem;
            }

            .nav-brand span {
                font-size: 1rem;
            }

            .card-header h1 {
                font-size: 1.25rem;
            }

            .form-control,
            .form-select,
            .form-textarea {
                padding: 0.75rem;
                font-size: 0.875rem;
            }
        }

        /* Estados de loading */
        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .btn:disabled:hover {
            transform: none;
            box-shadow: none;
        }
    </style>
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
                            <label for="tipo_proceso" class="form-label">
                                Tipo de Proceso <span class="required">*</span>
                            </label>
                            <select class="form-select @error('tipo_proceso') is-invalid @enderror"  id="tipo_proceso" name="tipo_proceso" required>
                                <option value="">Seleccionar tipo</option>
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

<!-- Descripción -->
                    <div class="form-group full-width">
                        <label for="descripcion" class="form-label">
                            Descripción <span class="required">*</span>
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
            document.getElementById('error-alert').scrollIntoView({ behavior: 'smooth' });
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