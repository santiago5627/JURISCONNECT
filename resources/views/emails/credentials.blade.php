<!DOCTYPE html>
<html>

<head>
    <title>Credenciales de Acceso</title>
</head>

<body>
    <h1>Hola {{ $user->name }},</h1>

<p>Se te ha creado una cuenta en el sistema <strong>JustConnect SENA</strong>.</p>

<p><strong>Correo:</strong> {{ $user->email }}<br>
<strong>Contraseña:</strong> {{ $plainPassword }}</p>

<p>Ingresa al sistema y cambia tu contraseña desde tu perfil si lo deseas.</p>

<p>Saludos,<br>El equipo de soporte</p>

</body>

</html>