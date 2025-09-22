<!DOCTYPE html>
<html lang="es"> <!-- pagina para ver los procesos asignados al abogado -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Procesos Judiciales</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #e0f2fe 50%, #e8eaf6 100%);
            min-height: 100vh;
            line-height: 1.6;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 3rem 1rem;
        }

        /* Header Principal */
        .main-header {
            background: white;
            border-radius: 20px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .header-content {
            background: linear-gradient(135deg, #1e293b 0%, #334155 50%, #0f172a 100%);
            padding: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .header-icon {
            background: #3b82f6;
            padding: 0.75rem;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .header-icon svg {
            width: 2rem;
            height: 2rem;
            color: white;
        }

        .header-text h1 {
            font-size: 2rem;
            font-weight: bold;
            color: white;
            margin-bottom: 0.25rem;
        }

        .header-text p {
            color: #cbd5e1;
            font-size: 1rem;
        }

        .header-stats {
            background: #475569;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            display: none;
        }

        @media (min-width: 768px) {
            .header-stats {
                display: block;
            }
        }

        .stats-label {
            color: #cbd5e1;
            font-size: 0.875rem;
        }

        .stats-value {
            color: white;
            font-weight: bold;
            margin-left: 0.5rem;
        }

        /* Mensaje de éxito */
        .success-message {
            background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 100%);
            border-left: 4px solid #10b981;
            padding: 1.5rem;
            margin: 1.5rem 2rem;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
        }

        .success-icon {
            width: 1.5rem;
            height: 1.5rem;
            color: #10b981;
            margin-right: 0.75rem;
            flex-shrink: 0;
        }

        .success-text {
            color: #065f46;
            font-weight: 500;
        }

        /* Barra de acciones */
        .actions-bar {
            padding: 1.5rem 2rem;
            background: #f9fafb;
            border-top: 1px solid #e5e7eb;
        }

        .actions-content {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        @media (min-width: 640px) {
            .actions-content {
                flex-direction: row;
                justify-content: space-between;
                align-items: center;
            }
        }

        .info-text {
            display: flex;
            align-items: center;
            color: #6b7280;
            font-size: 0.875rem;
        }

        .info-icon {
            width: 1.25rem;
            height: 1.25rem;
            margin-right: 0.5rem;
        }

        .button-group {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        @media (min-width: 640px) {
            .button-group {
                flex-direction: row;
            }
        }

        /* Botones */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            font-weight: 500;
            border-radius: 12px;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease;
            border: none;
        }

        .btn-secondary {
            background: white;
            color: #374151;
            border: 2px solid #d1d5db;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .btn-secondary:hover {
            background: #f9fafb;
            border-color: #9ca3af;
        }

        .btn-primary {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: white;
            box-shadow: 0 4px 14px 0 rgba(37, 99, 235, 0.39);
            padding: 0.5rem 1.5rem;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
            box-shadow: 0 8px 25px -8px rgba(37, 99, 235, 0.5);
            transform: translateY(-1px);
        }

        .btn-icon {
            width: 1rem;
            height: 1rem;
            margin-right: 0.5rem;
        }

        /* Tabla */
        .table-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            overflow: hidden;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        .process-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table-header {
            background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
        }

        .table-header th {
            padding: 1rem 1.5rem;
            text-align: left;
            font-size: 0.75rem;
            font-weight: 600;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 1px solid #e5e7eb;
        }

        .header-content-cell {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .header-icon-small {
            width: 1rem;
            height: 1rem;
            color: #9ca3af;
        }

        .header-icon-green {
            color: #10b981;
        }

        .header-icon-red {
            color: #ef4444;
        }

        .table-body tr {
            transition: background-color 0.2s ease;
        }

        .table-body tr:hover {
            background: #f9fafb;
        }

        .table-body td {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #f3f4f6;
            white-space: nowrap;
        }

        /* Badges y elementos de celda */
        .id-badge {
            background: #dbeafe;
            color: #1e40af;
            font-size: 0.875rem;
            font-weight: 500;
            padding: 0.25rem 0.75rem;
            border-radius: 50px;
            display: inline-block;
        }

        .process-number {
            font-size: 0.875rem;
            font-weight: 500;
            color: #111827;
        }

        .type-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .type-civil {
            background: #dbeafe;
            color: #1e40af;
        }

        .type-penal {
            background: #fee2e2;
            color: #991b1b;
        }

        .type-laboral {
            background: #fef3c7;
            color: #92400e;
        }

        .type-familia {
            background: #d1fae5;
            color: #065f46;
        }

        .person-info {
            display: flex;
            align-items: center;
        }

        .person-avatar {
            width: 2rem;
            height: 2rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 0.75rem;
            flex-shrink: 0;
        }

        .avatar-demandante {
            background: #d1fae5;
        }

        .avatar-demandado {
            background: #fee2e2;
        }

        .avatar-icon {
            width: 1rem;
            height: 1rem;
        }

        .avatar-icon-green {
            color: #059669;
        }

        .avatar-icon-red {
            color: #dc2626;
        }

        .person-name {
            font-size: 0.875rem;
            font-weight: 500;
            color: #111827;
        }

        /* Acciones */
        .actions-cell {
            text-align: center;
        }

        .actions-group {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
        }

        .action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem;
            border-radius: 8px;
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
            text-decoration: none;
        }

        .action-btn:hover svg {
            transform: scale(1.1);
        }

        .action-view {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .action-view:hover {
            background: #bfdbfe;
        }

        .action-edit {
            background: #fef3c7;
            color: #d97706;
        }

        .action-edit:hover {
            background: #fde68a;
        }

        .action-delete {
            background: #fee2e2;
            color: #dc2626;
        }

        .action-delete:hover {
            background: #fecaca;
        }

        .action-icon {
            width: 1rem;
            height: 1rem;
            transition: transform 0.2s ease;
        }

        /* Estado vacío */
        .empty-state {
            padding: 3rem 1.5rem;
            text-align: center;
        }

        .empty-icon {
            width: 4rem;
            height: 4rem;
            color: #d1d5db;
            margin: 0 auto 1rem;
        }

        .empty-title {
            font-size: 1.125rem;
            font-weight: 500;
            color: #374151;
            margin-bottom: 0.5rem;
        }

        .empty-text {
            color: #6b7280;
            margin-bottom: 1.5rem;
        }

        /* Paginación */
        .pagination-container {
            background: #f9fafb;
            padding: 1rem 1.5rem;
            border-top: 1px solid #e5e7eb;
        }

        .pagination-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .pagination-mobile {
            display: flex;
            justify-content: space-between;
            width: 100%;
        }

        @media (min-width: 640px) {
            .pagination-mobile {
                display: none;
            }
        }

        .pagination-desktop {
            display: none;
            width: 100%;
            justify-content: space-between;
            align-items: center;
        }

        @media (min-width: 640px) {
            .pagination-desktop {
                display: flex;
            }
        }

        .pagination-info {
            font-size: 0.875rem;
            color: #d1d5db;
        }

        .pagination-info span {
            font-weight: 500;
        }

        .pagination-btn {
            position: relative;
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: #374151;
            background: white;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            text-decoration: none;
            transition: all 0.15s ease;
        }

        .pagination-btn:hover {
            color: #6b7280;
            background: #f9fafb;
        }

        .pagination-btn.disabled {
            color: #9ca3af;
            background: white;
            cursor: not-allowed;
        }

        .pagination-btn.disabled:hover {
            color: #9ca3af;
            background: white;
        }

        .pagination-btn.active {
        background-color: #3b82f6;
        border-color: #3b82f6;
        color: #ffffff;
        font-weight: 600;
        }

        .pagination-btn.disabled {
        background-color: #f9fafb;
        border-color: #e5e7eb;
        color: #9ca3af;
        cursor: not-allowed;
        }

        /* Animaciones */
        .main-header {
            animation: slideIn 0.5s ease-out;
        }

        .table-container {
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }

            .header-content {
                flex-direction: column;
                align-items: flex-start;
            }

            .header-text h1 {
                font-size: 1.5rem;
            }

            .actions-content {
                flex-direction: column;
            }

            .table-header th {
                padding: 0.75rem 0.5rem;
                font-size: 0.6875rem;
            }

            .table-body td {
                padding: 0.75rem 0.5rem;
                font-size: 0.875rem;
            }
        }
    </style>
</head>


<body>
<!-- Modal para ver datos del proceso -->
<div id="viewProcessModal" class="modal" style="display:none; position:fixed; z-index:9999; left:0; top:0; width:100vw; height:100vh; background:rgba(0,0,0,0.3); align-items:center; justify-content:center;">
    <div class="modal-content" style="background:white; border-radius:16px; max-width:500px; margin:auto; padding:2rem; position:relative;">
        <span class="close-button" onclick="closeProcessModal()" style="position:absolute; top:1rem; right:1rem; font-size:2rem; cursor:pointer;">&times;</span>
        <h2 style="font-size:1.25rem; font-weight:600; margin-bottom:1rem;">Datos del Proceso</h2>
        <div id="processModalBody">
            <p>Cargando datos...</p>
        </div>
    </div>
</div>

    <div class="container">
<!-- Header Principal -->
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
                    <span class="pagination-info">{{ $procesos->total() }}</span>
                </div>
            </div>

<!-- Mensaje de éxito (ejemplo) -->
            <div class="success-message" style="display: none;">
                <svg class="success-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="success-text">Proceso creado exitosamente</p>
            </div>

<!-- Barra de acciones -->
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

<!-- Tabla -->
        <div class="table-container">
            <div class="table-wrapper">
                <table class="process-table">
<!-- titulos de la tabla -->
                    <thead class="table-header">
                        <tr>
                            <th>
                                <div class="header-content-cell">
                                    <span></span>
                                    <svg class="header-icon-small" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                                    </svg>
                                </div>
                            </th>
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
                    <td class="border border-gray-300 px-4 py-2">{{ $proceso->id }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $proceso->numero_radicado }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $proceso->tipo_proceso }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $proceso->demandante }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $proceso->demandado }}</td>

                    <td class="actions-cell">
                        <div class="actions-group">
