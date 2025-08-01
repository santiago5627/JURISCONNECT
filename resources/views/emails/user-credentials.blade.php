<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bienvenido - Credenciales de acceso</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            background-color: #ffffff;
            padding: 30px;
            border: 1px solid #e0e0e0;
        }
        .credentials-box {
            background-color: #f8f9fa;
            border: 2px solid #28a745;
            border-radius: 8px;
            padding: 20px;
            margin: 25px 0;
            text-align: center;
        }
        .credential-item {
            margin: 15px 0;
            padding: 10px;
            background-color: white;
            border-radius: 5px;
            border: 1px solid #dee2e6;
        }
        .credential-label {
            font-weight: bold;
            color: #495057;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .credential-value {
            font-family: 'Courier New', monospace;
            font-size: 16px;
            color: #212529;
            font-weight: bold;
            margin-top: 5px;
            padding: 8px;
            background-color: #e9ecef;
            border-radius: 4px;
            word-break: break-all;
        }
        .login-button {
            display: inline-block;
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            margin: 20px 0;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: transform 0.2s;
        }
        .login-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(0,0,0,0.15);
        }
        .security-notice {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .security-notice strong {
            color: #d63384;
        }
        .instructions {
            background-color: #e7f3ff;
            border-left: 4px solid #007bff;
            padding: 15px;
            margin: 20px 0;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 0 0 10px 10px;
            text-align: center;
            font-size: 12px;
            color: #6c757d;
            border-top: 1px solid #e0e0e0;
        }
        .divider {
            height: 2px;
            background: linear-gradient(to right, #667eea, #764ba2);
            margin: 20px 0;
            border-radius: 1px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1> ¡Bienvenido {{ $user->name }}!</h1>
        <p>Tu cuenta ha sido creada exitosamente</p>
    </div>
    
    <div class="content">
        <p>Hola <strong>{{ $user->name }}</strong>,</p>
        
        <p>Tu cuenta en <strong>{{ config('app.name') }}</strong> ha sido creada correctamente. A continuación encontrarás tus credenciales de acceso:</p>
        
        <div class="credentials-box">
            <h3 style="margin-top: 0; color: #28a745;"> Tus Credenciales</h3>
            
            <div class="credential-item">
                <div class="credential-label"> Email / Usuario</div>
                <div class="credential-value">{{ $user->email }}</div>
            </div>
            
            <div class="credential-item">
                <div class="credential-label"> Contraseña Temporal</div>
                <div class="credential-value">{{ $password }}</div>
            </div>
        </div>
        
        <div style="text-align: center;">
            <a href="{{ $loginUrl }}" class="login-button">
                 Acceder a Mi Cuenta
            </a>
        </div>
        
        <div class="divider"></div>
        
        <div class="security-notice">
            <strong> Importante - Seguridad:</strong>
            <ul style="margin: 10px 0 0 20px;">
                <li><strong>Cambia tu contraseña</strong> después del primer inicio de sesión</li>
                <li><strong>No compartas</strong> estas credenciales con nadie</li>
                <li><strong>Guarda</strong> esta información en un lugar seguro</li>
                <li>Elimina este email después de cambiar tu contraseña</li>
            </ul>
        </div>
        
        <div class="instructions">
            <h4 style="margin-top: 0;"> Pasos para comenzar:</h4>
            <ol>
                <li>Haz clic en el botón "Acceder a Mi Cuenta" o ve a: <a href="{{ $loginUrl }}">{{ $loginUrl }}</a></li>
                <li>Ingresa tu email: <code>{{ $user->email }}</code></li>
                <li>Ingresa tu contraseña temporal</li>
                <li>Cambia tu contraseña por una de tu elección</li>
                <li>¡Comienza a usar la plataforma!</li>
            </ol>
        </div>
        
        <p>Si tienes alguna pregunta o necesitas ayuda, no dudes en contactarnos.</p>

    </div>
    
    <div class="footer">
        <p><strong>{{ config('app.name') }}</strong></p>
        <p>Este es un mensaje automático, por favor no respondas a este email.</p>
        <p>© {{ date('Y') }} {{ config('app.name') }}. Todos los derechos reservados.</p>
    </div>
</body>
</html>