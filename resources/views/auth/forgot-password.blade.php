<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JurisConnect SENA - Recuperar Contraseña</title>
    <link rel="stylesheet" href="{{ asset('/Css/recuperar.css') }}">
</head>
<body>
    <div class="background-image">
        <img src="{{ asset('img/Login.jpg') }}" alt="Fondo de Pantalla" class="background-image">
    </div>

    <div class="main-container">
        <!-- Sección izquierda con logo y título -->
        <div class="logo-jurisconnect">
            <img src="{{ asset('img/LogoJ.png') }}" alt="Logo JurisConnect" class="logo-jurisconnect">
        </div>

        <!-- Contenedor del formulario -->
        <div class="form-container">
            <h2 class="form-title">Recuperar Contraseña</h2>
            <p class="form-description">
                Ingresa tu correo de recuperación
            </p>

            <!-- Formulario -->
            <form id="passwordResetForm">
                <div class="form-group">
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        class="form-input" 
                        placeholder="xxxxxxxxxxxx"
                        required 
                        autofocus
                    >
                </div>

                <div class="button-group">
                    <button type="button" class="btn btn-back" onclick="window.location='{{ url('/') }}'">
                        Volver
                    </button>
                    <button type="submit" class="btn btn-next">
                        Siguiente
                    </button>
                </div>
            </form>

            <!-- Logo SENA -->
            <div class="left-section">
                <img src="{{ asset('img/Sena.png') }}" alt="Logo JurisConnect">
            </div>
        </div>
    </div>
</body>
</html>