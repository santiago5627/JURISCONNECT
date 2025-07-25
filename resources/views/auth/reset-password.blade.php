<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Restablecer Contraseña - JurisConnect SENA</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to bottom, #ffffff, #9bd170);
            margin: 0;
            padding: 40px 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .card {
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.15);
            max-width: 420px;
            width: 100%;
            padding: 40px 30px;
            box-sizing: border-box;
        }

        .card h2 {
            text-align: center;
            color: #2d2d2d;
            margin-bottom: 30px;
        }

        .logo {
            display: block;
            margin: 0 auto 20px auto;
            width: 90px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            color: #333;
            display: block;
            margin-bottom: 8px;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px 16px;
            border: 1.5px solid #c5e1a5;
            border-radius: 8px;
            background-color: #f6fdf4;
            font-size: 15px;
            line-height: 1.4;
            box-sizing: border-box;
            transition: border 0.2s;
        }

        input:focus {
            outline: none;
            border-color: #6abf4b;
        }

        .btn {
            width: 100%;
            background-color: #6abf4b;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            font-size: 16px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #58a03f;
        }

        .errors {
            background-color: #ffe6e6;
            color: #d8000c;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .footer-logo {
            margin-top: 25px;
            text-align: center;
        }

        .footer-logo img {
            width: 70px;
        }
    </style>
</head>
<body>
    <div class="card">
        <img src="{{ asset('img/LogoSena_Verde.png') }}" alt="Logo JurisConnect" class="logo">

        <h2>🔒 Restablecer Contraseña</h2>

        @if ($errors->any())
            <div class="errors">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.store') }}">
            @csrf
            <input type="hidden" name="token" value="{{ request()->route('token') }}">

            <div class="form-group">
                <label for="email">Correo electrónico</label>
                <input id="email" type="email" name="email" value="{{ request()->email }}" required autofocus>
            </div>

            <div class="form-group">
                <label for="password">Nueva contraseña</label>
                <input id="password" type="password" name="password" required>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirmar contraseña</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required>
            </div>

            <button class="btn" type="submit">Restablecer contraseña</button>
        </form>

        <div class="footer-logo">
            <img src="{{ asset('img/sena_logo.png') }}" alt="Logo SENA">
        </div>
    </div>
</body>
</html>
