<!DOCTYPE html>
<html lang="es"> 
<head><!-- pagina para ver que procesos tiene pendiente para concepto  -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Procesos Pendientes - CSS Puro</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Enlace a CSS corregido -->
    <link rel="stylesheet" href="{{ asset('css/editCon.css') }}">
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
                    <input type="text" class="search-input" placeholder="Buscar por id, numero de radicado o fecha de creacion" id="searchInput">
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
    @forelse($procesos as $proceso)
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
    @empty
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <h3>No se encontraron procesos pendientes.</h3>
        </div>
    @endforelse
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

        // ===== FUNCIONALIDAD DE BÚSQUEDA AJAX =====
// Búsqueda en tiempo real simplificada
let searchTimeout;

document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById("searchInput");

    if (searchInput) {
        // Búsqueda en tiempo real mientras escribes
        searchInput.addEventListener("input", function() {
            clearTimeout(searchTimeout);
            const searchTerm = this.value.trim();

            searchTimeout = setTimeout(() => {
                performSearch(searchTerm);
            }, 300); // Esperar 300ms después de escribir
        });
    }
});


// Función principal de búsqueda
function performSearch(searchTerm) {
    // Preparar parámetros
    const params = new URLSearchParams();
    if (searchTerm) {
        params.append('search', searchTerm);
    }
    params.append('ajax', '1');

    // Hacer petición AJAX
    fetch(`${window.location.pathname}?${params.toString()}`, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && data.html) {
            // Actualizar tabla
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = data.html;

            const newTableBody = tempDiv.querySelector('#tableBody');
            const currentTableBody = document.querySelector('#tableBody');

            if (newTableBody && currentTableBody) {
                currentTableBody.innerHTML = newTableBody.innerHTML;
            }

            // Actualizar paginación si existe
            const newPagination = tempDiv.querySelector('.pagination');
            const currentPagination = document.querySelector('.pagination')?.parentElement;
            if (currentPagination) {
                if (newPagination) {
                    currentPagination.innerHTML = newPagination.parentElement.innerHTML;
                } else {
                    currentPagination.innerHTML = '';
                }
            }

            // Actualizar URL
            const newUrl = new URL(window.location);
            if (searchTerm) {
                newUrl.searchParams.set('search', searchTerm);
            } else {
                newUrl.searchParams.delete('search');
            }
            newUrl.searchParams.delete('page');
            window.history.replaceState({}, '', newUrl.toString());
        }
    })
    .catch(error => {
        console.error('Error en búsqueda:', error);
    });
}

// Función para limpiar búsqueda (opcional)
function clearSearch() {
    document.getElementById("searchInput").value = '';
    performSearch('');
}
    </script>
</body>
</html>
