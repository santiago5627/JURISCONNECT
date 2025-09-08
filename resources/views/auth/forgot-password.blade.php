<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>JurisConnect SENA - Recuperar Contraseña</title>
    <link rel="stylesheet" href="{{ asset('/css/recuperar.css') }}">
</head>
<body>
    <!-- Fondo -->
    <div class="background-image">
        <img src="{{ asset('img/Login.jpg') }}" alt="Fondo">
    </div>

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

    <!-- Script con showCustomAlert -->
<script>
    function showCustomAlert(message, type = 'success') {
        const overlay = document.createElement('div');
        overlay.className = 'custom-alert-overlay';

        const alertBox = document.createElement('div');
        alertBox.className = `custom-alert-box ${type}`;

        // Íconos según el tipo
        let icon = '';
        if (type === 'success') icon = '✅';
        if (type === 'error') icon = '❌';
        if (type === 'warning') icon = '⚠️';
        if (type === 'info') icon = 'ℹ️';

        alertBox.innerHTML = `
            <div class="custom-alert-header">
                <span class="custom-alert-icon">${icon}</span>
                <h3 class="custom-alert-title">${type === 'success' ? 'Éxito' : 'Aviso'}</h3>
            </div>
            <p class="custom-alert-message">${message}</p>
            <button class="custom-alert-btn">Aceptar</button>
        `;

        overlay.appendChild(alertBox);
        document.body.appendChild(overlay);

        // Cerrar alerta
        alertBox.querySelector('.custom-alert-btn').addEventListener('click', () => {
            overlay.remove();
        });

        // También con tecla ESC
        document.addEventListener('keydown', function escListener(e) {
            if (e.key === 'Escape') {
                overlay.remove();
                document.removeEventListener('keydown', escListener);
            }
        });
    }

    // Mostrar el mensaje si Laravel lo envía
    const statusMessage = @json(session('status') ?: null);
    if (statusMessage) {
        showCustomAlert(statusMessage, 'success');
    }
</script>
</body>
</html>
