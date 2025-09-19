<!DOCTYPE html>
<html lang="es"><!-- pagina para crear un nuevo proceso judicial -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Proceso Judicial</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }

        .form-wrapper {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .header {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            padding: 2rem;
            color: white;
        }

        .header h1 {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
        }

        .header-icon {
            width: 2rem;
            height: 2rem;
            margin-right: 1rem;
        }

        .header p {
            color: #cbd5e1;
            font-size: 1rem;
        }

        .form-content {
            padding: 2rem;
        }

        .error-container {
            background: #fef2f2;
            border-left: 4px solid #ef4444;
            padding: 1.5rem;
            border-radius: 8px;
            margin-bottom: 2rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .error-header {
            display: flex;
            align-items: center;
            margin-bottom: 0.75rem;
        }

        .error-icon {
            width: 1.5rem;
            height: 1.5rem;
            color: #ef4444;
            margin-right: 0.5rem;
        }

        .error-title {
            color: #991b1b;
            font-weight: 600;
        }

        .error-list {
            list-style-type: disc;
            margin-left: 2rem;
        }

        .error-list li {
            color: #b91c1c;
            margin-bottom: 0.25rem;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        @media (min-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        .field-group {
            margin-bottom: 2rem;
        }

        .field-label {
            display: block;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
        }

        .label-content {
            display: flex;
            align-items: center;
        }

        .label-icon {
            width: 1.25rem;
            height: 1.25rem;
            margin-right: 0.5rem;
            color: #2563eb;
        }

        .form-input, .form-select, .form-textarea {
            width: 100%;
            padding: 1rem;
            border: 2px solid #d1d5db;
            border-radius: 12px;
            font-size: 1rem;
            color: #374151;
            background: white;
            transition: all 0.2s ease;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .form-input:hover, .form-select:hover, .form-textarea:hover {
            border-color: #9ca3af;
        }

        .form-input:focus, .form-select:focus, .form-textarea:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .form-input::placeholder, .form-textarea::placeholder {
            color: #9ca3af;
        }

        .form-textarea {
            resize: none;
            min-height: 120px;
        }

        .parties-section {
            background: #f9fafb;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .section-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: #1f2937;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid #d1d5db;
            margin-bottom: 1.5rem;
        }

        .parties-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        @media (min-width: 768px) {
            .parties-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        .demandante-input:focus {
            border-color: #059669;
            box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1);
        }

        .demandado-input:focus {
            border-color: #dc2626;
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
        }

        .demandante-icon {
            color: #059669;
        }

        .demandado-icon {
            color: #dc2626;
        }

        .document-section {
            background: #eff6ff;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .document-header {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }

        .document-icon {
            width: 1.5rem;
            height: 1.5rem;
            color: #2563eb;
            margin-right: 0.75rem;
        }

        .document-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: #1e40af;
        }

        .file-input {
            position: relative;
        }

        .file-input input[type="file"] {
            border-color: #bfdbfe;
            background: white;
        }

        .file-input input[type="file"]:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .file-input input[type="file"]::-webkit-file-upload-button {
            margin-right: 1rem;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            border: none;
            background: #eff6ff;
            color: #1d4ed8;
            font-weight: 600;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .file-input input[type="file"]::-webkit-file-upload-button:hover {
            background: #dbeafe;
        }

        .file-help {
            font-size: 0.75rem;
            color: #2563eb;
            margin-top: 0.5rem;
        }

        .help-text {
            font-size: 0.75rem;
            color: #6b7280;
            margin-top: 0.25rem;
        }

        .button-container {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e5e7eb;
        }

        @media (min-width: 640px) {
            .button-container {
                flex-direction: row;
                justify-content: flex-end;
            }
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem 1.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            border-radius: 12px;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease;
            border: none;
        }

        .btn-cancel {
            background: white;
            color: #374151;
            border: 2px solid #d1d5db;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .btn-cancel:hover {
            background: #f9fafb;
            border-color: #9ca3af;
        }

        .btn-primary {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: white;
            box-shadow: 0 4px 14px 0 rgba(37, 99, 235, 0.39);
            padding: 0.75rem 2rem;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
            box-shadow: 0 8px 25px -8px rgba(37, 99, 235, 0.5);
            transform: translateY(-1px);
        }

        .btn-icon {
            width: 1rem;
            height: 1rem;
            margin-right: 0.5rem;
        }

        .select-option {
            padding: 0.5rem;
        }

        /* Animaciones */
        .form-wrapper {
            animation: slideIn 0.5s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .field-group {
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="form-wrapper">
<!-- Header -->
            <div class="header">
                <h1>
                    <svg class="header-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Crear Nuevo Proceso Judicial
                </h1>
                <p>Complete los datos del proceso judicial</p>
            </div>

            <div class="form-content">
<!-- Mensajes de error -->
                <div class="error-container" style="display: none;">
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

                <form action="{{ route('procesos.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

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
                                placeholder="11001-2025-00001-00">
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

                </form>
            </div>
        </div>
    </div>
</body>
</html>

<script>
document.getElementById("formProceso").addEventListener("submit", async function(e) {
    e.preventDefault(); // Evita el refresh

    let form = e.target;
    let url = form.action;
    let formData = new FormData(form);

    try {
        let response = await fetch(url, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
            },
            body: formData
        });

        if (response.ok) {
//  Registro exitoso
            let data = await response.json();
            alert("Proceso creado correctamente ✅");
            form.reset(); // limpiar formulario
        } else if (response.status === 422) {
//  Errores de validación
            let errorData = await response.json();
            let errorContainer = document.getElementById("errorContainer");
            errorContainer.innerHTML = "";

            Object.values(errorData.errors).forEach(msgArray => {
                msgArray.forEach(msg => {
                    let li = document.createElement("div");
                    li.textContent = msg;
                    errorContainer.appendChild(li);
                });
            });
        } else {
            alert("Ocurrió un error inesperado ");
        }
    } catch (error) {
        console.error("Error:", error);
        alert("Error de conexión ");
    }
});
</script>
