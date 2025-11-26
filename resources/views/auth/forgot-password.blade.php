<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>JurisConnect SENA - Recuperar Contraseña</title>
    <link rel="stylesheet" href="{{ asset('/css/recuperar.css') }}">
    <style>
        /* Estilos para las alertas personalizadas */
        .custom-alert-overlay {
            position: fixed;
            inset: 0;
            display: none;
            align-items: center;
            justify-content: center;
            background: rgba(0, 0, 0, 0.5);
            z-index: 9999;
            backdrop-filter: blur(2px);
        }
        
        .custom-alert-box {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            max-width: 420px;
            text-align: center;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
            animation: slideIn 0.3s ease-out;
        }
        
        @keyframes slideIn {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
        
        .custom-alert-icon-circle {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
            background: #2ecc71;
            color: #fff;
            font-weight: 700;
            font-size: 28px;
        }
        
        .custom-alert-icon-circle.error {
            background: #e74c3c;
        }
        
        .custom-alert-title {
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 12px;
            color: #2c3e50;
        }
        
        .custom-alert-message {
            font-size: 15px;
            line-height: 1.6;
            color: #555;
            margin-bottom: 20px;
        }
        
        .custom-alert-btn {
            margin-top: 12px;
            padding: 10px 24px;
            border-radius: 6px;
            cursor: pointer;
            background: #16a085;
            color: white;
            border: none;
            font-size: 15px;
            font-weight: 600;
            transition: background 0.3s;
        }
        
        .custom-alert-btn:hover {
            background: #138f75;
        }
        
        .input-error {
            color: #e74c3c;
            margin-top: 6px;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <!-- Fondo -->
    <div class="background-image">
        <img src="{{ asset('img/Login.jpg') }}" alt="Fondo">
    </div>

    {{-- -------------- Lógica Blade PRIMERO para definir variables -------------- --}}
    @php
        // Obtenemos el primer error de 'email' si existe
        $emailError = $errors->first('email') ?? null;
        $showThrottle = false;
        $throttleSeconds = null;

        if ($emailError) {
            // Normalizamos a minúsculas para comparaciones
            $lower = mb_strtolower($emailError);

            // Caso 1: mensajes que contienen la palabra "segundo(s)" o "second(s)" y un número
            if (preg_match('/(\d+)\s*(segundo|segundos|second|seconds)/i', $emailError, $m)) {
                $throttleSeconds = (int)$m[1];
                $showThrottle = true;
            }
            // Caso 2: mensajes con palabras clave comunes (incluye "wait", "retry", "retrying")
            elseif (preg_match('/wait|espera|inténtalo|demasiad|too many|throttl|esperar|retry|retrying/i', $lower)) {
                $showThrottle = true;
            }
        }

        // Laravel a veces pone el estado en session('status')
        $status = session('status') ?? null;
        if (!$showThrottle && $status) {
            $lowerStatus = mb_strtolower($status);
            if (preg_match('/throttl|espera|segundo|seconds|too many|wait|retry/i', $lowerStatus)) {
                $showThrottle = true;
                // Intentar extraer segundos si vienen en el status
                if (preg_match('/(\d+)\s*(segundo|segundos|second|seconds)/i', $status, $m2)) {
                    $throttleSeconds = (int)$m2[1];
                }
            }
        }
    @endphp

    <!-- Contenedor principal -->
    <div class="main-container">
        <!-- Izquierda: Logo -->
        <div class="left-section">
            <img class="logo-jurisconnect" src="{{ asset('img/LogoJ.png') }}" alt="JurisConnect">
        </div>

        <!-- Derecha: Formulario -->
        <div class="form-container">
            <h2 class="form-title">Recuperar Acceso</h2>
            <p class="form-description">Ingresa tu correo electrónico</p>

            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="form-group">
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="Correo Electrónico" class="form-input">
                    {{-- Solo mostramos el error debajo del input si NO es un error de throttle --}}
                    @if ($errors->has('email') && !$showThrottle)
                        <div class="input-error">{{ $errors->first('email') }}</div>
                    @endif
                </div>

                <div class="button-group">
                    <a href="{{ route('login') }}" class="btn btn-back">Volver</a>
                    <button type="submit" class="btn btn-next">Enviar</button>
                </div>

                <!-- Logo SENA -->
                <div class="sena-container">
                    <img src="{{ asset('img/Sena.png') }}" alt="Logo SENA">
                </div>
            </form>
        </div>
    </div>

    <!-- Alerta Éxito -->
    <div class="custom-alert-overlay" id="alertOverlay">
        <div class="custom-alert-box">
            <div class="custom-alert-icon-circle">✔</div>
            <h3 class="custom-alert-title">¡Correo Enviado!</h3>
            <p class="custom-alert-message">
                Hemos enviado las instrucciones de recuperación a tu correo electrónico.
                Por favor revisa tu bandeja de entrada y sigue las instrucciones.
            </p>
            <button class="custom-alert-btn" onclick="closeAlert()">Entendido</button>
        </div>
    </div>

    <!-- Alerta Error (throttle) -->
    <div class="custom-alert-overlay" id="alertErrorOverlay">
        <div class="custom-alert-box">
            <div class="custom-alert-icon-circle error">✖</div>
            <h3 class="custom-alert-title">¡Espera un momento!</h3>
            <p class="custom-alert-message" id="alertErrorMessage">
                Debes esperar 30 segundos antes de solicitar un nuevo enlace. Inténtalo nuevamente en un momento.
            </p>
            <button class="custom-alert-btn" onclick="closeErrorAlert()">Entendido</button>
        </div>
    </div>

    <script>
    /* ---------- Funciones de manejo de alertas ---------- */
    // Éxito
    function showAlert() {
        const overlay = document.getElementById('alertOverlay');
        if (overlay) overlay.style.display = 'flex';
    }
    
    function closeAlert() {
        const overlay = document.getElementById('alertOverlay');
        if (overlay) overlay.style.display = 'none';
    }

    // Error / Throttle
    function showErrorAlert(message) {
        const overlay = document.getElementById('alertErrorOverlay');
        const msgEl = document.getElementById('alertErrorMessage');
        if (message && msgEl) msgEl.textContent = message;
        if (overlay) overlay.style.display = 'flex';
    }
    
    function closeErrorAlert() {
        const overlay = document.getElementById('alertErrorOverlay');
        if (overlay) overlay.style.display = 'none';
    }

    // Cierre al click fuera o Escape (aplica para ambas)
    document.addEventListener('click', function(e) {
        const overlay = document.getElementById('alertOverlay');
        const overlayError = document.getElementById('alertErrorOverlay');
        if (overlay && e.target === overlay) closeAlert();
        if (overlayError && e.target === overlayError) closeErrorAlert();
    });
    
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeAlert();
            closeErrorAlert();
        }
    });
    </script>

    {{-- Mostrar alerta error si detectamos throttle --}}
    @if ($showThrottle)
        @php
            // Construimos un mensaje más claro si tenemos los segundos
            if ($throttleSeconds && $throttleSeconds > 0) {
                $throttleMsg = "Debes esperar {$throttleSeconds} segundos antes de solicitar un nuevo enlace. Inténtalo nuevamente en un momento.";
            } else {
                $throttleMsg = "Debes esperar 30 segundos antes de solicitar un nuevo enlace. Inténtalo nuevamente en un momento.";
            }
        @endphp
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                showErrorAlert(@json($throttleMsg));
            });
        </script>
    @endif

    {{-- Mostrar alerta de éxito si Laravel puso session('status') indicando envío --}}
    @if (session('status') && !$showThrottle)
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                showAlert();
            });
        </script>
    @endif

</body>

</html>