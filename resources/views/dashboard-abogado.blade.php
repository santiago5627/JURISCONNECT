<x-app-layout>
    <x-slot name="header">
        </x-slot>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* CSS Variables para un manejo de tema más sencillo */
        :root {
            --primary-color: #28a745;
            --primary-dark-color: #218838;
            --danger-color: #dc3545;
            --danger-dark-color: #c82333;
            --background-color: #f8f9fa;
            --sidebar-bg: #ffffff;
            --text-color: #343a40;
            --text-muted-color: #6c757d;
            --card-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            --transition-speed: 0.3s;
        }

        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-color: var(--background-color);
            color: var(--text-color);
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .dashboard-wrapper {
            display: flex;
        }

        /* ------------------- */
        /* --- SIDEBAR --- */
        /* ------------------- */
        .sidebar {
            width: 260px;
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            background: var(--sidebar-bg);
            display: flex;
            flex-direction: column;
            padding: 20px;
            z-index: 1000;
            transition: transform var(--transition-speed) ease;
            transform: translateX(-100%);
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.05);
            box-sizing: border-box;
        }

        .sidebar.active {
            transform: translateX(0);
        }

        .profile {
            text-align: center;
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 1px solid #e9ecef;
        }
        
        .profile-pic img {
            width: 90px;
            height: auto;
            margin-bottom: 15px;
        }

        .profile h3 {
            margin: 10px 0 5px;
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--text-color);
        }

        .profile p {
            margin: 0;
            font-size: 0.85rem;
            color: var(--text-muted-color);
        }

        .nav-menu {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 20px;
        }
        
        /* Placeholder para futuros botones de navegación */
        .nav-btn {
            padding: 15px 20px;
            background: transparent;
            color: var(--text-muted-color);
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 500;
            transition: background var(--transition-speed), color var(--transition-speed);
            width: 100%;
            text-align: left;
            cursor: pointer;
        }

        .nav-btn:hover,
        .nav-btn.active {
            background: rgba(40, 167, 69, 0.1);
            color: var(--primary-dark-color);
        }

        .sidebar-footer {
            margin-top: auto;
            text-align: center;
        }

        .sena-logo img {
            width: 70px;
            opacity: 0.7;
            margin-bottom: 20px;
        }

        .logout-btn {
            width: 100%;
            padding: 12px 20px;
            background: var(--danger-color);
            color: #ffffff;
            border: none;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 600;
            text-transform: uppercase;
            cursor: pointer;
            transition: background var(--transition-speed);
        }

        .logout-btn:hover {
            background: var(--danger-dark-color);
        }

        /* ------------------------- */
        /* --- MAIN CONTENT --- */
        /* ------------------------- */
        .main-content {
            flex-grow: 1;
            padding: 25px;
            transition: margin-left var(--transition-speed) ease;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #fff;
            padding: 15px 25px;
            border-radius: 12px;
            box-shadow: var(--card-shadow);
            margin-bottom: 30px;
        }
        
        .header-left {
            display: flex;
            align-items: center;
        }

        .hamburger {
            font-size: 28px;
            background: none;
            border: none;
            color: var(--primary-color);
            cursor: pointer;
            margin-right: 20px;
        }

        .header h1 {
            font-size: 1.8rem;
            font-weight: 600;
            margin: 0;
            color: var(--text-color);
        }
        
        .header img {
            height: 45px; /* Altura unificada */
            width: auto;
        }
        
        .content-panel .welcome-message {
            font-size: 1.1rem;
            color: var(--text-muted-color);
            margin-bottom: 30px;
        }
        
        .welcome-message strong {
            color: var(--primary-dark-color);
            font-weight: 600;
        }

        .cards-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
        }

        .dashboard-card {
            background: #ffffff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: var(--card-shadow);
            text-align: center;
            transition: transform var(--transition-speed), box-shadow var(--transition-speed);
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
        }

        .card-icon {
            font-size: 2.5rem;
            margin-bottom: 15px;
            color: var(--primary-color);
        }

        .dashboard-card h3 {
            margin-top: 0;
            margin-bottom: 10px;
            font-size: 1.25rem;
            font-weight: 600;
        }

        .dashboard-card p {
            color: var(--text-muted-color);
            font-size: 0.95rem;
            line-height: 1.5;
            min-height: 50px; /* Para alinear botones */
        }

        .dashboard-card a {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 25px;
            background-color: var(--primary-color);
            color: white;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: background-color var(--transition-speed);
        }

        .dashboard-card a:hover {
            background-color: var(--primary-dark-color);
        }

        /* ------------------- */
        /* --- OVERLAY --- */
        /* ------------------- */
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
            display: none;
            z-index: 999; /* Debajo del sidebar */
            opacity: 0;
            transition: opacity var(--transition-speed) ease;
        }

        .overlay.active {
            display: block;
            opacity: 1;
        }

        /* ------------------------- */
        /* --- RESPONSIVENESS --- */
        /* ------------------------- */
        @media (max-width: 768px) {
            .sidebar {
                box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            }
            .header h1 {
                font-size: 1.4rem;
            }
        }
        
    </style>

    <div class="dashboard-wrapper">

        <div class="overlay" id="overlay"></div>

        <aside class="sidebar" id="sidebar">
            <div class="profile">
                <div class="profile-pic">
                    <img src="{{ asset('img/sena_logo.png') }}" alt="Perfil">
                </div>
                <h3>{{ Auth::user()->name }}</h3>
                <p>{{ Auth::user()->email }}</p>
            </div>
            
            <nav class="nav-menu">
                </nav>

            <div class="sidebar-footer">
                <div class="sena-logo">
                    <img src="{{ asset('img/LogoInsti.png') }}" alt="Logo SENA">
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn">
                        Cerrar Sesión
                    </button>
                </form>
            </div>
        </aside>

        <main class="main-content" id="mainContent">
            <header class="header">
                <div class="header-left">
                    <button class="hamburger" id="hamburgerBtn">☰</button>
                    <h1>Panel del Abogado</h1>
                </div>
                <img src="{{ asset('img/LogoSena_Verde.png') }}" alt="Logo Sena Verde">
            </header>

            <div class="content-panel">
                <p class="welcome-message">Bienvenido, <strong>{{ Auth::user()->name }}</strong>. Gestiona tus procesos y conceptos jurídicos desde aquí.</p>

                <div class="cards-container">
                    <div class="dashboard-card">
                        <div class="card-icon">⚖️</div>
                        <h3>Registrar Proceso</h3>
                        <p>Inicia un nuevo expediente jurídico y asígnale los detalles correspondientes en el sistema.</p>
                        <a href="{{ route('legal_processes.create') }}">Registrar</a>
                    </div>

                    <div class="dashboard-card">
                        <div class="card-icon">📂</div>
                        <h3>Mis Procesos</h3>
                        <p>Consulta, actualiza y da seguimiento a todos los procesos jurídicos que tienes asignados.</p>
                        <a href="{{ route('mis.procesos') }}">Ver Procesos</a>
                    </div>

                    <div class="dashboard-card">
                        <div class="card-icon">✍️</div>
                        <h3>Conceptos Jurídicos</h3>
                        <p>Emite, clasifica y gestiona los conceptos jurídicos para mantener un registro organizado.</p>
                        <a href="{{ route('conceptos.create') }}">Ver Conceptos</a>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        const hamburgerBtn = document.getElementById('hamburgerBtn');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');

        // Función para abrir/cerrar el menú
        function toggleSidebar() {
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        }

        // Función para cerrar el menú (usado por el overlay)
        function closeSidebar() {
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
        }
        
        // Asignar eventos solo si los elementos existen
        if (hamburgerBtn && sidebar && overlay) {
            hamburgerBtn.addEventListener('click', toggleSidebar);
            overlay.addEventListener('click', closeSidebar); // Ahora solo cierra, que es más intuitivo
        }
    </script>

</x-app-layout>