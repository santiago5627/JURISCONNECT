<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>JurisConnect SENA - Login</title>
    <link rel="stylesheet" href="{{ asset('/Css/Login.css') }}">
</head>
<body>
    

    <!--Fondo de pantalla -->
    <div class="background-image">
        <img src="{{ asset('img/Login.jpg') }}" alt="Fondo de Pantalla"  class="background-image">
    </div>

    <!-- Izquierda: logo -->
    <div class="branding">
        <img src="{{ asset('img/LogoJ.png') }}" alt="JurisConnect" class="logo_J">
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
            <input id="password" type="password" name="password" required autocomplete="current-password" class="{{ $errors->get('password') ? 'error-input' : '' }}">
            @if ($errors->get('password'))
                <div class="error-message">
                    @foreach ($errors->get('password') as $error)
                        {{ $error }}
                    @endforeach
                </div>
            @endif
            <button type="submit">Ingresar</button>

            <p >
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">
                        ¿Olvidó su contraseña?
                    </a>
                @endif
            </p>

            <img src="{{ asset('img/Sena.png') }}" alt="Logo SENA" class="sena-logo">
        </form>
    </div>

</body>
</html>