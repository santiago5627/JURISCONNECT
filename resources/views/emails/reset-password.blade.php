<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Credenciales de Acceso - JustConnect SENA</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f4f8;
            color: #1f2937;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 640px;
            margin: 30px auto;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.08);
            padding: 40px;
        }

        .header {
            text-align: center;
        }

        .logo {
            width: 120px;
            margin-bottom: 10px;
        }

        .title {
            font-size: 24px;
            font-weight: 600;
            margin-top: 10px;
            color: #00471b;
        }

        .content {
            font-size: 16px;
            line-height: 1.8;
            margin-top: 30px;
        }

        .credentials {
            background-color: #f1f5f9;
            padding: 15px 20px;
            border-radius: 6px;
            margin-top: 20px;
            font-size: 15px;
        }

        .button-container {
            text-align: center;
            margin: 35px 0;
        }

        .button {
            background-color: #007a33;
            color: white;
            padding: 14px 32px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 16px;
            text-decoration: none;
            display: inline-block;
        }

        .button:hover {
            background-color: #006124;
        }

        .footer {
            font-size: 13px;
            color: #6b7280;
            margin-top: 40px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <img src="https://senasofiaplus.xyz/wp-content/uploads/2023/10/logo-del-sena-01.png" alt="Logo SENA" class="logo">
            <h1 class="title">Credenciales de Acceso</h1>
        </div>

        <div class="content">
            <p>Hola {{ $user->name }},</p>

            <p>Se ha creado tu cuenta en el sistema <strong>JustConnect SENA</strong>.</p>

            <p><strong>Tus credenciales de acceso son:</strong></p>
            <div class="credentials">
                <p><strong>Correo:</strong> {{ $user->email }}</p>
                <p><strong>Contraseña temporal:</strong> {{ $plainPassword }}</p>
            </div>

            <p>Por seguridad, debes cambiar tu contraseña lo antes posible.</p>

            <div class="button-container">
                <a href="{{ $resetUrl }}" class="button">
                    Cambiar mi contraseña
                </a>
            </div>
        </div>

        <div class="footer">
            <p>Gracias,<br>El equipo de JustConnect SENA</p>
            <p><small>Este es un mensaje automático. Por favor, no respondas a este correo.</small></p>
        </div>
    </div>
</body>

</html>
