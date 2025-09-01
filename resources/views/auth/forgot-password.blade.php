<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>JurisConnect SENA - Recuperar Contraseña</title>
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

        /* Izquierda: logo */
        .branding {
            color: white;
            text-align: center;
            position: relative;
            left: 250px;
        }
        .branding img { 
            width: 380px;
            height: auto;
            margin-bottom: 15px;
        }

        /* Caja forgot password */
        .forgot-box {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            padding: 50px;
            border-radius: 20px;
            box-shadow: 0 4px 25px rgba(0,0,0,0.35);
            width: 480px;
            text-align: center;
            position: relative;
            left: -220px;
        }

        .forgot-box h2 {
            margin-bottom: 15px;
            color: #fff;
            font-size: 2rem;
            font-weight: bold;
        }

        .forgot-box p {
            color: #f0f0f0;
            font-size: 0.95rem;
            margin-bottom: 20px;
        }

        .forgot-box label {
            display: block;
            color: #fff;
            margin-bottom: 6px;
            text-align: left;
            font-size: 1rem;
        }

        .forgot-box input {
            width: 100%;
            padding: 14px;
            border-radius: 25px;
            border: 2px solid #ccc;
            margin-bottom: 18px;
            outline: none;
            font-size: 1rem;
        }
        .forgot-box input:focus {
            border-color: #238C00;
        }

        .btn-primary {
            background-color: #238C00;
            color: white;
            border: none;
            padding: 14px;
            border-radius: 25px;
            width: 100%;
            font-size: 1.1rem;
            cursor: pointer;
            font-weight: bold;
            margin-top: 10px;
        }
        .btn-primary:hover {
            background-color: #1c7300;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
            border: none;
            padding: 14px;
            border-radius: 25px;
            width: 100%;
            font-size: 1.1rem;
            cursor: pointer;
            font-weight: bold;
            margin-top: 10px;
        }
        .btn-secondary:hover {
            background-color: #545b62;
        }

        .forgot-box img {
            margin-top: 20px;
            width: 85px;
        }
    </style>
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
