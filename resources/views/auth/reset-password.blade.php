<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>JurisConnect SENA - Restablecer Contraseña</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            height: 100vh;
            background: url('{{ asset("img/JURISCONNECT.jpg") }}') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 6%;
        }

        /* Branding izquierdo */
        .branding {
            color: white;
            text-align: center;
            position: relative;
            left: 250px;
        }

        .branding img {
            width: 400px;
            height: auto;
            margin-bottom: 15px;
        }

        /* Caja de restablecer */
        .reset-box {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            padding: 60px;
            border-radius: 20px;
            box-shadow: 0 4px 25px rgba(0, 0, 0, 0.35);
            width: 550px;
            height: auto;
            text-align: center;
            position: relative;
            left: -220px;
        }

        .reset-box h2 {
            margin-bottom: 25px;
            color: #fff;
            font-size: 2rem;
            font-weight: bold;
        }

        .reset-box label {
            display: block;
            color: #fff;
            margin-bottom: 6px;
            text-align: left;
            font-size: 1rem;
        }

        .reset-box input {
            width: 100%;
            padding: 14px;
            border-radius: 25px;
            border: 2px solid #ccc;
            margin-bottom: 18px;
            outline: none;
            font-size: 1rem;
        }

        .reset-box input:focus {
            border-color: #238C00;
        }

        .reset-box button {
            background-color: #238C00;
            color: white;
            border: none;
            padding: 14px;
            border-radius: 25px;
            width: 100%;
            font-size: 1.1rem;
            cursor: pointer;
            font-weight: bold;
        }

        .reset-box button:hover {
            background-color: #1c7300;
        }

        .reset-box img {
            margin-top: 18px;
            width: 85px;
        }

        .errors {
            background-color: #ffe6e6;
            color: #d8000c;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: left;
        }

        .error-input {
            border-color: #ff6b6b !important;
        }
    </style>
</head>

<body>
    <!-- Izquierda: logo -->
    <div class="branding">
        <img src="{{ asset('img/BlancoJuris.png') }}" alt="JurisConnect">
    </div>

    <!-- Derecha: restablecer contraseña -->
    <div class="reset-box">
        <h2>Restablecer Contraseña</h2>

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

            <button type="submit" class="btn-submit">Restablecer Contraseña</button>

            <img src="{{ asset('img/senablanco.png') }}" alt="Logo SENA" class="logo">
        </form>

    </div>
</body>

</html>