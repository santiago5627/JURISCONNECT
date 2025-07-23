<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecimiento de Contraseña</title>
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
        .warning {
            background-color: #fffbea;
            border-left: 5px solid #f59e0b;
            padding: 15px 20px;
            border-radius: 6px;
            margin-top: 25px;
            font-size: 14px;
            color: #92400e;
        }
        .alternative-link {
            font-size: 14px;
            margin-top: 15px;
            color: #007a33;
            word-break: break-word;
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
            <h1 class="title">Restablecimiento de Contraseña</h1>
        </div>

        <div class="content">
            <p>Hola {{ $user->name }},</p>

            <p>Recibiste este correo porque solicitaste restablecer tu contraseña en el <strong>Sistema Legal del SENA</strong>.</p>

<div class="button-container">
    <a href="{{ $url }}" class="button" style="color: #ffffff !important; text-decoration: none !important;">
        Restablecer Contraseña
    </a>
</div>


            <p>Este enlace es válido durante los próximos <strong>30 minutos</strong>.</p>

            <div class="warning">
                ⚠️ Si no solicitaste este cambio, puedes ignorar este mensaje. Tu cuenta está segura.
            </div>

            <p>Si el botón anterior no funciona, copia y pega el siguiente enlace en tu navegador:</p>

            <div class="alternative-link">{{ $url }}</div>
        </div>

        <div class="footer">
            <p>Saludos,<br>Equipo del Sistema Legal del SENA</p>
            <p><small>Este es un mensaje automático. Por favor, no respondas a este correo.</small></p>
        </div>
    </div>
</body>
</html>
