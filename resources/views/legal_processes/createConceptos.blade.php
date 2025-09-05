<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Procesos Pendientes - CSS Puro</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Reset y base */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            min-height: 100vh;
            color: #1f2937;
            line-height: 1.6;
        }

        /* Navbar */
        .navbar {
            background: #ffffff;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1), 0 1px 2px rgba(0, 0, 0, 0.06);
            border-bottom: 1px solid #e5e7eb;
        }

        .nav-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 64px;
        }

        .nav-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .nav-brand i {
            color: #3b82f6;
            font-size: 1.5rem;
        }

        .nav-brand span {
            font-size: 1.25rem;
            font-weight: 700;
            color: #111827;
        }

        /* Container principal */
        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }

        /* Header */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 2rem;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .header-content h1 {
            font-size: 1.875rem;
            font-weight: 700;
            color: #111827;
            margin-bottom: 0.5rem;
        }

        .header-content p {
            color: #6b7280;
            font-size: 1rem;
        }

        .cancel-btn {
            background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
            color: white;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 0.5rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 600;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .cancel-btn:hover {
            background: linear-gradient(135deg, #4b5563 0%, #374151 100%);
            transform: translateY(-1px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        /* Alertas */
        .alert {
            padding: 1.5rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .alert-success {
            background-color: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #166534;
        }

        .alert-info {
            background-color: #eff6ff;
            border: 1px solid #bfdbfe;
            color: #1e40af;
        }

        .alert i {
            font-size: 1.125rem;
        }

        .alert-success i {
            color: #16a34a;
        }

        .alert-info i {
            color: #3b82f6;
        }

        .alert-close {
            margin-left: auto;
            background: none;
            border: none;
            color: inherit;
            cursor: pointer;
            padding: 0.25rem;
        }

        /* Cards de procesos */
        .process-grid {
            display: grid;
            gap: 1.5rem;
        }

        .process-card {
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            border: 1px solid #f3f4f6;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .process-card:hover {
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            transform: translateY(-2px);
        }

        /* Header de cada card */
        .card-header {
            background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
            color: white;
            padding: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-title {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .card-title-icon {
            background: rgba(255, 255, 255, 0.2);
            padding: 0.5rem;
            border-radius: 0.5rem;
        }

        .card-title h3 {
            font-size: 1.25rem;
            font-weight: 700;
        }

        .status-badge {
            background: #fbbf24;
            color: #92400e;
            padding: 0.5rem 1rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 600;
        }

        /* Contenido del card */
        .card-body {
            padding: 1.5rem;
        }

        .card-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .info-section {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem;
            border-radius: 0.5rem;
        }

        .info-item-blue {
            background-color: #eff6ff;
        }

        .info-item-green {
            background-color: #f0fdf4;
        }

        .info-item-purple {
            background-color: #faf5ff;
        }

        .info-item-orange {
            background-color: #fff7ed;
        }

        .info-item-red {
            background-color: #fef2f2;
        }

        .info-icon {
            padding: 0.5rem;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .info-icon-blue {
            background-color: #dbeafe;
            color: #2563eb;
        }

        .info-icon-green {
            background-color: #dcfce7;
            color: #16a34a;
        }

        .info-icon-purple {
            background-color: #e9d5ff;
            color: #9333ea;
        }

        .info-icon-orange {
            background-color: #fed7aa;
            color: #ea580c;
        }

        .info-icon-red {
            background-color: #fecaca;
            color: #dc2626;
        }

        .info-content p:first-child {
            font-size: 0.875rem;
            color: #6b7280;
            font-weight: 500;
            margin-bottom: 0.25rem;
        }

        .info-content p:last-child {
            font-weight: 700;
            color: #111827;
        }

        /* Footer del card */
        .card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            padding-top: 1rem;
            border-top: 1px solid #f3f4f6;
            flex-wrap: wrap;
        }

        .timestamp {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #6b7280;
            font-size: 0.875rem;
        }

        .action-btn {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            padding: 0.75rem 2rem;
            border: none;
            border-radius: 0.5rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 600;
            font-size: 0.875rem;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .action-btn:hover {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            transform: translateY(-1px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        /* Recordatorio */
        .reminder {
            background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
            border: 1px solid #fcd34d;
            border-radius: 0.75rem;
            padding: 1.5rem;
            margin-top: 2rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .reminder-content {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
        }

        .reminder-icon {
            background: #fde68a;
            padding: 0.75rem;
            border-radius: 50%;
            color: #d97706;
            font-size: 1.25rem;
        }

        .reminder-text h4 {
            font-weight: 700;
            color: #92400e;
            margin-bottom: 0.5rem;
        }

        .reminder-text p {
            color: #b45309;
            line-height: 1.6;
        }

        /* Estado sin procesos */
        .empty-state {
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            padding: 3rem;
            text-align: center;
        }

        .empty-icon {
            background: #dcfce7;
            width: 96px;
            height: 96px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
        }

        .empty-icon i {
            color: #16a34a;
            font-size: 2.5rem;
        }

        .empty-state h3 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #111827;
            margin-bottom: 1rem;
        }

        .empty-state p {
            font-size: 1.125rem;
            color: #6b7280;
            margin-bottom: 2rem;
        }

        /* Animaciones */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in-up {
            animation: fadeInUp 0.6s ease-out forwards;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }

            .header {
                flex-direction: column;
                align-items: stretch;
                gap: 1rem;
            }

            .header-content h1 {
                font-size: 1.5rem;
            }

            .card-grid {
                grid-template-columns: 1fr;
            }

            .card-footer {
                flex-direction: column;
                align-items: stretch;
                gap: 1rem;
            }

            .action-btn {
                justify-content: center;
                width: 100%;
            }
        }

        @media (max-width: 480px) {
            .card-header {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }

            .nav-container {
                padding: 0 0.5rem;
            }

            .nav-brand span {
                font-size: 1rem;
            }
        }

        /* Utilidades */
        .hidden {
            display: none;
        }

        .font-bold {
            font-weight: 700;
        }

        .text-center {
            text-align: center;
        }
    </style>
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
            <button class="cancel-btn" onclick="window.history.back()">
                <i class="fas fa-arrow-left"></i>
                Cancelar
            </button>
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
                <p style="font-size: 0.875rem;">Tienes <strong>3</strong> proceso(s) pendiente(s) de concepto jurídico. Selecciona uno para redactar su concepto.</p>
            </div>
        </div>

<!-- Lista de Procesos -->
        <div class="process-grid">
<!-- Proceso 1 -->
            <div class="process-card fade-in-up">
                <div class="card-header">
                    <div class="card-title">
                        <div class="card-title-icon">
                            <i class="fas fa-gavel"></i>
                        </div>
                        <h3>Proceso Legal</h3>
                    </div>
                    <span class="status-badge">Pendiente</span>
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
                                    <p>2024-001-JC</p>
                                </div>
                            </div>

                            <div class="info-item info-item-green">
                                <div class="info-icon info-icon-green">
                                    <i class="fas fa-balance-scale"></i>
                                </div>
                                <div class="info-content">
                                    <p>Tipo de Proceso</p>
                                    <p>Contencioso Administrativo</p>
                                </div>
                            </div>

                            <div class="info-item info-item-purple">
                                <div class="info-icon info-icon-purple">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                <div class="info-content">
                                    <p>Fecha Radicación</p>
                                    <p>15/08/2024</p>
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
                                    <p>María González Pérez</p>
                                </div>
                            </div>

                            <div class="info-item info-item-red">
                                <div class="info-icon info-icon-red">
                                    <i class="fas fa-user-minus"></i>
                                </div>
                                <div class="info-content">
                                    <p>Demandado</p>
                                    <p>Alcaldía Municipal</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="timestamp">
                            <i class="fas fa-clock"></i>
                            <span>Proceso creado: 15/08/2024 14:30</span>
                        </div>
                        <button class="action-btn">
                            <i class="fas fa-edit"></i>
                            Redactar Concepto Jurídico
                        </button>
                    </div>
                </div>
            </div>

<!-- Proceso 2 -->
            <div class="process-card fade-in-up" style="animation-delay: 0.1s;">
                <div class="card-header">
                    <div class="card-title">
                        <div class="card-title-icon">
                            <i class="fas fa-gavel"></i>
                        </div>
                        <h3>Proceso Legal</h3>
                    </div>
                    <span class="status-badge">Pendiente</span>
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
                                    <p>2024-002-JC</p>
                                </div>
                            </div>

                            <div class="info-item info-item-green">
                                <div class="info-icon info-icon-green">
                                    <i class="fas fa-balance-scale"></i>
                                </div>
                                <div class="info-content">
                                    <p>Tipo de Proceso</p>
                                    <p>Civil</p>
                                </div>
                            </div>

                            <div class="info-item info-item-purple">
                                <div class="info-icon info-icon-purple">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                <div class="info-content">
                                    <p>Fecha Radicación</p>
                                    <p>18/08/2024</p>
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
                                    <p>Carlos Rodríguez López</p>
                                </div>
                            </div>

                            <div class="info-item info-item-red">
                                <div class="info-icon info-icon-red">
                                    <i class="fas fa-user-minus"></i>
                                </div>
                                <div class="info-content">
                                    <p>Demandado</p>
                                    <p>Empresa XYZ S.A.S.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="timestamp">
                            <i class="fas fa-clock"></i>
                            <span>Proceso creado: 18/08/2024 09:15</span>
                        </div>
                        <button class="action-btn">
                            <i class="fas fa-edit"></i>
                            Redactar Concepto Jurídico
                        </button>
                    </div>
                </div>
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