<!-- Modifica el botón "Ver detalles" para llamar a la función -->
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

                            <form action="{{ route('procesos.destroy', $proceso->id) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este proceso?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-btn action-delete" title="Eliminar">
                            <svg class="action-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            </button>
                        </form>
                        </div>
                    </td>

                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center p-4 text-gray-500">No hay procesos registrados</td>
                </tr>
            @endforelse
                    </tbody>

                </table>
            </div>

<!-- Paginación -->
            <div class="pagination-container">
                <div class="pagination-content">
<!-- Paginación móvil -->
                    <div class="pagination-mobile">
                @if ($procesos->onFirstPage())
                    <span class="pagination-btn disabled">Anterior</span>
                @else
                    <a href="{{ $procesos->previousPageUrl() }}" class="pagination-btn">Anterior</a>
                @endif

<!-- Números de página -->
                    @php
                        $currentPage = $procesos->currentPage();
                        $lastPage = $procesos->lastPage();
                        $start = max(1, $currentPage - 2);
                        $end = min($lastPage, $currentPage + 2);
                    @endphp

                    @if ($start > 1)
                        <a href="{{ $procesos->url(1) }}" class="pagination-btn">1</a>
                        @if ($start > 2)
                            <span class="pagination-btn disabled">...</span>
                        @endif
                    @endif

                    @for ($pageNumber = $start; $pageNumber <= $end; $pageNumber++)
                        @if ($pageNumber == $currentPage)
                            <span class="pagination-btn active">{{ $pageNumber }}</span>
                        @else
                            <a href="{{ $procesos->url($pageNumber) }}" class="pagination-btn">{{ $pageNumber }}</a>
                        @endif
                    @endfor

                    @if ($end < $lastPage)
                        @if ($end < $lastPage - 1)
                            <span class="pagination-btn disabled">...</span>
                        @endif
                        <a href="{{ $procesos->url($lastPage) }}" class="pagination-btn">{{ $lastPage }}</a>
                    @endif

                @if ($procesos->hasMorePages())
                    <a href="{{ $procesos->nextPageUrl() }}" class="pagination-btn">Siguiente</a>
                @else
                    <span class="pagination-btn disabled">Siguiente</span>
                @endif
            </div>

