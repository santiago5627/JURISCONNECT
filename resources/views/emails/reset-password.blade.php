<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecimiento de Contraseña</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f7f7f7;
        }
        .container {
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #2563eb;
            margin-bottom: 10px;
        }
        .title {
            font-size: 28px;
            color: #1f2937;
            margin-bottom: 20px;
        }
        .content {
            margin-bottom: 30px;
            font-size: 16px;
            line-height: 1.8;
        }
        .button {
            display: inline-block;
            background-color: #2563eb;
            color: white;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            font-size: 16px;
            margin: 20px 0;
        }
        .button:hover {
            background-color: #1d4ed8;
        }
        .button-container {
            text-align: center;
            margin: 30px 0;
        }
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            font-size: 14px;
            color: #6b7280;
        }
        .warning {
            background-color: #fef3c7;
            border: 1px solid #f59e0b;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            font-size: 14px;
        }
        .alternative-link {
            word-break: break-all;
            color: #2563eb;
            font-size: 14px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">{{ config('app.name') }}</div>
            <h1 class="title">Restablecimiento de Contraseña</h1>
        </div>

        <div class="content">
            <p>Hola {{ $user->name }},</p>
            
            <p>Recibiste este email porque hemos recibido una solicitud de restablecimiento de contraseña para tu cuenta.</p>
            
            <div class="button-container">
                <a href="{{ $url }}" class="button">Restablecer Contraseña</a>
            </div>
            
            <p>Este enlace de restablecimiento de contraseña expirará en 30 minutos.</p>
            
            <div class="warning">
                <strong>⚠️ Importante:</strong> Si no solicitaste un restablecimiento de contraseña, no es necesario que realices ninguna acción. Tu cuenta permanece segura.
            </div>
            
            <p>Si tienes problemas haciendo clic en el botón "Restablecer Contraseña", copia y pega la siguiente URL en tu navegador web:</p>
            
            <div class="alternative-link">
                {{ $url }}
            </div>
        </div>

        <div class="footer">
            <p>Saludos,<br>El equipo de {{ config('app.name') }}</p>
            
            <p style="margin-top: 20px;">
                <small>
                    Este es un email automático, por favor no respondas a este mensaje. 
                    Si tienes alguna pregunta, contacta a nuestro equipo de soporte.
                </small>
            </p>
        </div>
    </div>
</body>
</html>