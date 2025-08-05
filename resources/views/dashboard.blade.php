<x-app-layout>
    <x-slot name="header">
        <!-- Header vacío para evitar conflictos -->
    </x-slot>

    <!-- Meta tag para CSRF token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Contenido sin contenedores restrictivos -->
    <div class="dashboard-wrapper">
        <!-- Overlay para móviles -->
        <div class="overlay" id="overlay"></div>

        <!-- Enlace a CSS -->
        <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

        <!-- Modal para crear nuevo abogado -->
        <div class="modal" id="createLawyerModal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Crear Nuevo Abogado</h2>
                    <button class="modal-close" id="closeModal">&times;</button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('lawyers.store') }}">
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
                        <button type="submit" class="btn-primary">Guardar Cambios</button>
                        <button type="button" class="btn-cancel" id="cancelEditBtn">Cancelar</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="profile">
                <div class="profile-icon">
                    @if(Auth::user()->foto_perfil)
                    <img src="{{ asset('storage/' . Auth::user()->foto_perfil) }}" alt="Foto de perfil" style="width: 80px; height: 80px; border-radius: 50%;">
                    @else
                    <img src="{{ asset('img/default-profile.png') }}" alt="Foto por defecto" style="width: 80px; height: 80px; border-radius: 50%;">
                    @endif
                </div>

            </div>

            <div class="nav-menu">
                <button class="nav-btn">Consultas</button>
                <button class="nav-btn active">Procesos</button>
                <button class="nav-btn">Casos</button>
            </div>

            <div class="sena-logo">
                <img src="{{ asset('img/LogoInsti.png') }}" alt="Logo SENA" width="100" height="100">
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
                    <img src="{{ asset('img/LogoSena_Verde.png') }}" alt="Logo Empresa" width="100px" height="70" class="logo">
                </div>
            </div>

            <div class="content-panel">
                <div class="search-section">
                    <input type="text" class="search-input" placeholder="Buscar por nombre, apellido o numero de documento" id="searchInput">
                    <button class="search-btn" id="searchBtn">Buscar</button>
                </div>

                <div class="action-buttons">
                    <button class="btn-primary" id="createBtn">CREAR NUEVO ABOGADO</button>
                    <a href="{{ route('lawyers.export.excel') }}" class="btn-success">Exportar Excel</a>
                    <a href="{{ route('lawyers.export.pdf') }}" class="btn-danger">Exportar PDF</a>
                </div>

                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Tipo de Documento</th>
                                <th>Numero de Documento</th>
                                <th>Correo</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
<tbody id="tableBody">
    @foreach($lawyers ?? [] as $lawyer)
    <tr data-id="{{ $lawyer->id }}">
        <td>{{ $lawyer->nombre }}</td>
        <td>{{ $lawyer->apellido }}</td>
        <td>{{ $lawyer->tipo_documento }}</td>
        <td>{{ $lawyer->numero_documento }}</td>
        <td>{{ $lawyer->correo }}</td>
        <td>
            <button class="btn-edit"
                data-id="{{ $lawyer->id }}"
                data-nombre="{{ $lawyer->nombre }}"
                data-apellido="{{ $lawyer->apellido }}"
                data-tipo_documento="{{ $lawyer->tipo_documento }}"
                data-numero_documento="{{ $lawyer->numero_documento }}"
                data-correo="{{ $lawyer->correo }}"
                data-telefono="{{ $lawyer->telefono ?? '' }}"
                data-especialidad="{{ $lawyer->especialidad ?? '' }}">
                Editar
            </button>

            <form action="{{ route('lawyers.destroy', $lawyer->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('¿Estás seguro de eliminar este abogado?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-delete">Eliminar</button>
            </form>
        </td>
    </tr>
    @endforeach
</tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    
    <script src="{{ asset('js/dashboard.js') }}"></script>

    <script>
    setInterval(() => {
        fetch('/sanctum/csrf-cookie');
    }, 10 * 60 * 1000); // cada 10 minutos
</script>

</x-app-layout>