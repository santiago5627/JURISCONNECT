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
            <p class="form-description">
                Ingresa tu correo electrónico
            </p>


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

    <!-- Alerta personalizada -->
    <div class="custom-alert-overlay" id="alertOverlay" style="display: none;">
        <div class="custom-alert-box">
            <div class="custom-alert-icon-circle">
                <i class="fas fa-check">✔</i>
            </div>
            <h3 class="custom-alert-title">¡Correo Enviado!</h3>
            <p class="custom-alert-message">
                Hemos enviado las instrucciones de recuperación a tu correo electrónico.
                Por favor revisa tu bandeja de entrada y sigue las instrucciones.
            </p>
            <button class="custom-alert-btn" onclick="closeAlert()">Entendido</button>
        </div>
    </div>

    <script>
// Mostrar alerta
function showAlert() {
    const overlay = document.getElementById('alertOverlay');
    if (overlay) overlay.style.display = 'flex';
}

function closeAlert() {
    const overlay = document.getElementById('alertOverlay');
    if (overlay) overlay.style.display = 'none';
}

document.addEventListener('DOMContentLoaded', () => {
    const overlay = document.getElementById('alertOverlay');
    if (!overlay) return;

    overlay.addEventListener('click', function (e) {
        if (e.target === overlay) closeAlert();
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeAlert();
    });
});
</script>

{{-- Mostrar alerta si Laravel envió correo --}}
@if (session('status'))
<script>
    showAlert();
</script>
@endif
</body>

</html>