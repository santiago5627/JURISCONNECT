<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Procesos Pendientes - CSS Puro</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Enlace a CSS corregido -->
    <link rel="stylesheet" href="{{ asset('css/createCon.css') }}">
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
<!-- Header -->
        <div class="header">
            <div class="header-content">
                <h1>Procesos Pendientes de Concepto Jurídico</h1>
                <p>Gestiona los procesos que requieren análisis jurídico</p>
            </div>
            <a class="cancel-btn" href="{{ route('dashboard.abogado') }}">
                <i class="fas fa-arrow-left"></i>
                Cancelar
            </a>
            <!-- busqueda -->
           <div class="search-section">
                    <input type="text" class="search-input" placeholder="Buscar por nombre, apellido o número de radicado" id="searchInput">
                    <button class="search-btn" id="searchBtn">Buscar</button>
                </div>
        </div>

<!-- Alerta de éxito (oculta por defecto) -->
        <div id="success-alert" class="alert alert-success hidden">
            <i class="fas fa-check-circle"></i>
            <span>Operación realizada exitosamente.</span>
            <button class="alert-close" onclick="closeAlert('success-alert')">
                <i class="fas fa-times"></i>
            </button>
        </div>


<!-- Info de procesos pendientes -->
<div class="alert alert-info">
    <i class="fas fa-info-circle"></i>
    <div>
        <p class="font-bold">Procesos Pendientes</p>
        
    </div>
</div>

<!-- Lista de Procesos -->
<div class="process-grid">
    @foreach($procesos as $proceso)
        <div class="process-card fade-in-up">
            <div class="card-header">
                <div class="card-title">
                    <div class="card-title-icon">
                        <i class="fas fa-gavel"></i>
                    </div>
                    <h3>Proceso Legal</h3>
                    <h3>{{ $proceso->id }}</h3>
                </div>
                <span class="status-badge">{{ $proceso->estado }}</span>
            </div>
            <div class="card-body">
                <div class="card-grid">
                    <div class="info-section">
                        <div class="info-item info-item-blue">
                            <div class="info-icon info-icon-blue">
                                <i class="fas fa-hashtag"></i>
                            </div>
                            <div class="info-content">
                                <p>Radicado</p>
                                <p>{{ $proceso->numero_radicado }}</p>
                            </div>
                        </div>
                        <div class="info-item info-item-green">
                            <div class="info-icon info-icon-green">
                                <i class="fas fa-balance-scale"></i>
                            </div>
                            <div class="info-content">
                                <p>Tipo de Proceso</p>
                                <p>{{ $proceso->tipo_proceso }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="info-section">
                        <div class="info-item info-item-orange">
                            <div class="info-icon info-icon-orange">
                                <i class="fas fa-user-plus"></i>
                            </div>
                            <div class="info-content">
                                <p>Demandante</p>
                                <p>{{ $proceso->demandante }}</p>
                            </div>
                        </div>
                        <div class="info-item info-item-red">
                            <div class="info-icon info-icon-red">
                                <i class="fas fa-user-minus"></i>
                            </div>
                            <div class="info-content">
                                <p>Demandado</p>
                                <p>{{ $proceso->demandado }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="info-item info-item-purple">
                        <div class="info-icon info-icon-purple">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div class="info-content">
                            <p>Fecha Radicación</p>
                            <p>{{ $proceso->created_at }}</p>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('abogado.crear-concepto', $proceso->id) }}" class="action-btn">
                        <i class="fas fa-edit"></i>
                        Redactar Concepto Jurídico
                    </a>
                </div>
            </div>
        </div>
    @endforeach
</div>

<!-- Recordatorio -->
        <div class="reminder">
            <div class="reminder-content">
                <div class="reminder-icon">
                    <i class="fas fa-lightbulb"></i>
                </div>
                <div class="reminder-text">
                    <h4>Recordatorio Importante</h4>
                    <p>Los conceptos jurídicos deben ser claros, precisos y fundamentados en la normatividad vigente. Asegúrate de incluir todas las referencias legales pertinentes y un análisis detallado del caso.</p>
                </div>
            </div>
        </div>

<!-- Estado sin procesos (comentado para mostrar la versión con procesos) -->
        <!--  
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <h3>¡Excelente trabajo!</h3>
            <p>No tienes procesos pendientes de concepto jurídico.</p>
            <a href="{{ route('mis.procesos') }}" class="action-btn">
                <i class="fas fa-eye"></i>
                Ver Todos Mis Procesos
            </a>
        </div>
        -->
    </div>

    <script>
        function closeAlert(alertId) {
            document.getElementById(alertId).classList.add('hidden');
        }

        // Ejemplo para mostrar alerta de éxito
        function showSuccessAlert() {
            document.getElementById('success-alert').classList.remove('hidden');
        }
    </script>
</body>
</html>