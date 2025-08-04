<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>JurisConnect SENA - Recuperar Contraseña</title>
  <link rel="stylesheet" href="{{ asset('styles.css') }}">
</head>

<body>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: Arial, sans-serif;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      position: relative;
      background-color: #ffffff;
      overflow: hidden;
    }

    /* Franja verde superior */
    body::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      height: 80px;
      width: 100%;
      background-color: #39A900;
      z-index: 0;
    }

    /* Onda más oscura (capa inferior) */
    .wave1 {
      position: absolute;
      bottom: 0;
      left: 0;
      width: 100%;
      height: 850px;
      background-color: #39A900;
      clip-path: polygon(0% 100%, 0% 50%, 50% 70%, 100% 50%, 100% 100%);
      z-index: 1;
    }

    /* Onda intermedia (verde medio) */
    .wave2 {
      position: absolute;
      bottom: 0;
      left: 0;
      width: 100%;
      height: 560px;
      background-color: #8dc73f;
      clip-path: polygon(0% 100%, 0% 60%, 50% 75%, 100% 60%, 100% 100%);
      z-index: 2;
    }

    /* Onda más clara (capa superior) */
    .wave3 {
      position: absolute;
      bottom: 0;
      left: 0;
      width: 100%;
      height: 300px;
      background-color: #4e9b10;
      clip-path: polygon(0% 100%, 0% 65%, 50% 78%, 100% 65%, 100% 100%);
      z-index: 3;
    }

    /* Logo y título fuera del contenedor */
    .logo-arriba {
      z-index: 10;
      margin-bottom: 20px;
      text-align: center;
    }

    .Titulo_Sena {
      z-index: 10;
      margin-bottom: 30px;
      text-align: center;
    }

    .Titulo_Sena h2 {
      font-size: 2rem;
      font-family: 'Times New Roman', serif;
      text-transform: uppercase;
      color: #000000;
      font-weight: bold;
      letter-spacing: 2px;
    }

    .login-container {
      z-index: 10;
      background-color: white;
      border-radius: 10px;
      text-align: center;
      padding: 30px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
      max-width: 600px;
      width: 100%;
      margin: 0 20px;
    }

    /* Estilos mejorados para las alertas */
    .alert {
      padding: 15px 20px;
      margin-bottom: 25px;
      border-radius: 8px;
      font-size: 16px;
      font-weight: 500;
      position: relative;
      border-left: 4px solid;
      animation: slideIn 0.3s ease-out;
    }

    .alert-success {
      background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
      color: #155724;
      border-left-color: #28a745;
      box-shadow: 0 2px 10px rgba(40, 167, 69, 0.2);
    }

    .alert-success::before {
      content: "✓";
      position: absolute;
      left: 15px;
      top: 50%;
      transform: translateY(-50%);
      font-size: 20px;
      font-weight: bold;
      color: #28a745;
    }

    .alert-success p {
      margin-left: 25px;
      margin-bottom: 0;
    }

    .alert-danger {
      background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
      color: #721c24;
      border-left-color: #dc3545;
      box-shadow: 0 2px 10px rgba(220, 53, 69, 0.2);
    }

    .alert-danger::before {
      content: "⚠";
      position: absolute;
      left: 15px;
      top: 50%;
      transform: translateY(-50%);
      font-size: 20px;
      font-weight: bold;
      color: #dc3545;
    }

    .alert-danger p {
      margin-left: 25px;
      margin-bottom: 5px;
    }

    @keyframes slideIn {
      from {
        opacity: 0;
        transform: translateY(-20px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    form {
      text-align: left;
    }

    label {
      display: block;
      margin-bottom: 10px;
      font-weight: bold;
      font-size: 0.95rem;
      color: #000000;
    }

    input {
      width: 100%;
      padding: 10px;
      margin-bottom: 20px;
      border: 2px solid #ccc;
      border-radius: 5px;
      font-size: 1rem;
      transition: border-color 0.3s ease;
    }

    input:focus {
      outline: none;
      border-color: #39A900;
    }

    button[type="submit"] {
      display: block;
      margin: 10px auto 0 auto;
      width: 40%;
      background-color: #39A900;
      color: white;
      padding: 11px;
      font-weight: bold;
      border: none;
      border-radius: 20px;
      cursor: pointer;
      font-size: 1rem;
      transition: background-color 0.3s ease;
      text-align: center;
    }

    button[type="submit"]:hover {
      background-color: #2e8600;
    }

    /* Estilos para el enlace que simula un botón */
    .btn-link {
      display: block;
      margin: 10px auto 0 auto;
      width: 40%;
      background-color: #6c757d;
      color: white;
      padding: 11px;
      font-weight: bold;
      border: none;
      border-radius: 20px;
      cursor: pointer;
      font-size: 1rem;
      transition: background-color 0.3s ease;
      text-align: center;
      text-decoration: none;
      line-height: 1.2;
    }

    .btn-link:hover {
      background-color: #5a6268;
      text-decoration: none;
    }

    .forgot-link a {
      color: #39A900;
      text-decoration: none;
    }

    .forgot-link a:hover {
      text-decoration: underline;
    }

    .logo_container {
      padding: 20px 0;
      text-align: center;
    }

    .Correo {
      margin-top: 5px;
      padding: auto;
      font-size: x-large;
      font-weight: 700;
    }

    .p {
      font-family: 'DejaVu Sans', sans-serif;
      font-size: 16px;
      color: #333;
      margin-bottom: 30px;
    }

    /* Responsive */
    @media (max-width: 768px) {
      .login-container {
        margin: 0 10px;
        padding: 20px;
      }

      .Titulo_Sena h2 {
        font-size: 1.5rem;
      }

      .alert {
        font-size: 14px;
        padding: 12px 15px;
      }

      .alert-success::before,
      .alert-danger::before {
        font-size: 18px;
      }

      .alert-success p,
      .alert-danger p {
        margin-left: 20px;
      }
    }
  </style>
  <!-- Ondas del fondo -->
  <div class="wave1"></div>
  <div class="wave2"></div>
  <div class="wave3"></div>

  <!-- Logo institucional arriba -->
  <div class="logo-arriba">
    <img src="{{ asset('img/LogoInsti.png') }}" width="100px">
  </div>

  <!-- Título -->
  <div class="Titulo_Sena">
    <h2>JURISCONNECT SENA</h2>
  </div>

  <div class="login-container">
    <!-- Mostrar estado de la sesión (éxito o error) -->
    @if (session('status'))
    <div class="alert alert-success">
      <p>Hemos enviado un enlace de restablecimiento de contraseña a tu correo electrónico.</p>
    </div>
    @endif

    <!-- Mostrar errores de validación -->
    @if ($errors->any())
    <div class="alert alert-danger">
      @foreach ($errors->all() as $error)
      <p>{{ $error }}</p>
      @endforeach
    </div>
    @endif

    <!-- Formulario -->
    <form method="POST" action="{{ route('password.email') }}">
      @csrf

      <div class="p">
        Ingresa tu correo electrónico y te enviaremos un enlace para que puedas restablecerla de forma segura.
      </div>

      <div class="Correo">
        <label for="email">Correo Electrónico</label>
      </div>

      <input type="email"
        name="email"
        id="email"
        value="{{ old('email') }}"
        required
        autofocus>

      <button type="submit">Enviar</button>

      <a href="{{ route('login') }}" class="btn-link">
        Volver al Login
      </a>
    </form>

    <!-- Logo del SENA abajo -->
    <div class="logo_container">
      <img src="{{ asset('img/LogoSena_Verde.png') }}" width="100px">
    </div>
  </div>
</body>

</html>