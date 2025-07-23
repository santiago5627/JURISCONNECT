<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Restablecer Contraseña</title>
    <style>
        body {
            font-family: sans-serif;
            background-color: #f0f2f5;
            padding: 30px;
        }
        .card {
            background-color: white;
            max-width: 400px;
            margin: auto;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
        }
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 8px 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button {
            background-color: #8e44ad;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="card">
        <h2 style="text-align: center;">🔒 Restablecer Contraseña</h2>

        @if ($errors->any())
            <div style="color: red; margin-bottom: 15px;">
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

            <button type="submit">Restablecer contraseña</button>
        </form>
    </div>
</body>
</html>
