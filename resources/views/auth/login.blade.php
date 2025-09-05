<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>JurisConnect SENA - Login</title>
    <link rel="stylesheet" href="{{ asset('/css/login.css') }}">
</head>
<body>
    <!-- Fondo de pantalla -->
    <div class="background-image">
        <img src="{{ asset('img/Login.jpg') }}" alt="Fondo de Pantalla" class="background-image">
    </div>

    <!-- Izquierda: logo -->
    <div class="branding">
        <img src="{{ asset('img/LogoJ.png') }}" alt="JurisConnect">
    </div>

    <!-- Derecha: login -->
    <div class="login-box">
        <h2>Bienvenido</h2>

        @if (session('status'))
            <div class="session-status">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <label for="email">Correo Electrónico</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="{{ $errors->get('email') ? 'error-input' : '' }}">
            @if ($errors->get('email'))
                <div class="error-message">
                    @foreach ($errors->get('email') as $error)
                        {{ $error }}
                    @endforeach
                </div>
            @endif

            <label for="password">Contraseña</label>
            <div class="password-container">
                <input id="password" 
                    type="password" 
                    name="password" 
                    required 
                    autocomplete="current-password" 
                    class="password-input {{ $errors->get('password') ? 'error-input' : '' }}">
                
                <!-- SVG del ojo (toggle) -->
    <span id="togglePassword" class="password-toggle" 
        role="button" tabindex="0" 
        title="Mostrar contraseña"
        onclick="togglePasswordVisibility()">

        <!-- 👁️‍🗨️ Ojo cerrado (se ve primero) -->
        <svg xmlns="http://www.w3.org/2000/svg" 
            id="eyeClosed" 
            width="22" height="22" 
            viewBox="0 0 24 24" 
            fill="none" stroke="black" stroke-width="2" 
            stroke-linecap="round" stroke-linejoin="round">
            <path d="M17.94 17.94A10.12 10.12 0 0 1 12 20c-7 0-11-8-11-8a19.44 19.44 0 0 1 4.24-5.94M9.9 4.24A9.77 9.77 0 0 1 12 4c7 0 11 8 11 8a19.44 19.44 0 0 1-4.24 5.94M1 1l22 22"/>
        </svg>

        <!-- 👁️ Ojo abierto (oculto al inicio) -->
        <svg xmlns="http://www.w3.org/2000/svg" 
            id="eyeOpen" 
            width="22" height="22" 
            viewBox="0 0 24 24" 
            fill="none" stroke="black" stroke-width="2" 
            stroke-linecap="round" stroke-linejoin="round" 
            style="display:none;">
            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
            <circle cx="12" cy="12" r="3"/>
        </svg>
    </span>
            </div>
            @if ($errors->get('password'))
                <div class="error-message">
                    @foreach ($errors->get('password') as $error)
                        {{ $error }}
                    @endforeach
                </div>
            @endif
            
            <button type="submit">Ingresar</button>

            <p>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">
                        ¿Olvidó su contraseña?
                    </a>
                @endif
            </p>
            <img src="{{ asset('img/Sena.png') }}" alt="Logo SENA" class="sena-logo">
        </form>
    </div>
<script>
    function togglePasswordVisibility() {
        const passwordInput = document.getElementById('password');
        const eyeOpen = document.getElementById('eyeOpen');
        const eyeClosed = document.getElementById('eyeClosed');

        if (passwordInput.type === 'password') {
            // Mostrar contraseña
            passwordInput.type = 'text';
            eyeClosed.style.display = 'none';
            eyeOpen.style.display = 'inline';
        } else {
            // Ocultar contraseña
            passwordInput.type = 'password';
            eyeClosed.style.display = 'inline';
            eyeOpen.style.display = 'none';
        }

        passwordInput.focus();
    }

    document.addEventListener('DOMContentLoaded', function() {
        const toggleButton = document.getElementById('togglePassword');
        const eyeClosed = document.getElementById('eyeClosed');
        const eyeOpen = document.getElementById('eyeOpen');

        // 👁️‍🗨️ Aseguramos que cargue con ojo cerrado
        eyeClosed.style.display = 'inline';
        eyeOpen.style.display = 'none';

        // Accesibilidad con teclado
        toggleButton.addEventListener('keydown', function(e) {
            if (e.code === 'Space' || e.code === 'Enter') {
                e.preventDefault();
                togglePasswordVisibility();
            }
        });
    });
</script>
</body>
</html>
