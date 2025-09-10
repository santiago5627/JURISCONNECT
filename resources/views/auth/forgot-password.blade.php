<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>JurisConnect SENA - Recuperar Contraseña</title>
    <link rel="stylesheet" href="{{ asset('/css/recuperar.css') }}">
    <!-- Si quieres mantener el CSS en línea temporalmente, lo dejo más abajo -->
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

            <form id="passwordEmailForm" method="POST" action="{{ route('password.email') }}">
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

    <!-- SCRIPT: Intercepta el submit por AJAX y muestra la alerta -->
    <script>
(function () {
    const form = document.getElementById('passwordEmailForm');
    if (!form) return;

    const url = "{{ route('password.email') }}";
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // ✅ Alerta con círculo + icono, título, mensaje y botón
    function showCustomAlert(message, type = 'success', title = '') {
        return new Promise(resolve => {
            const overlay = document.createElement('div');
            overlay.className = 'custom-alert-overlay';

            const box = document.createElement('div');
            box.className = 'custom-alert-box';

            // íconos
            let circleColor = '#047857';
            let icon = '✔';
            if (type === 'error') { circleColor = '#dc2626'; icon = '✖'; }
            if (type === 'warning') { circleColor = '#f59e0b'; icon = '⚠'; }
            if (type === 'info') { circleColor = '#2563eb'; icon = 'ℹ'; }

            box.innerHTML = `
                <div class="custom-alert-icon-circle" style="background:${circleColor}">
                    <span>${icon}</span>
                </div>
                <h3 class="custom-alert-title">${title || (type === 'success' ? '¡Excelente!' : 'Aviso')}</h3>
                <p class="custom-alert-message">${message}</p>
                <button class="custom-alert-btn">Aceptar</button>
            `;

            overlay.appendChild(box);
            document.body.appendChild(overlay);

            // cerrar
            box.querySelector('.custom-alert-btn').addEventListener('click', () => {
                overlay.remove();
                resolve(true);
            });
            document.addEventListener('keydown', function escHandler(e) {
                if (e.key === 'Escape') {
                    overlay.remove();
                    document.removeEventListener('keydown', escHandler);
                    resolve(false);
                }
            });
        });
    }

    // Mostrar si Laravel redirige con status
    const statusMessage = @json(session('status') ?: null);
    if (statusMessage) {
        showCustomAlert(statusMessage, 'success', 'Correo enviado');
    }

    // Interceptar submit
    form.addEventListener('submit', async function (e) {
        e.preventDefault();
        const formData = new FormData(form);

        try {
            const res = await fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: formData
            });

            let data = null;
            try { data = await res.json(); } catch (err) {}

            if (res.ok) {
                const msg = (data && (data.message || data.status)) || 'Hemos enviado un correo con instrucciones.';
                await showCustomAlert(msg, 'success', 'Correo enviado');
                form.reset();
            } else if (res.status === 422 && data) {
                const text = data.errors ? Object.values(data.errors).flat().join('\n') : data.message;
                await showCustomAlert(text || 'Hay errores en el formulario', 'warning', 'Error de validación');
            } else {
                const msg = (data && (data.message || data.error)) || 'No se pudo enviar la solicitud.';
                await showCustomAlert(msg, 'error', 'Error');
            }
        } catch (error) {
            console.error('Error AJAX:', error);
            form.submit();
        }
    });
})();
</script>

</body>
</html>
