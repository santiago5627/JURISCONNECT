<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>JurisConnect SENA - Login</title>
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
        /* Logo y texto a la izquierda */
    .branding {
        color: white;
        text-align: center;
        position: relative;
        left: 250px; /* Ajusta el valor según lo que necesites */
    }

    .branding img { 
        width: 400px;
        height: auto;
        margin-bottom: 15px;
    }
        /* Caja de login más grande y centrada */
        .login-box {
            background: rgba(255, 255, 255, 0.2); /* blanco con transparencia */
            backdrop-filter: blur(15px);
           -webkit-backdrop-filter: blur(15px);
            padding: 60px;
            border-radius: 20px;
            box-shadow: 0 4px 25px rgba(0,0,0,0.35);
            width: 550px; /* más ancho */
            height: auto; /* adaptable al contenido */
            text-align: center;
            position: relative;
            left: -220px; /* movido a la izquierda */
        }

        .login-box h2 {
            margin-bottom: 25px;
            color: #fff;
            font-size: 2rem;
            font-weight: bold;
        }
        .login-box label {
            display: block;
            color: #fff;
            margin-bottom: 6px;
            text-align: left;
            font-size: 1rem;
        }
        .login-box input {
            width: 100%;
            padding: 14px;
            border-radius: 25px;
            border: 2px solid #ccc;
            margin-bottom: 18px;
            outline: none;
            font-size: 1rem;
        }
        .login-box input:focus {
            border-color: #238C00; /* verde más oscuro como la referencia */
        }
        .login-box button {
            background-color: #238C00; /* Verde exacto como la referencia */
            color: white;
            border: none;
            padding: 14px;
            border-radius: 25px;
            width: 100%;
            font-size: 1.1rem;
            cursor: pointer;
            font-weight: bold;
        }
        .login-box button:hover {
            background-color: #1c7300;
        }
        .login-box a {
            color: #39A900;
            text-decoration: none;
            font-size: 0.95rem;
        }
        .login-box img {
            margin-top: 18px;
            width: 85px;
        }
        .error-message {
            color: #ff6b6b;
            font-size: 0.85rem;
            text-align: left;
            margin-top: -10px;
            margin-bottom: 10px;
        }
        .error-input {
            border-color: #ff6b6b !important;
        }
        .session-status {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            font-size: 0.9rem;
        }

    </style>
</head>
<body>
    
    <!-- Izquierda: logo -->
    <div class="branding">
        <img src="{{ asset('img/BlancoJuris.png') }}" alt="JurisConnect">
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

            <p style="margin-top:10px;">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">
                        ¿Olvidó su contraseña?
                    </a>
                @endif
            </p>

            <img src="{{ asset('img/senablanco.png') }}" alt="Logo SENA">
        </form>
    </div>

</body>
</html>