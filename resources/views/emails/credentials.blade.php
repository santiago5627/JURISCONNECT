<!DOCTYPE html>
<html>
<head>
    <title>Credenciales de Acceso</title>
</head>
<body>
    <h2>Hola {{ $user->name }},</h2>
    <p>Has sido registrado como abogado en el sistema jurídico.</p>
    <p>Estas son tus credenciales de acceso:</p>

    <ul>
        <li><strong>Correo:</strong> {{ $user->email }}</li>
        <li><strong>Contraseña:</strong> {{ $plainPassword }}</li>
    </ul>

    <p>Por favor inicia sesión y cambia tu contraseña lo antes posible.</p>

    <p>Gracias,<br>El equipo del sistema jurídico</p>
</body>
</html>
