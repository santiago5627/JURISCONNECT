<x-app-layout>
    <x-slot name="header">
        <!-- Header vacío para evitar conflictos -->
    </x-slot>

    <!-- Contenido sin contenedores restrictivos -->
    <div class="dashboard-wrapper">
        <!-- Overlay para móviles -->
        <div class="overlay" id="overlay"></div>

        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="profile">
                <div class="profile-icon">👤</div>
                <h3>{{ Auth::user()->name }}</h3>
                <p>{{ Auth::user()->email }}</p>
            </div>

            <div class="nav-menu">
                <button class="nav-btn">Consultas</button>
                <button class="nav-btn active">Procesos</button>
                <button class="nav-btn">Casos</button>
                
                <!-- Botón de Cerrar Sesión -->
                <form method="POST" action="{{ route('logout') }}" style="width: 100%;">
                    @csrf
                    <button type="submit" class="logout-btn">
                        Cerrar Sesión
                    </button>
                </form>
            </div>

            <div class="sena-logo">
                <img src="{{ asset('img/LogoSena_Verde.png') }}" alt="Logo SENA" width="100" height="100">
            </div>
        </div>

        <!-- Contenido Principal -->
        <div class="main-content" id="mainContent">
            <div class="header">
                <button class="hamburger" id="hamburgerBtn">☰</button>

                <div class="title-logo-container">
                    <h1 class="title">JustConnect SENA</h1>
                </div>
                
                <div class="logo-container">
                    <img src="{{ asset('img/LogoInsti.png') }}" alt="Logo Empresa" width="100px" height="70" class="logo">
                </div>
            </div>

            <div class="content-panel">
                <div class="search-section">
                    <input type="text" class="search-input" placeholder="Buscar por nombre, apellido o numero de documento" id="searchInput">
                    <button class="search-btn" id="searchBtn">Buscar</button>
                </div>

                <div class="action-buttons">
                    <button class="btn-primary" id="createBtn">CREAR NUEVO ABOGADO</button>
                    <button class="btn-success" id="exportBtn">EXPORTAR EXCEL</button>
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
                            <tr>
                                <td>Sara</td>
                                <td>Vega</td>
                                <td>CC</td>
                                <td>231231</td>
                                <td>sara564@gmail.com</td>
                                <td>
                                    <button class="btn-edit">Editar</button>
                                    <button class="btn-delete">Eliminar</button>
                                </td>
                            </tr>
                            <tr>
                                <td>Angel</td>
                                <td>Angarita</td>
                                <td>CC</td>
                                <td>21231231</td>
                                <td>angel245@gmail.com</td>
                                <td>
                                    <button class="btn-edit">Editar</button>
                                    <button class="btn-delete">Eliminar</button>
                                </td>
                            </tr>
                            <tr>
                                <td>Wilson</td>
                                <td>Zuluaga</td>
                                <td>CC</td>
                                <td>156156456</td>
                                <td>Willa564@gmail.com</td>
                                <td>
                                    <button class="btn-edit">Editar</button>
                                    <button class="btn-delete">Eliminar</button>
                                </td>
                            </tr>
                            <tr>
                                <td>Brenda</td>
                                <td>Mondragón</td>
                                <td>PS</td>
                                <td>454564</td>
                                <td>Brendaara564@gmail.com</td>
                                <td>
                                    <button class="btn-edit">Editar</button>
                                    <button class="btn-delete">Eliminar</button>
                                </td>
                            </tr>
                            <tr>
                                <td>Alison</td>
                                <td>Rojas</td>
                                <td>TI</td>
                                <td>156465</td>
                                <td>Alisosson21@gmail.com</td>
                                <td>
                                    <button class="btn-edit">Editar</button>
                                    <button class="btn-delete">Eliminar</button>
                                </td>
                            </tr>
                            <tr>
                                <td>Pablo</td>
                                <td>Aleman</td>
                                <td>TI</td>
                                <td>15845564</td>
                                <td>Pablo44@gmail.com</td>
                                <td>
                                    <button class="btn-edit">Editar</button>
                                    <button class="btn-delete">Eliminar</button>
                                </td>
                            </tr>
                            <tr>
                                <td>Andres</td>
                                <td>Barco</td>
                                <td>CC</td>
                                <td>1564564</td>
                                <td>Andres123@gmail.com</td>
                                <td>
                                    <button class="btn-edit">Editar</button>
                                    <button class="btn-delete">Eliminar</button>
                                </td>
                            </tr>
                            <tr>
                                <td>Juan</td>
                                <td>Forero</td>
                                <td>TI</td>
                                <td>54564654</td>
                                <td>Juan54@gmail.com</td>
                                <td>
                                    <button class="btn-edit">Editar</button>
                                    <button class="btn-delete">Eliminar</button>
                                </td>
                            </tr>
                            <tr>
                                <td>Santiago</td>
                                <td>Salsedo</td>
                                <td>CC</td>
                                <td>51564564</td>
                                <td>Santiago51@gmail.com</td>
                                <td>
                                    <button class="btn-edit">Editar</button>
                                    <button class="btn-delete">Eliminar</button>
                                </td>
                            </tr>
                            <tr>
                                <td>Daniel</td>
                                <td>Higuera</td>
                                <td>CC</td>
                                <td>5454564</td>
                                <td>Daniel54@gmail.com</td>
                                <td>
                                    <button class="btn-edit">Editar</button>
                                    <button class="btn-delete">Eliminar</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* RESET COMPLETO para evitar conflictos con Laravel */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Remover estilos de Laravel que limitan el ancho */
        .max-w-7xl,
        .container,
        .mx-auto {
            max-width: none !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        /* Forzar pantalla completa */
        html, body {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            overflow-x: hidden;
        }

        #app {
            width: 100vw;
            height: 100vh;
            margin: 0;
            padding: 0;
        }

        /* Wrapper principal */
        .dashboard-wrapper {
            width: 100vw;
            height: 100vh;
            position: relative;
            font-family: 'Arial', sans-serif;
            background: #ffffff;
            overflow: hidden;
        }

        /* SIDEBAR */
        .sidebar {
            width: 280px;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            background: #f2f7f2;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            padding: 20px 15px;
            z-index: 1000;
            transition: transform 0.3s ease-in-out;
            transform: translateX(-100%);
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
        }

        .sidebar.active {
            transform: translateX(0);
        }

        .profile {
            text-align: center;
            margin-bottom: 30px;
            margin-top: 20px;
        }

        .profile-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            border: 3px solid #145A32;
            margin: 0 auto 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: #1D1D1D;
        }

        .profile h3,
        .profile p {
            color: #1D1D1D;
            margin: 5px 0;
        }

        .nav-menu {
            display: flex;
            flex-direction: column;
            gap: 20px;
            margin-bottom: auto;
            padding: 10px 0;
            width: 100%;
            margin-top: 30px;
        }

        .nav-btn {
            padding: 12px 20px;
            background: #39A900;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
            transition: background 0.3s;
            width: 100%;
            height: 50px;
            cursor: pointer;
        }

        .nav-btn:hover,
        .nav-btn.active {
            background: #145A32;
        }

        .logout-btn {
            padding: 12px 20px;
            background: #C0392B;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
            transition: background 0.3s;
            width: 100%;
            height: 50px;
            cursor: pointer;
            margin-top: 20px;
        }

        .logout-btn:hover {
            background: #A93226;
        }

        .sena-logo {
            text-align: center;
            margin-top: auto;
            padding: 20px 0;
        }

        .sena-logo img {
            width: 80px;
            height: auto;
        }

        /* CONTENIDO PRINCIPAL */
        .main-content {
            width: 100vw;
            height: 100vh;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #39A900;
            padding: 15px 30px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
            min-height: 80px;
            flex-shrink: 0;
        }

        .hamburger {
            background: none;
            border: none;
            color: white;
            font-size: 26px;
            cursor: pointer;
            display: block;
            padding: 10px;
        }

        .title-logo-container {
            display: flex;
            align-items: center;
            flex: 1;
            justify-content: center;
        }

        .title {
            color: white;
            font-size: 26px;
            font-weight: bold;
            text-transform: uppercase;
            font-family: 'Georgia', serif;
            letter-spacing: 1px;
            margin: 0;
        }

        .logo-container {
            display: flex;
            align-items: center;
        }

        .logo-container img {
            height: 50px;
            width: auto;
        }

        /* PANEL DE CONTENIDO */
        .content-panel {
            flex: 1;
            background: #ffffff;
            margin: 20px;
            border: 2px solid #1D6D32;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
        }

        .search-section {
            margin-bottom: 25px;
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .search-input {
            flex: 1;
            padding: 12px 15px;
            border: 2px solid #145A32;
            border-radius: 5px;
            font-size: 14px;
            outline: none;
        }

        .search-input:focus {
            border-color: #39A900;
        }

        .search-btn {
            padding: 12px 25px;
            background: #1D6D32;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            font-size: 14px;
            transition: background 0.3s;
        }

        .search-btn:hover {
            background: #145A32;
        }

        .action-buttons {
            display: flex;
            gap: 15px;
            margin-bottom: 25px;
        }

        .btn-primary {
            padding: 12px 25px;
            background: #DFF1E2;
            color: #1D1D1D;
            border: 2px solid #1D6D32;
            border-radius: 5px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-primary:hover {
            background: #C8E6CA;
        }

        .btn-success {
            padding: 12px 25px;
            background: #26b139;
            color: #ffffff;
            border: 2px solid #1D6D32;
            border-radius: 5px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-success:hover {
            background: #1D6D32;
        }

        /* TABLA */
        .table-container {
            overflow-x: auto;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th {
            background: #39A900;
            color: #ffffff;
            padding: 15px 12px;
            text-align: left;
            font-weight: bold;
            font-size: 14px;
            border-bottom: 2px solid #1D6D32;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            color: #1D1D1D;
            background-color: #E9F6ED;
            font-size: 13px;
        }

        tr:nth-child(even) td {
            background-color: #DFF1E2;
        }

        tr:hover td {
            background: #C8E6CA;
        }

        .btn-edit {
            background: #228B22;
            color: #ffffff;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 11px;
            border: none;
            margin-right: 5px;
            transition: background 0.3s;
        }

        .btn-edit:hover {
            background: #1D6D32;
        }

        .btn-delete {
            background: #C0392B;
            color: #ffffff;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 11px;
            border: none;
            transition: background 0.3s;
        }

        .btn-delete:hover {
            background: #A93226;
        }

        /* Overlay para móviles */
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            display: none;
        }

        .overlay.active {
            display: block;
        }

        /* RESPONSIVE DESIGN */
        @media (max-width: 768px) {
            .main-content {
                width: 100vw;
            }

            .content-panel {
                margin: 10px;
                padding: 15px;
            }

            .header {
                padding: 10px 15px;
                min-height: 60px;
            }

            .title {
                font-size: 18px;
            }

            .search-section {
                flex-direction: column;
                gap: 10px;
            }

            .action-buttons {
                flex-direction: column;
                width: 100%;
            }

            .btn-primary,
            .btn-success {
                width: 100%;
                text-align: center;
            }

            .table-container {
                overflow-x: auto;
            }

            table {
                font-size: 12px;
                min-width: 600px;
            }

            th,
            td {
                padding: 8px 6px;
                font-size: 11px;
            }

            .btn-edit,
            .btn-delete {
                padding: 4px 8px;
                font-size: 10px;
            }
        }

        @media (max-width: 480px) {
            .sidebar {
                width: 90vw;
                max-width: 300px;
            }

            .title {
                font-size: 16px;
            }

            .search-input {
                font-size: 16px; /* Evita zoom en iOS */
            }

            .content-panel {
                margin: 5px;
                padding: 10px;
            }

            th,
            td {
                padding: 6px 4px;
                font-size: 10px;
            }

            .btn-edit,
            .btn-delete {
                padding: 3px 6px;
                font-size: 9px;
            }
        }
    </style>

    <script>
        // Variables principales
        const hamburgerBtn = document.getElementById('hamburgerBtn');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const mainContent = document.getElementById('mainContent');

        // Función para alternar el sidebar
        function toggleSidebar() {
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        }

        // Función para cerrar el sidebar
        function closeSidebar() {
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
        }

        // Event listeners para el hamburger y overlay
        hamburgerBtn.addEventListener('click', toggleSidebar);
        overlay.addEventListener('click', closeSidebar);

        // Cerrar sidebar con ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeSidebar();
            }
        });

        // Funcionalidad de navegación
        document.querySelectorAll('.nav-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.nav-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                
                // Cerrar sidebar después de seleccionar
                closeSidebar();
            });
        });

        // Funcionalidad del buscador
        document.getElementById('searchBtn').addEventListener('click', function() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            filterTable(searchTerm);
        });

        // Búsqueda en tiempo real
        document.getElementById('searchInput').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            filterTable(searchTerm);
        });

        // Función para filtrar tabla
        function filterTable(searchTerm) {
            const rows = document.querySelectorAll('#tableBody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        // Funcionalidad de botones de acción
        document.querySelectorAll('.btn-edit').forEach(btn => {
            btn.addEventListener('click', function() {
                alert('Función de editar - En desarrollo');
            });
        });

        document.querySelectorAll('.btn-delete').forEach(btn => {
            btn.addEventListener('click', function() {
                if (confirm('¿Estás seguro de que deseas eliminar este registro?')) {
                    this.closest('tr').remove();
                }
            });
        });

        document.getElementById('createBtn').addEventListener('click', function() {
            alert('Crear nuevo abogado - En desarrollo');
        });

        document.getElementById('exportBtn').addEventListener('click', function() {
            alert('Exportar a Excel - En desarrollo');
        });

        // Prevenir zoom en iOS para inputs
        if (/iPad|iPhone|iPod/.test(navigator.userAgent)) {
            document.querySelectorAll('input').forEach(input => {
                input.addEventListener('focus', function() {
                    this.style.fontSize = '16px';
                });
            });
        }

        // Ajustar altura en redimensionamiento
        window.addEventListener('resize', function() {
            // Mantener funcionalidad responsive
        });
    </script>
</x-app-layout>