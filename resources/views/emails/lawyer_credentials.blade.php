<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Credenciales de acceso</title>
</head>
<body>
    <h2>¡Hola {{ $user->name }}!</h2>
    <p>Has sido registrado como abogado en el sistema JustConnect del SENA.</p>
    <p><strong>Correo:</strong> {{ $user->email }}</p>
    <p><strong>Contraseña:</strong> {{ $plainPassword }}</p>
    <p>Puedes iniciar sesión en <a href="{{ url('/login') }}">{{ url('/login') }}</a></p>
    <p>Para cambiar tu contraseña, haz clic aquí: <a href="{{ url('/forgot-password') }}">Cambiar contraseña</a></p>
    <br>
    <p>Saludos,</p>
    <p>Equipo JustConnect</p>
</body>
</html>
