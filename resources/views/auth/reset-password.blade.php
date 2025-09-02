<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>JurisConnect SENA - Login</title>
    <link rel="stylesheet" href="{{ asset('/css/register.css') }}">
</head>
<body>
    

    <!--Fondo de pantalla -->
    <div class="background-image">
        <img src="{{ asset('img/Login.jpg') }}" alt="Fondo de Pantalla"  class="background-image">
    </div>

    <!-- Izquierda: logo -->
    <div class="branding">
        <img src="{{ asset('img/LogoJ.png') }}" alt="JurisConnect">
    </div>

    <!-- Derecha: login -->
    <div class="login-box">
        <h2>Actualizar Contraseña </h2>

        <!-- Mostrar errores -->
        @if ($errors->any())
        <div class="errors">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Formulario -->
        <form method="POST" action="{{ route('password.store') }}">
            @csrf
            <input type="hidden" name="token" value="{{ request()->route('token') }}">

            <!-- Email -->
            <label for="email">Correo Electrónico</label>
            <input id="email" type="email" name="email" value="{{ old('email', request('email')) }}" required autofocus>
            @error('email')
            <span class="error-message">{{ $message }}</span>
            @enderror

            <!-- Password -->
            <label for="password">Nueva Contraseña</label>
            <input id="password" type="password" name="password" required>
            @error('password')
            <span class="error-message">{{ $message }}</span>
            @enderror

            <!-- Confirm Password -->
            <label for="password_confirmation">Confirmar Contraseña</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required>
            @error('password_confirmation')
            <span class="error-message">{{ $message }}</span>
            @enderror

        </form>
            <div class="button-group">
                <button type="button" class="btn btn-back" onclick="window.location='{{ url('/') }}'">
                    Cancelar
                </button>
            <button class="btn" type="submit">Guardar</button>
            </div>
        </form>

            <img src="{{ asset('img/Sena.png') }}" alt="Logo SENA" class="sena-logo">
    </div>

    <script src="{{ asset('/js/recuperar.js') }}"></script>
</body>
</html>