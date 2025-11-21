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

            <!-- Buscador moderno -->
            <div class="search-wrapper">
                <div class="search-group">
                    <input
                        type="text"
                        id="searchInput"
                        class="search-input-modern"
                        placeholder="Buscar por ID, radicado o fecha...">
                    <button id="searchBtn" class="search-button-modern">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>

        </div>

        <!-- Alerta de éxito -->
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
            @include('profile.partials.process-card', ['proceso' => $procesos])
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
    </div>

    <!-- Modal para ver detalles del proceso -->
    <div id="viewProcessModal" class="modal-overlay">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Detalles del Proceso</h2>
                <button class="modal-close" onclick="closeProcessModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div id="processModalBody" class="modal-body"></div>
            <div class="modal-footer">
                <button class="cancel-btn" onclick="closeProcessModal()">Cerrar</button>
            </div>
        </div>
    </div>

    <style>
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
    </style>

    <script>
        function closeAlert(alertId) {
            document.getElementById(alertId).classList.add('hidden');
        }

        // ===== FUNCIONALIDAD DE BÚSQUEDA =====
        let searchTimeout;

        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById("searchInput");
            const searchBtn = document.getElementById("searchBtn");

            if (searchInput) {
                searchInput.addEventListener("input", function() {
                    clearTimeout(searchTimeout);
                    const searchTerm = this.value.trim();
                    searchTimeout = setTimeout(() => performSearch(searchTerm), 300);
                });
            }

            if (searchBtn) {
                searchBtn.addEventListener("click", function() {
                    const searchTerm = document.getElementById("searchInput").value.trim();
                    performSearch(searchTerm);
                });
            }
        });

        function performSearch(searchTerm) {
            const params = new URLSearchParams();
            if (searchTerm) params.append('search', searchTerm);
            params.append('ajax', '1');

            fetch(`${window.location.pathname}?${params.toString()}`, {
                method: 'GET',
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success && data.html) {
                    document.querySelector('.process-grid').innerHTML = data.html;
                }
            });
        }

        // ===== MODAL =====
        function openProcessModal(id) {
            document.getElementById('viewProcessModal').style.display = 'flex';
            const body = document.getElementById('processModalBody');
            body.innerHTML = '<p>Cargando...</p>';

            fetch(`/procesos/${id}`)
                .then(res => res.json())
                .then(data => {
                    body.innerHTML = `
                        <p><strong>Radicado:</strong> ${data.numero_radicado}</p>
                        <p><strong>Tipo:</strong> ${data.tipo_proceso}</p>
                        <p><strong>Demandante:</strong> ${data.demandante}</p>
                        <p><strong>Demandado:</strong> ${data.demandado}</p>
                        <p><strong>Descripción:</strong> ${data.descripcion ?? 'Sin descripción'}</p>

                        <hr>
                        <h3>Conceptos Jurídicos</h3>

                        ${
                            data.conceptos.length === 0
                            ? '<p>No hay conceptos redactados aún.</p>'
                            : data.conceptos.map(c => `
                                <div class="card mb-2" style="padding:10px;border:1px solid #ddd;border-radius:6px;">
                                    <h4>${c.titulo}</h4>
                                    <p>${c.descripcion}</p>
                                    <p><small>Redactado por: ${c.abogado?.name ?? 'Desconocido'}</small></p>
                                </div>
                            `).join('')
                        }
                    `;
                })
                .catch(() => {
                    body.innerHTML = '<p>Error al cargar los datos.</p>';
                });
        }

        function closeProcessModal() {
            document.getElementById('viewProcessModal').style.display = 'none';
        }
    </script>

</body>

</html>
