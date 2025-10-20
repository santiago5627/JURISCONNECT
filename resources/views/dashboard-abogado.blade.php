<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/abogado.css') }}">

    <div class="dashboard-wrapper">

        <div class="overlay" id="overlay"></div>

        <aside class="sidebar" id="sidebar">
            <div class="profile">
                <!-- Input file oculto para la foto de perfil -->
                <input type="file" id="fileInput" accept="image/jpeg,image/jpg,image/png" style="display: none;">

                <!-- Indicador de carga (oculto por defecto) -->
                <div id="loadingIndicator" style="display: none; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: rgba(0,0,0,0.7); color: white; padding: 10px; border-radius: 5px; z-index: 1000;">
                    Subiendo...
                </div>

                <!-- Contenedor de la foto de perfil -->
                <div class="profile-pic profile-pic-clickable" onclick="document.getElementById('fileInput').click();" title="Haz clic para cambiar tu foto">
                    <img src="{{ Auth::user()->foto_perfil ? asset('storage/' . Auth::user()->foto_perfil) : asset('img/silueta-atardecer-foto-perfil.webp') }}" 
                        id="profileImage" 
                        alt="Foto de perfil">
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
</x-app-layout>