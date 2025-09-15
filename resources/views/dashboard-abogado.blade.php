<x-app-layout>
    <x-slot name="header">
        </x-slot>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/abogado.css') }}">
    <script src="{{ asset('js/abogado.js') }}" defer></script>

    <div class="dashboard-wrapper">

        <div class="overlay" id="overlay"></div>

        <aside class="sidebar" id="sidebar">
            <div class="profile">
                <div class="profile-pic">
                    <img src="{{ asset('img/sena_logo.png') }}" alt="Perfil">
                </div>
                <h3>{{ Auth::user()->name }}</h3>
                <p>{{ Auth::user()->email }}</p>

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
        border: 3px solid #14c1caff;
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

    /* --- NAV-BTN con 3 colores distintos --- */
    .nav-btn {
        padding: 20px 20px;
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

    .nav-btn:nth-child(1) {
        background: #3498db; /* Azul */
        
    }
    .nav-btn:nth-child(2) {
        background: #27ae60; /* Verde */
    }
    .nav-btn:nth-child(3) {
        background: #e74c3c; /* Rojo */
    }

    .nav-btn:hover,
    .nav-btn.active {
        opacity: 0.9;
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
    /* Main content */
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
        background: #ffffff; /* Fondo blanco */
        padding: 15px;
        border-bottom: 1px solid #ddd;
    }

    .header h1 {
        font-family: 'Georgia', serif; /* Tipografía elegante */
        font-size: 24px;
        font-weight: bold;
        color: #2c3e50; /* Azul oscuro */
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
    background: #fff;                /* Fondo blanco */
    border-radius: 10px;             /* Bordes redondeados */
    padding: 20px;                   /* Espaciado interno */
    margin: 20px;                    /* Separación hacia fuera */
    box-shadow: 0 2px 6px rgba(0,0,0,0.1); /* Sombra suave */
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
        background-color: #2e7d64ff;
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
                <h1>PANEL DE ABOGADO</h1>
                <img src="{{ asset('img/LogoSena_Verde.png') }}" alt="Logo" width="80">
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
        overlay.addEventListener('click', () => {Ingresar       
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
        });
    </script>

 <!-- Scripts -->
    <script src="{{ asset('js/dash.js') }}"></script>

</x-app-layout>