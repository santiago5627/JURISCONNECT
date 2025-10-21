<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/procesos_judiciales.css') }}">
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
            </div>
        </div>

        <div class="table-container">
            <div class="table-wrapper">
                <table class="process-table">
                    <thead class="table-header">
                        <tr>
                            <th>
                                <div class="header-content-cell">
                                    <span>Radicado</span>
                                    <svg class="header-icon-small" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                            </th>
                            <th>
                                <div class="header-content-cell">
                                    <span>Tipo</span>
                                    <svg class="header-icon-small" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                </div>
                            </th>
                            <th>
                                <div class="header-content-cell">
                                    <span>Demandante</span>
                                    <svg class="header-icon-small header-icon-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                            </th>
                            <th>
                                <div class="header-content-cell">
                                    <span>Demandado</span>
                                    <svg class="header-icon-small header-icon-red" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                            </th>
                            <th class="actions-cell">
                                <div class="header-content-cell" style="justify-content: center;">
                                    <span>Acciones</span>
                                    <svg class="header-icon-small" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                                    </svg>
                                </div>
                            </th>
                        </tr>
                    </thead>

                    <tbody class="table-body">
                        @forelse($procesos as $proceso)
                            <tr>
                                <td>{{ $proceso->numero_radicado }}</td>
                                <td><span class="type-badge type-civil">{{ $proceso->tipo_proceso }}</span></td>
                                <td>{{ $proceso->demandante }}</td>
                                <td>{{ $proceso->demandado }}</td>
                                <td class="actions-cell">
                                    <div class="actions-group">
                                        <a href="javascript:void(0);" onclick="openProcessModal({{ $proceso->id }})" class="action-btn action-view" title="Ver detalles">
                                            <svg class="action-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>

                                        <a href="{{ route('procesos.edit', $proceso->id) }}" class="action-btn action-edit" title="Editar">
                                            <svg class="action-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>

                        <form id="delete-form-{{ $proceso->id }}" action="{{ route('procesos.destroy', $proceso->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                                <button type="button" class="delete-btn" onclick="confirmDelete('{{ $proceso->id }}', '{{ $proceso->demandante }}')">🗑</button>

                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 2rem; color: #9ca3af;">No hay procesos registrados</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
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