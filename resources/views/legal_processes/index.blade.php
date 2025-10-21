<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <title>Procesos Judiciales</title>
</head>
<body>
    <div id="viewProcessModal" class="modal">
        <div class="modal-content">
            <span class="close-button" onclick="closeProcessModal()">&times;</span>
            <h2 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1rem;">Datos del Proceso</h2>
            <div id="processModalBody">
                <p>Cargando datos...</p>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="main-header">
            <div class="header-content">
                <div class="header-left">
                    <div class="header-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div class="header-text">
                        <h1>Procesos Judiciales</h1>
                        <p>Gestión integral de casos legales</p>
                    </div>
                </div>
                <div class="header-stats">
                    <span class="stats-label">Total:</span>
                    <span class="stats-value">{{ count($procesos) }}</span>
                </div>
            </div>

            <div class="actions-bar">
                <div class="actions-content">
                    <div class="info-text">
                        <svg class="info-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Administre sus procesos judiciales desde esta vista</span>
                    </div>
                    
                    <div class="button-group">
                        <a href="{{ route('dashboard.abogado') }}" class="btn btn-secondary">
                            <svg class="btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Volver al Dashboard
                        </a>
                        
                        <a href="{{ route('procesos.create') }}" class="btn btn-primary">
                            <svg class="btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Nuevo Proceso
                        </a>
                    </div>
                </div>
                <div class="search-section">
                    <input type="text" id="searchInput" class="form-control mb-3" placeholder="Buscar por nombre, apellido o número de radicado" >
                    <button class="search-btn" id="searchBtn">Buscar</button>
                </div>
            </div>
        </div>
    <!-- Incluir la tabla completa -->
    @include('profile.partials.processes-table', ['proceso' => $procesos])
    </div>

    <script>
        function openProcessModal(id) {
            document.getElementById('viewProcessModal').style.display = 'flex';
            const body = document.getElementById('processModalBody');
            body.innerHTML = '<p>Cargando datos...</p>';

            fetch(`/procesos/${id}`)
                .then(res => res.json())
                .then(data => {
                    body.innerHTML = `
                        <p><strong>Radicado:</strong> ${data.numero_radicado}</p>
                        <p><strong>Tipo:</strong> ${data.tipo_proceso}</p>
                        <p><strong>Demandante:</strong> ${data.demandante}</p>
                        <p><strong>Demandado:</strong> ${data.demandado}</p>
                        <p><strong>Descripción:</strong> ${data.descripcion ?? 'Sin descripción'}</p>
                    `;
                }) 
                .catch(() => {
                    body.innerHTML = '<p>Error al cargar los datos.</p>';
                });
        }

        function closeProcessModal() {
        document.getElementById('viewProcessModal').style.display = 'none';
        }

        //  Cerrar modal con la tecla ESC
        document.addEventListener('keydown', function(event) {
        const modal = document.getElementById('viewProcessModal');
        if (event.key === 'Escape' && modal.style.display === 'flex') {
            closeProcessModal();
        }
        });

        function confirmDelete(id, nombre) {
        Swal.fire({
            title: 'Confirmar Eliminación',
            html: `¿Estás seguro de eliminar el proceso de <b>${nombre}</b>?<br>Esta acción no se puede deshacer.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Eliminar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true,
            customClass: {
                popup: 'custom-popup',
                title: 'custom-title',
                htmlContainer: 'custom-text',
                confirmButton: 'custom-confirm',
                cancelButton: 'custom-cancel',
                icon: 'custom-icon'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`delete-form-${id}`).submit();
            }
        });
    }

    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>
</html>