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
      min-height: 100vh;
      display: flex;
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
      background-color: #00b140;
      z-index: 0;
    }

    /* Onda más oscura (capa inferior) */
    .wave1 {
      position: absolute;
      bottom: 0;
      left: 0;
      width: 100%;
      height: 350px;
      background-color: #39A900;
      clip-path: polygon(0% 100%, 0% 50%, 50% 70%, 100% 50%, 100% 100%);
      z-index: 0;
    }

    /* Onda intermedia (verde medio) */
    .wave2 {
      position: absolute;
      bottom: 0;
      left: 0;
      width: 100%;
      height: 350px;
      background-color: #66cc66;
      clip-path: polygon(0% 100%, 0% 60%, 50% 75%, 100% 60%, 100% 100%);
      z-index: 1;
    }

    /* Onda más clara (capa superior) */
    .wave3 {
      position: absolute;
      bottom: 0;
      left: 0;
      width: 100%;
      height: 400px;
      background-color: #b2e3b2;
      clip-path: polygon(0% 100%, 0% 65%, 50% 78%, 100% 65%, 100% 100%);
      z-index: 2;
    }

    .login-container {
      z-index: 3;
      background-color: white;
      padding: 2rem 3rem;
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
      text-align: center;
      position: relative;
    }

    .logo-arriba {
      width: 60px;
      margin-bottom: 10px;
    }

    h2 {
      font-size: 1.5rem;
      margin-bottom: 20px;
      font-family: 'Georgia', serif;
      text-transform: uppercase;
    }

    form {
      text-align: left;
    }

    label {
      display: block;
      margin-bottom: 5px;
      font-weight: bold;
      font-size: 0.95rem;
    }

    input {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: 2px solid #ccc;
      border-radius: 5px;
      font-size: 1rem;
    }

    button {
      width: 100%;
      background-color: #00b140;
      color: white;
      padding: 12px;
      font-weight: bold;
      border: none;
      border-radius: 20px;
      cursor: pointer;
      margin-top: 10px;
    }

    button:hover {
      background-color: #009a36;
    }

    .forgot-link {
      margin-top: 10px;
      font-size: 0.9rem;
      text-align: right;
    }

    .logo-abajo {
      margin-top: 20px;
      width: 80px;
    }
  </style>
</head>
<body>

  <!-- Ondas del fondo -->
  <div class="wave1"></div>
  <div class="wave2"></div>
  <div class="wave3"></div>

  <div class="login-container">
    
    <!-- Logo institucional arriba -->
    <img src="{{ asset('img/logo_app.jpeg') }}" alt="Logo Justicia" class="logo-arriba">
    
    <!-- Título -->
    <h2>JURISCONNECT SENA</h2>

    <!-- Formulario -->
    <form method="POST" action="{{ route('login') }}">
      @csrf

      <label for="email">Correo Electrónico</label>
      <input type="email" name="email" id="email" required autofocus>

      <label for="password">Contraseña</label>
      <input type="password" name="password" id="password" required>

      <button type="submit">Iniciar Sesión</button>

      <div class="forgot-link">
        @if (Route::has('password.request'))
          <a href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
        @endif
      </div>
    </form>

    <!-- Logo del SENA abajo -->
    <img src="{{ asset('img/sena_app.jpeg') }}" alt="Logo SENA" class="logo-abajo">
  </div>

</body>
</html>
