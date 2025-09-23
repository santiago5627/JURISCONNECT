<x-app-layout>
    <!-- Página para el dashboard de los administradores -->
    <x-slot name="header">
        <!-- Header vacío para evitar conflictos -->
    </x-slot>

    <!-- Meta tag para CSRF token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Enlace a CSS corregido -->
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

    <!-- Contenido sin contenedores restrictivos -->
    <div class="dashboard-wrapper">

        <!-- Overlay para móviles -->
        <div class="overlay" id="overlay"></div>      

        <!-- Modal para crear nuevo abogado -->
        <div class="modal" id="createLawyerModal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Crear Nuevo Abogado</h2>
                    <button class="modal-close" id="closeModal">&times;</button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('lawyers.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="nombre">Nombre:</label>
                            <input type="text" id="nombre" name="nombre" required>
                        </div>

                        <div class="form-group">
                            <label for="apellido">Apellido:</label>
                            <input type="text" id="apellido" name="apellido" required>
                        </div>

                        <div class="form-group">
                            <label for="tipoDocumento">Tipo de Documento:</label>
                            <select id="tipoDocumento" name="tipoDocumento" required>
                                <option value="">Seleccione...</option>
                                <option value="CC">Cédula de Ciudadanía</option>
                                <option value="CE">Cédula de Extranjería</option>
                                <option value="PAS">Pasaporte</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="numeroDocumento">Número de Documento:</label>
                            <input type="text" id="numeroDocumento" name="numeroDocumento" required>
                        </div>

                        <div class="form-group">
                            <label for="correo">Correo Electrónico:</label>
                            <input type="email" id="correo" name="correo" required>
                        </div>

                        <div class="form-group">
                            <label for="telefono">Teléfono:</label>
                            <input type="tel" id="telefono" name="telefono">
                        </div>

                        <div class="form-group">
                            <label for="especialidad">Especialidad:</label>
                            <input type="text" id="especialidad" name="especialidad" placeholder="Ej: Derecho Civil, Penal, etc.">
                        </div>

                        <div class="form-actions">
                            <button type="button" class="btn-cancel" id="cancelBtn">Cancelar</button>
                            <button type="submit" class="btn-submit">Crear Abogado</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal para editar abogado -->
        <div class="modal" id="editLawyerModal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Editar Abogado</h2>
                    <button class="modal-close" id="closeEditModal">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="editLawyerForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="editNombre">Nombre:</label>
                            <input type="text" id="editNombre" name="nombre" required>
                        </div>

                        <div class="form-group">
                            <label for="editApellido">Apellido:</label>
                            <input type="text" id="editApellido" name="apellido" required>
                        </div>

                        <div class="form-group">
                            <label for="editTipoDocumento">Tipo de Documento:</label>
                            <select id="editTipoDocumento" name="tipoDocumento" required>
                                <option value="">Seleccione...</option>
                                <option value="CC">Cédula de Ciudadanía</option>
                                <option value="CE">Cédula de Extranjería</option>
                                <option value="PAS">Pasaporte</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="editNumeroDocumento">Número de Documento:</label>
                            <input type="text" id="editNumeroDocumento" name="numeroDocumento" required>
                        </div>

                        <div class="form-group">
                            <label for="editCorreo">Correo:</label>
                            <input type="email" id="editCorreo" name="correo" required>
                        </div>

                        <div class="form-group">
                            <label for="editTelefono">Teléfono:</label>
                            <input type="tel" id="editTelefono" name="telefono">
                        </div>

                        <div class="form-group">
                            <label for="editEspecialidad">Especialidad:</label>
                            <input type="text" id="editEspecialidad" name="especialidad">
                        </div>

                        <div class="form-actions">
                            <button type="button" class="btn-cancel" id="cancelEditBtn">Cancelar</button>
                            <button type="submit" class="btn-submit">Guardar Cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="profile">
                <!-- Input file oculto para la foto de perfil -->
                <input type="file" id="fileInput" accept="image/jpeg,image/jpg,image/png" style="display: none;">

                <!-- Contenedor de la foto de perfil -->
                <div class="profile-pic" onclick="document.getElementById('fileInput').click();" title="Haz clic para cambiar tu foto">
                    <img src="{{ Auth::user()->profile_photo ? Storage::url(Auth::user()->profile_photo) : asset('img/Phoenix_Wright_in_Phoenix_Wright_Ace_Attorney.png') }}" 
                        id="profileImage" 
                        alt="Foto de perfil">
                </div>
                <h3>{{ Auth::user()->name }}</h3>
                <p>{{ Auth::user()->email }}</p>
            </div>

            <div class="nav-menu">
                <button class="nav-btn active" data-section="dashboard">
                    📊 Dashboard
                </button>
                <button class="nav-btn" data-section="lawyers">
                    ⚖️ Gestión de Abogados
                </button>
            </div>

            <div class="sena-logo">
                <img src="{{ asset('img/LogoSena_Verde.png') }}" alt="Logo SENA">
            </div>

            <!-- Botón de Cerrar Sesión -->
            <form method="POST" action="{{ route('logout') }}" style="width: 100%;">
                @csrf
                <button type="submit" class="logout-btn">
                    Cerrar Sesión
                </button>
            </form>
        </div>

        <!-- Contenido Principal -->
        <div class="main-content" id="mainContent">
            <div class="header">
                <button class="hamburger" id="hamburgerBtn">☰</button>
                <div class="title-logo-container">
                    <h1 class="title">JustConnect SENA</h1>
                </div>
                <div class="logo-container">
                    <img src="{{ asset('img/LogoSena_Verde.png') }}" alt="Logo Empresa" class="logo">
                </div>
            </div>

            <div class="content-panel">

                <!-- SECCIÓN DASHBOARD PRINCIPAL -->
                <div class="section-content active" id="dashboard-section">
                    <div class="section-header">
                        <h2>📊 Dashboard Principal</h2>
                        <p>Resumen general del sistema JustConnect SENA</p>
                    </div>
                    
                    <div class="dashboard-stats">
                        <div class="stat-card">
                            <div class="stat-icon">👨‍💼</div>
                            <div class="stat-info">
                                <h3>{{ $lawyers->count() ?? 0 }}</h3>
                                <p>Abogados Registrados</p>
                            </div>
                        </div>
                        
                        <div class="stat-card">
                            <div class="stat-icon">📋</div>
                            <div class="stat-info">
                                <h3>{{ $cases_count ?? 0 }}</h3>
                                <p>Casos Activos</p>
                            </div>
                        </div>
                        
                        <div class="stat-card">
                            <div class="stat-icon">✅</div>
                            <div class="stat-info">
                                <h3>{{ $completed_cases ?? 0 }}</h3>
                                <p>Casos Completados</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="dashboard-charts">
                        <div class="chart-container">
                            <h3>Actividad Reciente</h3>
                            <p>Aquí se mostraría un gráfico de actividad reciente</p>
                        </div>
                    </div>
                </div>

                <!-- SECCIÓN GESTIÓN DE ABOGADOS -->
                <div class="section-content" id="lawyers-section">
                    <div class="section-header">
                        <h2>⚖️ Gestión de Abogados</h2>
                        <p>Administrar el registro de abogados del sistema</p>
                    </div>

                    <div class="search-section">
                        <input type="text" class="search-input" placeholder="Buscar por nombre, apellido o número de documento" id="searchInput">
                        <button class="search-btn" id="searchBtn">Buscar</button>
                    </div>

                    <div class="action-buttons">
                        <button class="btn-primary" id="createBtn"> CREAR NUEVO ABOGADO</button>
                        <a href="{{ route('lawyers.export.excel') }}" class="btn-success"> EXPORTAR EXCEL</a>
                        <a href="{{ route('lawyers.export.pdf') }}" class="btn-danger"> EXPORTAR PDF</a>
                    </div>

                    <!-- Incluir la tabla completa -->
    @include('profile.partials.lawyers-table', ['lawyers' => $lawyers])

<!-- SECCIÓN CONFIGURACIÓN -->
                <div class="section-content" id="settings-section">
                    <div class="section-header">
                        <h2> Configuración del Sistema</h2>
                        <p>Configuraciones generales y preferencias</p>
                    </div>
                    
                    <div class="settings-grid">
                        <div class="setting-card">
                            <h3> Configuración General</h3>
                            <div class="setting-item">
                                <label>Nombre del Sistema:</label>
                                <input type="text" value="JustConnect SENA" class="form-control">
                            </div>
                            <div class="setting-item">
                                <label>Email de Contacto:</label>
                                <input type="email" value="admin@justconnect.sena.edu.co" class="form-control">
                            </div>
                        </div>
                        
                        <div class="setting-card">
                            <h3> Notificaciones</h3>
                            <div class="setting-item">
                                <label>
                                    <input type="checkbox" checked> Notificar nuevos registros
                                </label>
                            </div>
                            <div class="setting-item">
                                <label>
                                    <input type="checkbox" checked> Reportes automáticos
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/dash.js') }}"></script>
</x-app-layout>