<x-app-layout>
    <x-slot name="header">
        <!-- Evitamos encabezado extra -->
    </x-slot>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Contenedor principal -->
    <div class="dashboard-wrapper">

        <!-- Overlay para móviles -->
        <div class="overlay" id="overlay"></div>

        <!-- Estilos -->
        <style>
            body {
                margin: 0;
                font-family: Arial, sans-serif;
                background-color: #f4f6f7;
            }
            .dashboard-wrapper {
                display: flex;
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
                box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
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
                padding: 50px 0;
                width: 100%;
                margin-top: 85px;
            }

            .nav-btn {
                padding: 20px 20px;
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
                display: flex;
                align-items: center;
                justify-content: center;
                width: 100%;
                margin-top: auto;
                padding: 50px;
            }

            .sena-logo img {
                width: 80px;
                height: auto;
            }
            /* Main content - Ahora ocupa toda la pantalla por defecto */
            .main-content {
                flex: 1;
                width: 100%;
                margin-left: 0;
                padding: 20px;
                transition: margin-left 0.3s ease;
            }
            
            .header {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
            
            .hamburger {
                font-size: 24px;
                background: none;
                border: none;
                color: #2e7d32;
                cursor: pointer;
                margin-right: 10px;
            }
            
            .content-panel {
                margin-top: 20px;
            }
            
            .cards-container {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                gap: 20px;
            }
            
            .dashboard-card {
                background: white;
                padding: 20px;
                border-radius: 10px;
                box-shadow: 0 2px 5px rgba(0,0,0,0.1);
                text-align: center;
            }
            
            .dashboard-card h3 {
                margin-bottom: 10px;
            }
            
            .dashboard-card a {
                display: inline-block;
                margin-top: 10px;
                padding: 8px 15px;
                background-color: #2e7d32;
                color: white;
                border-radius: 5px;
                text-decoration: none;
            }
            
            .dashboard-card a:hover {
                background-color: #1b5e20;
            }
            
            /* Overlay para móviles */
            .overlay {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0,0,0,0.3);
                display: none;
                z-index: 500;
            }
            
            .overlay.active {
                display: block;
            }
            
            /* Media queries */
            @media (max-width: 768px) {
                .main-content {
                    margin-left: 0;
                }
            }
        </style>

        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="profile">
                <input type="file" id="fileInput" accept="image/*" hidden>
                <div class="profile-pic" onclick="document.getElementById('fileInput').click();">
                    <img src="{{ asset('img/sena_logo.png') }}" alt="Perfil" width="100px" height="70" class="logo">
                </div>
                <h3>{{ Auth::user()->name }}</h3>
                <p>{{ Auth::user()->email }}</p>
            </div>
            <div class="nav-menu">
                <!-- Aquí puedes agregar botones de navegación si los necesitas -->
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

        <!-- Contenido -->
        <div class="main-content" id="mainContent">
            <div class="header">
                <button class="hamburger" id="hamburgerBtn">☰</button>
                <h1>Panel del Abogado</h1>
                <img src="{{ asset('img/LogoSena_Verde.png') }}" alt="Logo" width="80">
            </div>

            <div class="content-panel">
                <p>Bienvenido, <strong>{{ Auth::user()->name }}</strong>. Este es tu panel de abogado.</p>

                <div class="cards-container">
                    <div class="dashboard-card">
                        <h3>Registrar Proceso</h3>
                        <p>Agrega un nuevo proceso jurídico al sistema.</p>
                        <a href="{{ route('legal_processes.create') }}">Registrar</a>
                    </div>

                    <div class="dashboard-card">
                        <h3>Mis Procesos</h3>
                        <p>Consulta y actualiza tus procesos asignados.</p>
                        <a href="{{ route('mis.procesos') }}">Ver procesos</a>
                    </div>

                    <div class="dashboard-card">
                        <h3>Conceptos Jurídicos</h3>
                        <p>Emite nuevos conceptos y clasifícalos por tema.</p>
                        <a href="{{ route('conceptos.create') }}" class="btn btn-success">Emitir</a>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script hamburguesa -->
    <script>
        const hamburgerBtn = document.getElementById('hamburgerBtn');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const mainContent = document.getElementById('mainContent');

        // Función para alternar el sidebar
        function toggleSidebar() {
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        }
        overlay.addEventListener('click', () => {
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
        });
    </script>
</x-app-layout>