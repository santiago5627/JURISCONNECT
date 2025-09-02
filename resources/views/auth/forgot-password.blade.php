<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>JurisConnect SENA - Recuperar Contraseña</title>
    <link rel="stylesheet" href="{{ asset('/css/recuperar.css') }}">
</head>
<body>
    
    <!-- Izquierda: logo -->
    <div class="branding">
        <img src="{{ asset('img/BlancoJuris.png') }}" alt="JurisConnect">
    </div>

    <!-- Derecha: formulario forgot password -->
    <div class="forgot-box">
        <h2>Recuperar Acceso</h2>
        <p>Ingresa tu correo electrónico y te enviaremos un enlace para restablecer tu contraseña de forma segura.</p>

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <label for="email">Correo Electrónico</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>

            <button type="submit" class="btn-primary">Enviar enlace</button>

            <a href="{{ route('login') }}">
                <button type="button" class="btn-secondary">Volver al Login</button>
            </a>

            <img src="{{ asset('img/senablanco.png') }}" alt="Logo SENA">
        </form>
    </div>

</body>
</html>