<!-- Paginación desktop -->
            <div class="pagination-desktop">
                
                <div style="display: flex; gap: 0.5rem;">
                    <!-- Botón Anterior -->
                    @if ($procesos->onFirstPage())
                        <span class="pagination-btn disabled">Anterior</span>
                    @else
                        <a href="{{ $procesos->previousPageUrl() }}" class="pagination-btn">Anterior</a>
                    @endif

                    <!-- Números de página -->
                    @php
                        $currentPage = $procesos->currentPage();
                        $lastPage = $procesos->lastPage();
                        $start = max(1, $currentPage - 2);
                        $end = min($lastPage, $currentPage + 2);
                    @endphp

                    @if ($start > 1)
                        <a href="{{ $procesos->url(1) }}" class="pagination-btn">1</a>
                        @if ($start > 2)
                            <span class="pagination-btn disabled">...</span>
                        @endif
                    @endif

                    @for ($i = $start; $i <= $end; $i++)
                        @if ($i == $currentPage)
                            <span class="pagination-btn active">{{ $i }}</span>
                        @else
                            <a href="{{ $procesos->url($i) }}" class="pagination-btn">{{ $i }}</a>
                        @endif
                    @endfor

                    @if ($end < $lastPage)
                        @if ($end < $lastPage - 1)
                            <span class="pagination-btn disabled">...</span>
                        @endif
                        <a href="{{ $procesos->url($lastPage) }}" class="pagination-btn">{{ $lastPage }}</a>
                    @endif

                    <!-- Botón Siguiente -->
                    @if ($procesos->hasMorePages())
                        <a href="{{ $procesos->nextPageUrl() }}" class="pagination-btn">Siguiente</a>
                    @else
                        <span class="pagination-btn disabled">Siguiente</span>
                    @endif
                </div>
            </div>
                </div>
            </div>
        </div>
    </div>

<!-- Scripts -->
<!-- <script src="{{ asset('js/dash.js') }}"></script> -->
<script>
// Abre el modal y carga los datos del proceso por AJAX
function openProcessModal(id) {
    document.getElementById('viewProcessModal').style.display = 'flex';
    const body = document.getElementById('processModalBody');
    body.innerHTML = '<p>Cargando datos...</p>';

    fetch(`/procesos/${id}`)
        .then(res => res.json())
        .then(data => {
            body.innerHTML = `
                <p><strong>ID:</strong> ${data.id}</p>
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
</script>

</body>
</html>
